<?php
   include('navbar.php'); 
   

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = "";  // ตัวแปรสำหรับแสดงข้อความเมื่อการส่งข้อมูลเสร็จสมบูรณ์

// ตรวจสอบว่า form ถูกส่งหรือไม่
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $problem_details = $_POST['problem_details'];

    // สร้างคำสั่ง SQL เพื่อบันทึกข้อมูล
    $sql = "INSERT INTO problem (username, phone, email, subject, problem_details)
            VALUES ('$username', '$phone', '$email', '$subject', '$problem_details')";

    if ($conn->query($sql) === TRUE) {
        $message = "ข้อมูลถูกส่งเรียบร้อยแล้ว!";
    } else {
        $message = "เกิดข้อผิดพลาด: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ติดต่อเรา</title>

    <!-- เชื่อมโยงกับ Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- เชื่อมโยงกับไอคอน Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body>
   
    <div class="container mt-5">
        <h1 class="text-center mb-4">ติดต่อเรา</h1>

        <!-- ฟอร์มสำหรับกรอกข้อมูล -->
        <form method="POST" action="problem.php" class="bg-light p-4 rounded shadow-sm">
            <div class="mb-3 input-group">
                <span class="input-group-text"><i class="bi bi-person"></i></span>
                <input type="text" id="username" name="username" class="form-control" placeholder="ชื่อผู้ใช้" required>
            </div>

            <div class="mb-3 input-group">
                <span class="input-group-text"><i class="bi bi-phone"></i></span>
                <input type="text" id="phone" name="phone" class="form-control" placeholder="หมายเลขโทรศัพท์" required>
            </div>

            <div class="mb-3 input-group">
                <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                <input type="email" id="email" name="email" class="form-control" placeholder="อีเมล" required>
            </div>

            <div class="mb-3 input-group">
                <span class="input-group-text"><i class="bi bi-chat-left-text"></i></span>
                <input type="text" id="subject" name="subject" class="form-control" placeholder="หัวข้อเรื่อง" required>
            </div>

            <div class="mb-3 input-group">
                <span class="input-group-text"><i class="bi bi-pencil-square"></i></span>
                <textarea id="problem_details" name="problem_details" class="form-control" rows="4" placeholder="รายละเอียดปัญหา" required></textarea>
            </div>

            <button type="submit" class="btn btn-primary w-100">
                <i class="bi bi-send"></i> ส่งข้อมูล
            </button>
            <div class="mt-3 text-center">
            <a href="index.php" class="btn btn-secondary w-100">
                <i class="bi bi-arrow-left-circle"></i> กลับหน้าแรก
            </a>
            </div>
        </form>

        <!-- แสดงข้อความเมื่อส่งข้อมูลเสร็จแล้ว -->
        <?php if (!empty($message)): ?>
            <div class="alert alert-info mt-4" role="alert">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>
    </div>

    <!-- เชื่อมโยงกับ Bootstrap 5 JS และ Popper.js -->
   
</body>

</html>

<?php include('footer.php'); ?>
