<?php
require_once('config.php');
require_once('functions.php');
session_start();

$current_user = getCurrentUserName($conn);

// --- Category Filtering ---
$selected_category = isset($_GET['category']) ? $_GET['category'] : '';

// --- Search Functionality ---
$search_term = isset($_GET['search']) ? $_GET['search'] : '';

$name_url = isset($_GET['category']) ? $_GET['category'] : '';

$all_db_categories = getAllCategories($conn);


// Get places based on search and category (using the function from functions.php)
$places = getPlacesBySearchAndCategory($conn, $selected_category, $search_term);
    $username = "";

    if (checkLogin()) {
        $user_id = $_SESSION['user_id'];
        $user = getUserById($conn, $user_id);
    if ($user) { // Check if user data was retrieved
        $username = $user['username']; // Get the username
    }
    }
?>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   
    <link rel="stylesheet" href="css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Include Font Awesome for the arrow icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
    /* Scroll to Top Button */
    #scrollToTopBtn {
        display: none;
        position: fixed;
        bottom: 20px;
        right: 20px;
        background-color: rgba(0, 0, 0, 0.6); /* Adjusted to a transparent black */
        color: white;
        border: none;
        padding: 10px;
        border-radius: 100%;
        cursor: pointer;
        font-size: 20px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
    }

    #scrollToTopBtn:hover {
        background-color:rgb(12, 12, 12);
    }
</style>
    
    <nav class="navbar navbar-expand-sm navbar-dark bg-dark">
        <div class="container">
            <a href="index.php" class="navbar-brand"><img src="images/99999.png" alt="Brand Logo"></a>
            <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbar1">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div id="navbar1" class="collapse navbar-collapse">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a href="index.php" class="nav-link">Home</a>
                    </li>
                    <li class="nav-item">
                        <a href="about.php" class="nav-link">About</a>
                    </li>
                    <!-- Dropdown สำหรับเลือกหมวดหมู่ -->

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            เลือกหมวดหมู่
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="index.php?category=">ทั้งหมด</a></li> <!-- Default option: All -->
                    <?php
                    // --- Display categories dynamically as dropdown items ---
                            if (!empty($all_db_categories)) {
                            foreach ($all_db_categories as $category_item) {
                        echo '<li><a class="dropdown-item" href="index.php?category=' . urlencode($category_item['name']) . '">' . htmlspecialchars($category_item['name']) . '</a></li>';
                                }
                            }
                         ?>
                    </ul>
                </li>

                    <li class="nav-item">
                        <a href="problem.php" class="nav-link">Contact</a>
                    </li>
                    <!-- ฟอร์มค้นหาที่เปลี่ยนปุ่มเป็นไอคอน -->
                    <li class="nav-item">
                        <form action="index.php" method="get" class="d-flex m-2">
                            <div class="input-group">
                                <input type="text" id="search" name="search" value="<?php echo htmlspecialchars($search_term); ?>" class="form-control" placeholder="ค้นหา...">
                                <button type="submit" class="btn btn-outline-light">
                                    <i class="bi bi-search"></i> <!-- ใช้ไอคอนค้นหาจาก Bootstrap Icons -->
                                </button>
                            </div>
                        </form>
                    </li>

                    <!-- ถ้าเป็นผู้ใช้ที่ล็อกอินแล้ว -->
                    <?php if (checkLogin()): ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown " role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <!-- ไอคอนและแสดงชื่อผู้ใช้ -->
                            <i class="bi bi-person-circle" style="font-size: 1.5rem;" data-bs-toggle="tooltip" data-bs-placement="bottom" title="<?php echo htmlspecialchars($username); ?>"></i> 
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="userDropdown">
                            <!-- เมนูของผู้ใช้ -->
                            <?php if (isAdmin()): ?>
                                <li><a class="dropdown-item" href="admin/dashboard.php">Admin Dashboard</a></li> <!-- Admin Dashboard -->
                            <?php endif; ?>
                            <li><a class="dropdown-item" href="logout.php">ออกจากระบบ</a></li> <!-- ปุ่มออกจากระบบ -->
                        </ul>
                    </li>
                    <?php else: ?>
                    <li class="nav-item">
                        <a href="login.php" class="btn btn-primary m-2">เข้าสู่ระบบ</a> <!-- ปุ่มเข้าสู่ระบบ -->
                    </li>
                    <li class="nav-item">
                        <a href="register.php" class="btn btn-success m-2">ลงทะเบียน</a> <!-- ปุ่มลงทะเบียน -->
                    </li>
                    <?php endif; ?>                   
                </ul>
            </div>
        </div>
    </nav>
    <img src="images/แนะนำสถานที่ท่องเที่ยว.png" class="img-fluid" alt="Responsive image">
    <script>
        // เปิดใช้งาน tooltip เมื่อโหลดหน้า
        var tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
        var tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));
    </script>

        <!-- Scroll to Top Button -->
        <button id="scrollToTopBtn" onclick="scrollToTop()"><i class="fas fa-arrow-up"></i></button>

    <script>
    // Get the button
    var scrollToTopBtn = document.getElementById("scrollToTopBtn");

    // When the user scrolls down 200px from the top of the document, show the button
    window.onscroll = function() {
        if (document.body.scrollTop > 200 || document.documentElement.scrollTop > 200) {
            scrollToTopBtn.style.display = "block";
        } else {
            scrollToTopBtn.style.display = "none";
        }
    };

    // Scroll to the top of the page when the button is clicked
    function scrollToTop() {
        window.scrollTo({top: 0, behavior: 'smooth'});
    }
    </script>                    
    

