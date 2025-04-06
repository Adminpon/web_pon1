<?php
require_once('../config.php'); // เชื่อมต่อกับฐานข้อมูล

// ตรวจสอบว่า id ถูกส่งมาหรือไม่
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // ตรวจสอบให้แน่ใจว่า id เป็นตัวเลข
    if (is_numeric($id)) {
        // คำสั่ง SQL สำหรับลบข้อมูลที่มี id ที่ระบุ
        $sql = "DELETE FROM problem WHERE id = ?";

        // เตรียมคำสั่ง SQL
        $stmt = $conn->prepare($sql);

        // ผูกตัวแปร
        $stmt->bind_param('i', $id);

        // ตรวจสอบว่าเชื่อมต่อสำเร็จและลบข้อมูลได้หรือไม่
        if ($stmt->execute()) {
            // หากลบสำเร็จ ให้แสดงข้อความและกลับไปหน้าหลัก
            echo "<script>
                    alert('ลบข้อมูลสำเร็จ');
                    window.location.href = 'problem_db.php'; // เปลี่ยนไปยังหน้า problem_db.php
                  </script>";
        } else {
            echo "<script>alert('ไม่สามารถลบข้อมูลได้'); window.location.href = 'problem_db.php';</script>";
        }

        // ปิดการเชื่อมต่อฐานข้อมูล
        $stmt->close();
    } else {
        echo "<script>alert('ข้อมูลไม่ถูกต้อง'); window.location.href = 'problem_db.php';</script>";
    }
} else {
    // ถ้าไม่มี id ถูกส่งมาหรือไม่พบ
    echo "<script>alert('ไม่มีข้อมูลที่ต้องการลบ'); window.location.href = 'problem_db.php';</script>";
}

// ปิดการเชื่อมต่อฐานข้อมูล
$conn->close();
?>
