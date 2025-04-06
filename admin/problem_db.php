<?php
require_once('../config.php');
require_once('../functions.php');
checkAdminLogin();

$places = getPlacesBySearchAndCategory($conn); // CORRECTED function call

// คำสั่ง SQL เพื่อดึงข้อมูลจากตาราง problem
$sql = "SELECT id, username, phone, email, subject, problem_details FROM problem";
$result = $conn->query($sql);

?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>จัดการปัญหา</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>จัดการปัญหา</h2>
        <a href="../index.php" class="btn btn-secondary mb-3"><i class="bi bi-arrow-left-circle"></i> กลับหน้าแรก</a>

        <?php
        if ($result->num_rows > 0) {
            // สร้างตาราง HTML
            echo "<table class='table table-striped table-bordered'>
                    <thead>
                        <tr>
                            <th>Username</th>
                            <th>Phone</th>
                            <th>Email</th>
                            <th>Subject</th>
                            <th>Problem Details</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>";

            // แสดงข้อมูลในตาราง
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>" . htmlspecialchars($row['username']) . "</td>
                        <td>" . htmlspecialchars($row['phone']) . "</td>
                        <td>" . htmlspecialchars($row['email']) . "</td>
                        <td>" . htmlspecialchars($row['subject']) . "</td>
                        <td>" . htmlspecialchars($row['problem_details']) . "</td>
                        <td>
                            <a href='delete_problem.php?id=" . $row['id'] . "' class='btn btn-danger btn-sm' onclick='return confirm(\"คุณแน่ใจว่าต้องการลบข้อมูลนี้?\")'><i class='bi bi-trash'></i> ลบ</a>
                        </td>
                      </tr>";
            }

            echo "</tbody></table>";
        } else {
            echo "<div class='alert alert-warning'>ไม่มีข้อมูล</div>";
        }

        // ปิดการเชื่อมต่อฐานข้อมูล
        $conn->close();
        ?>
    </div>

    <!-- Bootstrap 5 JS (with Popper.js) -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>
</body>
</html>
