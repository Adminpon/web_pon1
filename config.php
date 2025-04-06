<?php
$db_host = 'localhost'; // หรือ IP ของ server
$db_user = 'root'; // ชื่อผู้ใช้ MySQL
$db_pass = ''; // รหัสผ่าน MySQL
$db_name = 'pon_db'; // ชื่อฐานข้อมูล

$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$conn->set_charset("utf8");
?>