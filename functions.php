<?php
// functions.php

// ดึงข้อมูลรูปภาพจากฐานข้อมูล
function getPlaceImages($conn, $place_id) {
    $stmt = $conn->prepare("SELECT * FROM place_images WHERE place_id = ?");
    $stmt->bind_param("i", $place_id);
    $stmt->execute();
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    
}


// ฟังก์ชันสำหรับดึงชื่อผู้ใช้ปัจจุบัน
function getCurrentUserName($conn) {
    if (checkLogin()) {
        $user_id = $_SESSION['user_id'];
        $sql = "SELECT username FROM users WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();
            return $row['username'];
        }
    }
    return null; // ถ้าไม่ได้ล็อกอิน หรือหาชื่อผู้ใช้ไม่เจอ
}

// ฟังก์ชันสำหรับดึงข้อมูลสถานที่ท่องเที่ยว (ตามหมวดหมู่ และ/หรือ คำค้น)
function getPlacesBySearchAndCategory($conn, $category = '', $search_term = '', $limit = 20) {
    $sql = "SELECT * FROM places";
    $params = [];
    $types = "";

    $whereClauses = [];

    if ($category) {
        $whereClauses[] = "category = ?";
        $params[] = $category;
        $types .= "s";
    }

    if ($search_term) {
        $whereClauses[] = "name LIKE ?";  // Use LIKE for partial matching
        $params[] = "%" . $search_term . "%"; // Add wildcards for partial matching
        $types .= "s";
    }

    if (!empty($whereClauses)) {
        $sql .= " WHERE " . implode(" AND ", $whereClauses);
    }

    $sql .= " ORDER BY id DESC LIMIT $limit";
    $stmt = $conn->prepare($sql);

    if (!empty($params)) {
        $stmt->bind_param($types, ...$params); // Use the splat operator (...)
    }

    $stmt->execute();
    $result = $stmt->get_result();
    $places = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $places[] = $row;
        }
    }
    $stmt->close();
    return $places;
}

// ฟังก์ชันสำหรับดึงข้อมูลสถานที่ท่องเที่ยวเดียว
function getPlace($conn, $id) {
  $sql = "SELECT * FROM places WHERE id = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("i", $id);
  $stmt->execute();
  $result = $stmt->get_result();
  if ($result->num_rows > 0) {
      return $result->fetch_assoc();
  }
  return null;
}

// ฟังก์ชันสำหรับดึงรีวิวของสถานที่
function getReviews($conn, $place_id) {
    $sql = "SELECT * FROM reviews WHERE place_id = ? ORDER BY review_date DESC";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $place_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $reviews = [];
    if ($result->num_rows > 0) {
      while($row = $result->fetch_assoc()) {
          $reviews[] = $row;
      }
  }
    return $reviews;
}

// เพิ่มฟังก์ชันสำหรับ User
function registerUser($conn, $username, $password) {
    $hashed_password = password_hash($password, PASSWORD_DEFAULT); // เข้ารหัส password
    $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $username, $hashed_password);
    return $stmt->execute();
}

function loginUser($conn, $username, $password) {
    $sql = "SELECT id, password, is_admin FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            // ล็อกอินสำเร็จ
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['is_admin'] = $row['is_admin'];
            return true;
        }
    }
    return false;
}

function checkLogin() {
    // Start the session ONLY if it hasn't been started already
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    if (!isset($_SESSION['user_id'])) {
        return false; // ยังไม่ได้ login
    }
    return true;
}

function isAdmin() {
    return isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1;
}

function logout() {
   if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    session_destroy();
}

// ฟังก์ชันสำหรับเพิ่มรีวิว *แก้ไข* ให้รับ user_id
function addReview($conn, $place_id, $user_id, $rating, $comment) {
  $sql = "INSERT INTO reviews (place_id, user_id, rating, comment) VALUES (?, ?, ?, ?)";
  $stmt = $conn->prepare($sql);

  // "iiss" หมายถึง: integer, integer, string, string
  $stmt->bind_param("iiis", $place_id, $user_id, $rating, $comment);
  return $stmt->execute();
}

function checkAdminLogin() {
    // session_start();  //  removed
    if (!checkLogin() || !isAdmin()) {
        header("Location: ../login.php"); // ถ้าไม่ได้ล็อกอิน หรือไม่ใช่แอดมิน *แก้ path*
        exit;
    }
}



// ฟังก์ชันสำหรับดึงข้อมูลผู้ใช้ด้วย ID
 function getUserById($conn, $user_id) {
     $sql = "SELECT id, username FROM users WHERE id = ?";
     $stmt = $conn->prepare($sql);
     $stmt->bind_param("i", $user_id);
     $stmt->execute();
     $result = $stmt->get_result();

     if ($result->num_rows === 1) {
         return $result->fetch_assoc(); // คืนค่าเป็น associative array
     }
     return null; // ไม่พบผู้ใช้
 }

// ฟังก์ชันสำหรับลบสถานที่ (ใช้ใน admin/delete_place.php)
function deletePlace($conn, $place_id) {
    // ลบ reviews ที่เกี่ยวข้องก่อน (foreign key constraint)
    $sql_delete_reviews = "DELETE FROM reviews WHERE place_id = ?";
    $stmt_reviews = $conn->prepare($sql_delete_reviews);
    $stmt_reviews->bind_param("i", $place_id);
    $stmt_reviews->execute();
    $stmt_reviews->close();


    // ลบสถานที่
    $sql_delete_place = "DELETE FROM places WHERE id = ?";
    $stmt_place = $conn->prepare($sql_delete_place);
    $stmt_place->bind_param("i", $place_id);
    $result = $stmt_place->execute();
    $stmt_place->close();

    return $result;
}

// ฟังก์ชันสำหรับเพิ่มสถานที่ (ใช้ใน admin/add_place.php, admin/edit_place.php)
function addPlace($conn, $name, $description, $image, $address, $category, $latitude, $longitude, $contact, $opening_hours) {

  $sql = "INSERT INTO places (name, description, image, address, category, latitude, longitude, contact, opening_hours) VALUES (?, ?, ?, ?, ?, ?, ?, ?,?)";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("sssssddss", $name, $description, $image, $address, $category, $latitude, $longitude, $contact, $opening_hours);
  $result = $stmt->execute();
  $stmt->close();
  return $result;
}

function getAllCategories($conn) {
    $sql = "SELECT * FROM categories ORDER BY name ASC";
    $result = $conn->query($sql); // Query แบบธรรมดาสำหรับ SELECT * โดยไม่มี parameter
    $categories = [];
    if ($result && $result->num_rows > 0) { // เพิ่มการตรวจสอบ $result
        while($row = $result->fetch_assoc()) {
            $categories[] = $row;
        }
    } elseif (!$result) {
        error_log("SQL query failed in getAllCategories: " . $conn->error);
    }
    return $categories;
}

// ฟังก์ชันสำหรับแก้ไขสถานที่
function updatePlace($conn, $id, $name, $description, $image, $address, $category, $latitude, $longitude, $contact, $opening_hours) {
    $sql = "UPDATE places SET name = ?, description = ?, image = ?, address = ?, category = ?, latitude = ?, longitude =?, contact = ?, opening_hours = ? WHERE id = ?";
     $stmt = $conn->prepare($sql);

    // 'sssssddssi' types: string, string, string, string, string, double, double, string, string, int
    $stmt->bind_param("sssssddssi", $name, $description, $image, $address, $category, $latitude, $longitude, $contact, $opening_hours, $id);
    $result = $stmt->execute();
     $stmt->close();

     return $result;

     
}
?>

