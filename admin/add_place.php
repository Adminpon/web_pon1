<?php
require_once('../config.php');
require_once('../functions.php');
checkAdminLogin();

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $address = $_POST['address'];
    $category = $_POST['category'];
    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];
    $contact = $_POST['contact'];
    $opening_hours = $_POST['opening_hours'];

    $upload_dir = '../uploads/';
    $image_paths = [];

    // ตรวจสอบการอัปโหลดหลายไฟล์
    if (isset($_FILES['image']) && count($_FILES['image']['error']) > 0) {
        foreach ($_FILES['image']['error'] as $key => $error) {
            if ($error == UPLOAD_ERR_OK) {
                $tmp_name = $_FILES['image']['tmp_name'][$key];
                $file_name = basename($_FILES['image']['name'][$key]);
                $unique_name = time() . '_' . $file_name;
                $image_path = $upload_dir . $unique_name;

                $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
                $file_type = mime_content_type($tmp_name);

                if (in_array($file_type, $allowed_types)) {
                    if (move_uploaded_file($tmp_name, $image_path)) {
                        // เพิ่มที่อยู่ของภาพลงใน array
                        $image_paths[] = $image_path;
                    } else {
                        $message = "เกิดข้อผิดพลาดในการอัปโหลดไฟล์: " . error_get_last()['message'];
                    }
                } else {
                    $message = "ประเภทไฟล์ไม่ถูกต้อง (อนุญาตเฉพาะ JPG, PNG, GIF)";
                }
            }
        }
    }

    // เพิ่มข้อมูลสถานที่ลงในตาราง places
    $sql = "INSERT INTO places (name, description, image, address, category, latitude, longitude, contact, opening_hours) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssss", $name, $description, $image_path, $address, $category, $latitude, $longitude, $contact, $opening_hours);

    if ($stmt->execute()) {
        $place_id = $stmt->insert_id;  // รับ place_id หลังจากเพิ่มข้อมูลสถานที่

        // เพิ่มข้อมูลภาพในตาราง place_images
        foreach ($image_paths as $image_path) {
            $sql_image = "INSERT INTO place_images (place_id, image_path) VALUES (?, ?)";
            $stmt_image = $conn->prepare($sql_image);
            $stmt_image->bind_param("is", $place_id, $image_path);
            $stmt_image->execute();
            $stmt_image->close();
        }

        header("Location: dashboard.php");
        exit;
    } else {
        $message = "เกิดข้อผิดพลาดในการเพิ่มข้อมูล: " . $stmt->error;
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เพิ่มสถานที่ใหม่</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            padding-top: 50px;
        }
        .form-container {
            max-width: 600px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="container form-container">
        <h2 class="mb-4">เพิ่มสถานที่ใหม่</h2>

        <?php if ($message): ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <form method="post" action="add_place.php" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="name" class="form-label">ชื่อสถานที่:</label>
                <input type="text" id="name" name="name" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">รายละเอียด:</label>
                <textarea id="description" name="description" class="form-control"></textarea>
            </div>

            <div class="mb-3">
                <label for="image" class="form-label">รูปภาพ:</label>
                <input type="file" id="image" name="image[]" class="form-control" accept="image/*" multiple>
            </div>


            <div class="mb-3">
                <label for="address" class="form-label">ที่อยู่:</label>
                <input type="text" id="address" name="address" class="form-control">
            </div>

            <div class="mb-3">
                <label for="category" class="form-label">หมวดหมู่:</label>
                <select id="category" name="category" class="form-select" required>
                    <option value="">-- เลือกหมวดหมู่ --</option>
                    <option value="คาเฟ่">คาเฟ่</option>
                    <option value="วัด">วัด</option>
                    <option value="ร้านอาหาร">ร้านอาหาร</option>
                    <option value="ตลาด">ตลาด</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="latitude" class="form-label">Latitude:</label>
                <input type="text" id="latitude" name="latitude" class="form-control">
            </div>

            <div class="mb-3">
                <label for="longitude" class="form-label">Longitude:</label>
                <input type="text" id="longitude" name="longitude" class="form-control">
            </div>

            <div class="mb-3">
                <label for="contact" class="form-label">ข้อมูลติดต่อ:</label>
                <input type="text" id="contact" name="contact" class="form-control">
            </div>

            <div class="mb-3">
                <label for="opening_hours" class="form-label">เวลาเปิด-ปิด:</label>
                <input type="text" id="opening_hours" name="opening_hours" class="form-control">
            </div>

            <button type="submit" class="btn btn-primary">เพิ่มสถานที่</button>
        </form>

        <div class="mt-4">
            <a href="dashboard.php" class="btn btn-secondary"><i class="bi bi-house-door"></i> กลับไปหน้า Dashboard</a>
        </div>
    </div>

    <!-- Bootstrap 5 JS (with Popper.js) -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>
