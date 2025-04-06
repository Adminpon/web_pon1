<?php
require_once('../config.php');
require_once('../functions.php');
checkAdminLogin();

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: dashboard.php");
    exit;
}

$place_id = $_GET['id'];

// ดึงข้อมูลสถานที่ (เพื่อใช้ลบรูปภาพ)
$place = getPlace($conn, $place_id);

if (deletePlace($conn, $place_id)) {
    // ลบรูปภาพ (ถ้ามี)
    if (!empty($place['image']) && file_exists('../' . $place['image'])) {
        unlink('../' . $place['image']);
    }
    header("Location: dashboard.php?message=deleted"); // ส่ง parameter ไปด้วย
    exit;
} else {
    header("Location: dashboard.php?message=error");
    exit;
}
?>