<?php
ob_start(); // เริ่มต้น Output Buffering
include('navbar.php');

if (isset($_GET['id'])) {
    $place_id = $_GET['id'];
    $place = getPlace($conn, $place_id);
    $reviews = getReviews($conn, $place_id);

    // ดึงข้อมูลรูปภาพจากฐานข้อมูล
    $place_images = getPlaceImages($conn, $place_id); // ฟังก์ชัน getPlaceImages ต้องถูกสร้างขึ้นใน functions.php

    if (!$place) {
        echo "ไม่พบสถานที่ที่ระบุ";
        exit;
    }
} else {
    echo "กรุณาระบุ ID ของสถานที่";
    exit;
}


if ($_SERVER['REQUEST_METHOD'] == 'POST' && checkLogin()) {
    $rating = isset($_POST['rating']) ? (int)$_POST['rating'] : 0;
    $comment = isset($_POST['comment']) ? trim($_POST['comment']) : '';

    if ($rating > 0 && !empty($comment)) {
        // บันทึกรีวิวลงฐานข้อมูล
        $user_id = $_SESSION['user_id']; // สมมติว่า user_id เก็บไว้ใน session
        $place_id = $_GET['id'];

        // เรียกใช้ฟังก์ชันในการเพิ่มรีวิว
        $result = addReview($conn, $place_id, $user_id, $rating, $comment);
        
        if ($result) {
            // ถ้าบันทึกสำเร็จ ทำการเปลี่ยนเส้นทางไปยังหน้าปัจจุบันเพื่อป้องกันการส่งฟอร์มซ้ำ
            header('Location: ' . $_SERVER['REQUEST_URI']);
            exit(); // หยุดการทำงานต่อหลังจากทำการ redirect
        } else {
            echo "<div class='alert alert-danger'>เกิดข้อผิดพลาดในการบันทึกรีวิว</div>";
        }
    } else {
        echo "<div class='alert alert-warning'>กรุณากรอกความคิดเห็นและเลือกการให้คะแนน</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($place['name']); ?> | รายละเอียดสถานที่</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
    <div class="container my-5">
        <!-- เริ่มต้น Card สำหรับแสดงสถานที่ -->
        <div class="card">
            <!-- หัวข้อสถานที่ -->
            <div class="card-header">
                <h1><?php echo htmlspecialchars($place['name']); ?></h1>
            </div>

            <!-- สไลด์แสดงรูปภาพสถานที่ -->
            <div id="placeCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <?php
                    if (count($place_images) > 0):
                        $isActive = 'active'; 
                        foreach ($place_images as $index => $image):
                    ?>
                        <div class="carousel-item <?php echo $isActive; ?>">
                            <img src="uploads/<?php echo htmlspecialchars($image['image_path']); ?>" class="d-block w-100" alt="Image <?php echo $index + 1; ?>">
                        </div>
                    <?php
                        $isActive = ''; // เปลี่ยนค่าเป็นค่าว่างสำหรับภาพถัดไป
                        endforeach;
                    else:
                    ?>
                        <div class="carousel-item active">
                            <img src="path/to/default-image.jpg" class="d-block w-100" alt="No images available">
                        </div>
                    <?php endif; ?>
                </div>
                <!-- Controls -->
                <button class="carousel-control-prev" type="button" data-bs-target="#placeCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#placeCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                </button>
            </div>

            <!-- รายละเอียดสถานที่ -->
            <div class="card-body">
                <p class="lead"><?php echo htmlspecialchars($place['description']); ?></p>
                <p><strong>ที่อยู่: </strong><?php echo htmlspecialchars($place['address']); ?></p>
                <!-- เพิ่มข้อมูลการติดต่อ -->
                <p><strong>ติดต่อ: </strong><?php echo htmlspecialchars($place['contact']); ?></p>
                <!-- เพิ่มเวลาทำการ -->
                <p><strong>เวลาทำการ: </strong><?php echo htmlspecialchars($place['opening_hours']); ?></p>
            </div>
        </div>
        <!-- จบ Card -->

        <!-- รีวิว -->
        <h2 class="mt-4">รีวิว<i class="bi bi-star-fill"></i></h2>
        <?php if (count($reviews) > 0): ?>
            <ul class="list-group">
                <?php foreach ($reviews as $review): ?>
                    <li class="list-group-item">
                        <?php
                        // ดึงข้อมูลผู้รีวิว
                        $reviewer = getUserById($conn, $review['user_id']);
                        $reviewer_name = $reviewer ? $reviewer['username'] : 'ผู้ใช้ที่ไม่ระบุตัวตน'; 
                        ?>
                        <strong><?php echo htmlspecialchars($reviewer_name); ?></strong> 
                        
                        <div class="stars">
                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                <span class="star <?php echo ($i <= $review['rating']) ? 'filled' : ''; ?>"></span>
                            <?php endfor; ?>
                        </div>
                        
                        - <?php echo htmlspecialchars($review['comment']); ?>
                        <em class="text-muted">(<?php echo $review['review_date']; ?>)</em>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p class="alert alert-info mt-3">ยังไม่มีรีวิวสำหรับสถานที่นี้</p>
        <?php endif; ?>

        <!-- ฟอร์มรีวิว -->
        <?php if (checkLogin()): ?>
            <h2 class="mt-4">เพิ่มรีวิว<i class="bi bi-plus-circle"></i></h2>
            
            <form method="post" class="border p-4 rounded">
                <div class="mb-3">
                    <h3 class="call-to-action-text">เลือกการให้คะแนน:</h3>
                    <div class="star-wrap">
                        <input class="star" type="radio" value="5" id="st-1" name="rating" autocomplete="off" />
                        <label class="star-label" for="st-1"></label>
                        <input class="star" type="radio" value="4" id="st-2" name="rating" autocomplete="off" />
                        <label class="star-label" for="st-2"></label>
                        <input class="star" type="radio" value="3" id="st-3" name="rating" autocomplete="off" />
                        <label class="star-label" for="st-3"></label>
                        <input class="star" type="radio" value="2" id="st-4" name="rating" autocomplete="off" />
                        <label class="star-label" for="st-4"></label>
                        <input class="star" type="radio" value="1" id="st-5" name="rating" autocomplete="off" />
                        <label class="star-label" for="st-5"></label>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="comment" class="form-label">ความคิดเห็น:</label>
                    <textarea id="comment" name="comment" class="form-control" rows="4" required></textarea>
                </div>

                <button type="submit" class="btn btn-primary">ส่งรีวิว</button>
                <a href="index.php" class="btn btn-secondary"><i class="bi bi-house-door"></i> กลับหน้าหลัก</a>
            </form>
        <?php else: ?>
            <p class="mt-3">กรุณา <a href="login.php">เข้าสู่ระบบ</a> เพื่อเขียนรีวิว</p>
        <?php endif; ?>
    </div>

</body>
</html>

<?php
ob_end_flush(); // ส่งข้อมูลทั้งหมดใน buffer ออกไปที่ browser
 include('footer.php'); 
?>
