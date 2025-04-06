<?php
require_once('../config.php');
require_once('../functions.php');
checkAdminLogin();

// ดึงข้อมูลสถานที่ทั้งหมด
$places = getPlacesBySearchAndCategory($conn); // CORRECTED function call

// จัดการข้อความแจ้งเตือน (จาก delete_place.php)
$message = '';
if (isset($_GET['message'])) {
    if ($_GET['message'] == 'deleted') {
        $message = "ลบสถานที่เรียบร้อยแล้ว";
    } elseif ($_GET['message'] == 'error') {
        $message = "เกิดข้อผิดพลาดในการลบสถานที่";
    }
}
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Admin Dashboard</h2>

        <?php if ($message): ?>
            <div class="alert <?php echo ($_GET['message'] == 'deleted') ? 'alert-success' : 'alert-danger'; ?>" role="alert">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

             <!-- เพิ่มปุ่ม "เพิ่มสถานที่ใหม่" และ "จัดการปัญหา" ในแถวเดียวกัน -->
             <div class="mb-3 d-flex justify-content-between">
            <a href="add_place.php" class="btn btn-primary"><i class="bi bi-plus-circle"></i> เพิ่มสถานที่ใหม่</a>
            <a href="problem_db.php" class="btn btn-info"><i class="bi bi-gear"></i> จัดการปัญหา</a>
            </div>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>ภาพ</th>
                    <th>ชื่อสถานที่</th>
                    <th>หมวดหมู่</th>
                    <th>การจัดการ</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($places as $place): ?>
                    <tr>
                        <td><?php echo $place['id']; ?></td>
                        <td>
                            <?php if (!empty($place['image'])): ?>
                                <img src="../uploads/<?php echo $place['image']; ?>" alt="Image of <?php echo htmlspecialchars($place['name']); ?>" width="100">
                            <?php else: ?>
                                ไม่มีภาพ
                            <?php endif; ?>
                        </td>
                        <td><?php echo htmlspecialchars($place['name']); ?></td>
                        <td><?php echo htmlspecialchars($place['category']); ?></td>
                        <td>
                            <a href="edit_place.php?id=<?php echo $place['id']; ?>" class="btn btn-warning btn-sm"><i class="bi bi-pencil-square"></i> แก้ไข</a>
                            <a href="delete_place.php?id=<?php echo $place['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('คุณแน่ใจหรือไม่ที่จะลบ?');"><i class="bi bi-trash"></i> ลบ</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="d-flex justify-content-between">
            <a href="../index.php" class="btn btn-secondary"><i class="bi bi-house-door"></i> กลับหน้าหลัก</a>
            <a href="../logout.php" class="btn btn-danger"><i class="bi bi-box-arrow-right"></i> ออกจากระบบ</a>
        </div>
    </div>

    <!-- Bootstrap 5 JS (with Popper.js) -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>
