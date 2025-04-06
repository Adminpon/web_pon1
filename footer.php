<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Footer Example</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet" />

    <style>
        /* Custom Footer Style */
        .footer {
            background-color:rgba(250, 248, 248, 0.94);
            padding: 40px 0;
        }

        .footer .logo img {
            width: 150px;
        }

        .footer .footer-link {
            list-style: none;
            padding: 0;
        }

        .footer .footer-link li {
            margin-bottom: 10px;
        }

        .footer .footer-link a {
            text-decoration: none;
            color: #6c757d;
        }

        .footer .footer-link a:hover {
            color: #007bff;
        }

        .footer .qr-code img {
            width: 100px;
        }

        .footer .footer-text {
            font-size: 14px;
            color: #6c757d;
        }

        .footer .social-icons a {
            margin-right: 15px;
            font-size: 20px;
            color: #6c757d;
        }

        .footer .social-icons a:hover {
            color: #007bff;
        }

        /* Dropdown Styling */
        .dropdown-menu a {
            color: #6c757d;
        }

        .dropdown-menu a:hover {
            color: #007bff;
        }

        /* Icon Hover Effect */
        .footer .social-icons a:hover {
            color: #ff4500; /* เปลี่ยนสีไอคอนเมื่อ hover */
        }
    </style>
</head>
<body>

    <!-- Your content here -->

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <!-- คอลัมน์ 1: โลโก้ -->
                <div class="col-12 col-md-3 text-center">
                    <div class="logo">
                        <img src="images/88888.png" alt="Brand Logo">
                    </div>
                </div>

                <!-- คอลัมน์ 2: ลิงก์ไปยัง Home, About, Contact -->
                <div class="col-12 col-md-3">
                    <ul class="footer-link">
                        <li><a href="index.php"><i class="bi bi-house-door"></i> Home</a></li>
                        <li><a href="about.php"><i class="bi bi-info-circle"></i> About</a></li>
                        <li><a href="problem.php"><i class="bi bi-envelope"></i> Contact</a></li>
                    </ul>
                </div>

                <!-- คอลัมน์ 3: เลือกหมวดหมู่ (Dropdown) -->
                <div class="col-12 col-md-3">
                    <div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                            เลือกหมวดหมู่
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <li><a class="dropdown-item" href="index.php?category=">ทั้งหมด</a></li>
                            <?php
                            // Loop through categories dynamically from database
                            if (!empty($all_db_categories)) {
                                foreach ($all_db_categories as $category_item) {
                                    echo '<li><a class="dropdown-item" href="index.php?category=' . urlencode($category_item['name']) . '">' . htmlspecialchars($category_item['name']) . '</a></li>';
                                }
                            }
                            ?>
                        </ul>
                    </div>
                </div>

                <!-- คอลัมน์ 4: QR Code และข้อความ -->
                <div class="col-12 col-md-3 text-center">
                    <div class="qr-code">
                        <img src="images/qrcobe.png" alt="QR Code">
                    </div>
                    <p class="footer-text mt-2">ขอขอบคุณทุกท่านที่ประมาณเว็บไซต์ของเรา</p>
                </div>
            </div>

            <!-- Social Media Icons (Optional) -->
            <div class="row justify-content-center mt-4">
                <div class="social-icons">
                    <a href="#" target="_blank" class="bi bi-facebook"></a>
                    <a href="#" target="_blank" class="bi bi-twitter"></a>
                    <a href="#" target="_blank" class="bi bi-instagram"></a>
                </div>
            </div>
        </div>
    </footer>

</body>
</html>
