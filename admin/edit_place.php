<?php
require_once('../config.php');
require_once('../functions.php');
checkAdminLogin();

$message = '';
$stay_on_page = false; // Flag to control redirection

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: dashboard.php");
    exit;
}

$place_id = $_GET['id'];
$place = getPlace($conn, $place_id);

if (!$place) {
    header("Location: dashboard.php");
    exit;
}

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
    $image_path = $place['image'];

    if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
        // ... (your image upload and deletion code - same as before) ...
        $tmp_name = $_FILES['image']['tmp_name'];
        $file_name = basename($_FILES['image']['name']);
        $unique_name = time() . '_' . $file_name;
        $image_path = $upload_dir . $unique_name;
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
             $file_type = mime_content_type($tmp_name);
             if (in_array($file_type, $allowed_types)) {
                 if (move_uploaded_file($tmp_name, $image_path)) {
                      // *** ลบรูปเก่า (ถ้ามี) ***
                     if (!empty($place['image']) && file_exists('../' . $place['image'])) {
                         unlink('../' . $place['image']);
                     }
                 } else {
                     $message = "เกิดข้อผิดพลาดในการอัปโหลดไฟล์";
                     $image_path = $place['image']; // ถ้า upload ไม่สำเร็จ ให้ใช้รูปเดิม
                 }
             }else{
                $message = "ประเภทไฟล์ไม่ถูกต้อง (อนุญาตเฉพาะ JPG, PNG, GIF)";
                $image_path = $place['image'];
             }
    }

    $sql = "UPDATE places SET name=?, description=?, image=?, address=?, category=?, latitude=?, longitude=?, contact=?, opening_hours=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssssi", $name, $description, $image_path, $address, $category, $latitude, $longitude, $contact, $opening_hours, $place_id);

    if ($stmt->execute()) {
        $message = "แก้ไขข้อมูลสถานที่สำเร็จ!";
        $place = getPlace($conn, $place_id); // Re-fetch to update $place

        // Check which button was clicked
        if (isset($_POST['save_and_stay'])) {
            $stay_on_page = true;
        }

    } else {
        $message = "เกิดข้อผิดพลาดในการแก้ไข: " . $stmt->error;
    }

    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>แก้ไขสถานที่</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>แก้ไขสถานที่</h2>

        <?php if ($message): ?>
            <div class="alert <?php echo (strpos($message, 'สำเร็จ') !== false) ? 'alert-success' : 'alert-danger'; ?>" role="alert">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <form method="post" action="edit_place.php?id=<?php echo $place_id; ?>" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="name" class="form-label">ชื่อสถานที่:</label>
                <input type="text" id="name" name="name" class="form-control" value="<?php echo htmlspecialchars($place['name']); ?>" required>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">รายละเอียด:</label>
                <textarea id="description" name="description" class="form-control"><?php echo htmlspecialchars($place['description']); ?></textarea>
            </div>

            <div class="mb-3">
                <label for="image" class="form-label">รูปภาพ:</label>
                <input type="file" id="image" name="image" class="form-control" accept="image/*">
                <?php if ($place['image']): ?>
                    <div class="mt-2">
                        <p>รูปปัจจุบัน:</p>
                        <img src="<?php echo htmlspecialchars($place['image']); ?>" alt="รูปสถานที่" style="max-width: 200px;">
                    </div>
                <?php endif; ?>
            </div>

            <div class="mb-3">
                <label for="address" class="form-label">ที่อยู่:</label>
                <input type="text" id="address" name="address" class="form-control" value="<?php echo htmlspecialchars($place['address']); ?>">
            </div>

            <div class="mb-3">
                <label for="category" class="form-label">หมวดหมู่:</label>
                <select id="category" name="category" class="form-select" required>
                    <option value="">-- เลือกหมวดหมู่ --</option>
                    <option value="คาเฟ่" <?php if ($place['category'] == 'คาเฟ่') echo 'selected'; ?>>คาเฟ่</option>
                    <option value="วัด" <?php if ($place['category'] == 'วัด') echo 'selected'; ?>>วัด</option>
                    <option value="ร้านอาหาร" <?php if ($place['category'] == 'ร้านอาหาร') echo 'selected'; ?>>ร้านอาหาร</option>
                    <option value="ตลาด" <?php if ($place['category'] == 'ตลาด') echo 'selected'; ?>>ตลาด</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="latitude" class="form-label">Latitude:</label>
                <input type="text" id="latitude" name="latitude" class="form-control" value="<?php echo htmlspecialchars($place['latitude']); ?>">
            </div>

            <div class="mb-3">
                <label for="longitude" class="form-label">Longitude:</label>
                <input type="text" id="longitude" name="longitude" class="form-control" value="<?php echo htmlspecialchars($place['longitude']); ?>">
            </div>

            <div class="mb-3">
                <label for="contact" class="form-label">ข้อมูลติดต่อ:</label>
                <input type="text" id="contact" name="contact" class="form-control" value="<?php echo htmlspecialchars($place['contact']); ?>">
            </div>

            <div class="mb-3">
                <label for="opening_hours" class="form-label">เวลาเปิด-ปิด:</label>
                <input type="text" id="opening_hours" name="opening_hours" class="form-control" value="<?php echo htmlspecialchars($place['opening_hours']); ?>">
            </div>

            <div class="mb-3">
                <button type="submit" name="save_and_stay" class="btn btn-success"><i class="bi bi-save"></i> บันทึกแล้วอยู่ต่อ</button>
                <button type="submit" name="save_and_go" class="btn btn-primary"><i class="bi bi-arrow-right-circle"></i> บันทึกแล้วไปที่ Dashboard</button>
                
            </div>
        </form>

        <a href="dashboard.php" class="btn btn-secondary"><i class="bi bi-arrow-left-circle"></i> กลับไปหน้า Dashboard</a>
    </div>

    <!-- Bootstrap 5 JS (with Popper.js) -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>
