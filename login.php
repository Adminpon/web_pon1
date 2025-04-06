<?php
require_once('config.php');
require_once('functions.php');
session_start();

// เช็คว่าเข้าสู่ระบบแล้วหรือยัง
if (checkLogin()) {
    if (isAdmin()) {
        $_SESSION['users_role'] = 'admin'; // กำหนด role เป็น admin
        header("Location: admin/dashboard.php");
    } else {
        $_SESSION['users_role'] = 'user'; // กำหนด role เป็น user
        header("Location: index.php");
    }
    exit;
}

$error_message = "";

// เมื่อมีการโพสต์ข้อมูล
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $rememberMe = isset($_POST['rememberMe']) ? true : false; // เช็คว่าเลือก remember me หรือไม่

    if (loginUser($conn, $username, $password)) {
        // ตรวจสอบว่าเป็น admin หรือไม่
        if (isAdmin()) {
            $_SESSION['user_role'] = 'admin'; // ถ้าเป็น admin กำหนด role เป็น admin
        } else {
            $_SESSION['user_role'] = 'user'; // ถ้าเป็น user กำหนด role เป็น user
        }

        // ถ้าเลือก "Remember Me"
        if ($rememberMe) {
            // ตั้ง cookie สำหรับจดจำรหัสผ่าน 7 วัน
            setcookie('username', $username, time() + (86400 * 7), "/"); // Cookie สำหรับชื่อผู้ใช้
            setcookie('password', $password, time() + (86400 * 7), "/"); // Cookie สำหรับรหัสผ่าน
        } else {
            // ถ้าไม่เลือก "Remember Me" ให้ลบ cookie ที่ตั้งไว้
            setcookie('username', '', time() - 3600, "/");
            setcookie('password', '', time() - 3600, "/");
        }

        // ถ้าเป็นแอดมินไปที่แดชบอร์ด
        if ($_SESSION['user_role'] == 'admin') {
            header("Location: admin/dashboard.php");
        } else {
            header("Location: index.php");
        }
        exit;
    } else {
        $error_message = "ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง";
    }
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เข้าสู่ระบบ</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="col-md-6 col-lg-4">
            <div class="card shadow">
                <div class="card-header text-center">
                    <h3><i class="bi bi-person-circle"></i> เข้าสู่ระบบ</h3>
                </div>
                <div class="card-body">
                    <?php if ($error_message): ?>
                        <div class="alert alert-danger"><?php echo $error_message; ?></div>
                    <?php endif; ?>
                    <form method="post">
                        <div class="mb-3 position-relative">
                            <label for="username" class="form-label">ชื่อผู้ใช้</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-person"></i></span>
                                <input type="text" id="username" name="username" class="form-control" value="<?php echo isset($_COOKIE['username']) ? $_COOKIE['username'] : ''; ?>" required>
                            </div>
                        </div>

                        <div class="mb-3 position-relative">
                            <label for="password" class="form-label">รหัสผ่าน</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-lock"></i></span>
                                <input type="password" id="password" name="password" class="form-control" value="<?php echo isset($_COOKIE['password']) ? $_COOKIE['password'] : ''; ?>" required>
                                <span class="input-group-text cursor-pointer" id="togglePassword"><i class="bi bi-eye-slash"></i></span>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="rememberMe" name="rememberMe" <?php echo isset($_COOKIE['username']) ? 'checked' : ''; ?>>
                                <label class="form-check-label" for="rememberMe">
                                    Remember Me
                                </label>
                            </div>
                        </div>

                        <div class="mb-3 text-center">
                            <button type="submit" class="btn btn-primary w-100"><i class="bi bi-box-arrow-in-right"></i> เข้าสู่ระบบ</button>
                        </div>
                    </form>
                    <p class="text-center">ยังไม่มีบัญชี? <a href="register.php">ลงทะเบียน</a></p>
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
    </script>
</body>
</html>
