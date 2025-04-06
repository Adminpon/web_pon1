<?php
require_once('config.php');
require_once('functions.php');

$message = ""; // เก็บข้อความแจ้งเตือน

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password != $confirm_password) {
        $message = "รหัสผ่านไม่ตรงกัน";
    } else {
        // ตรวจสอบว่ามีชื่อผู้ใช้นี้อยู่แล้วหรือไม่
        $sql = "SELECT id FROM users WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // มีชื่อผู้ใช้นี้อยู่แล้ว
            $message = "ชื่อผู้ใช้นี้มีคนใช้แล้ว กรุณาเลือกชื่อผู้ใช้อื่น";
        } else {
            // ชื่อผู้ใช้นี้ใช้ได้, ทำการลงทะเบียน
            if (registerUser($conn, $username, $password)) {
                // $message = "ลงทะเบียนสำเร็จ! คุณสามารถเข้าสู่ระบบได้แล้ว"; // ไม่ต้องแสดงข้อความแล้ว
                header("Location: login.php?message=registersuccess"); // Redirect ไปหน้า login
                exit; // สำคัญ: หยุดการทำงานของ script หลังจาก redirect
            } else {
                $message = "เกิดข้อผิดพลาดในการลงทะเบียน";
            }
        }
        $stmt->close(); // ปิด prepared statement
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ลงทะเบียน</title>
    <!-- เพิ่มการเชื่อมโยงกับ Bootstrap 5 และ Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet"> <!-- Bootstrap Icons -->
</head>
<body>
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="col-md-6 col-lg-4">
            <div class="card shadow">
                <div class="card-header text-center">
                    <h3><i class="bi bi-person-plus-fill"></i> ลงทะเบียน</h3>
                </div>
                <div class="card-body">
                    <!-- แสดงข้อความแจ้งเตือนถ้ามี -->
                    <?php if ($message): ?>
                        <div class="alert alert-danger"><?php echo $message; ?></div>
                    <?php endif; ?>
                    <form method="post">
                        <div class="mb-3 position-relative">
                            <label for="username" class="form-label">ชื่อผู้ใช้</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-person"></i></span>
                                <input type="text" id="username" name="username" class="form-control" required>
                            </div>
                        </div>

                        <div class="mb-3 position-relative">
                            <label for="password" class="form-label">รหัสผ่าน</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-lock"></i></span>
                                <input type="password" id="password" name="password" class="form-control" required>
                                <span class="input-group-text cursor-pointer" id="togglePassword"><i class="bi bi-eye-slash"></i></span>
                            </div>
                        </div>

                        <div class="mb-3 position-relative">
                            <label for="confirm_password" class="form-label">ยืนยันรหัสผ่าน</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-lock"></i></span>
                                <input type="password" id="confirm_password" name="confirm_password" class="form-control" required>
                                <span class="input-group-text cursor-pointer" id="toggleConfirmPassword"><i class="bi bi-eye-slash"></i></span>
                            </div>
                        </div>

                        <div class="mb-3 text-center">
                            <input type="submit" value="ลงทะเบียน" class="btn btn-success w-100">
                        </div>
                    </form>
                    <p class="text-center">มีบัญชีอยู่แล้ว? <a href="login.php">เข้าสู่ระบบ</a></p>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript สำหรับการแสดง/ซ่อนรหัสผ่าน -->
    <script>
        document.getElementById("togglePassword").addEventListener("click", function() {
            const passwordInput = document.getElementById("password");
            const passwordIcon = this.querySelector("i");

            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                passwordIcon.classList.remove("bi-eye-slash");
                passwordIcon.classList.add("bi-eye");
            } else {
                passwordInput.type = "password";
                passwordIcon.classList.remove("bi-eye");
                passwordIcon.classList.add("bi-eye-slash");
            }
        });

        document.getElementById("toggleConfirmPassword").addEventListener("click", function() {
            const confirmPasswordInput = document.getElementById("confirm_password");
            const confirmPasswordIcon = this.querySelector("i");

            if (confirmPasswordInput.type === "password") {
                confirmPasswordInput.type = "text";
                confirmPasswordIcon.classList.remove("bi-eye-slash");
                confirmPasswordIcon.classList.add("bi-eye");
            } else {
                confirmPasswordInput.type = "password";
                confirmPasswordIcon.classList.remove("bi-eye");
                confirmPasswordIcon.classList.add("bi-eye-slash");
            }
        });
    </script>

    <!-- เพิ่มการเชื่อมโยงกับ JavaScript ของ Bootstrap 5 -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>
