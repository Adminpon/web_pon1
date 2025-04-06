<?php
require_once('config.php');
require_once('functions.php');
session_start(); // ต้อง start session ก่อน

if (isset($_GET['id'])) {
    $place_id = $_GET['id'];
    $place = getPlace($conn, $place_id);
    $reviews = getReviews($conn, $place_id);

    if (!$place) {
        echo "ไม่พบสถานที่ที่ระบุ";
        exit;
    }
} else {
    echo "กรุณาระบุ ID ของสถานที่";
    exit;
}

// การเพิ่มรีวิว (POST request) *ปรับปรุง*
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (!checkLogin()) { // เช็คว่าล็อกอินหรือยัง
        header("Location: login.php"); // ถ้ายัง Redirect ไปหน้า login
        exit;
    }

    $user_id = $_SESSION['user_id']; // ดึง user_id จาก session
    $rating = $_POST['rating'];
    $comment = $_POST['comment'];

    if (addReview($conn, $place_id, $user_id, $rating, $comment)) {
        header("Location: place_detail.php?id=$place_id");
        exit;
    } else {
        echo "เกิดข้อผิดพลาดในการเพิ่มรีวิว";
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
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container my-5">
        <!-- หัวข้อสถานที่ -->
        <h1 class="mb-4"><?php echo htmlspecialchars($place['name']); ?></h1>
        
        <!-- รูปภาพสถานที่ -->
        <img src="<?php echo htmlspecialchars($place['image']); ?>" alt="<?php echo htmlspecialchars($place['name']); ?>" class="img-fluid mb-3">
        
        <!-- รายละเอียดสถานที่ -->
        <p class="lead"><?php echo htmlspecialchars($place['description']); ?></p>
        <p><strong>ที่อยู่: </strong><?php echo htmlspecialchars($place['address']); ?></p>

        <!-- รีวิว -->
        <h2>รีวิว</h2>
        <?php if (count($reviews) > 0): ?>
            <ul class="list-group">
                <?php foreach ($reviews as $review): ?>
                    <li class="list-group-item">
                        <?php
                        // ดึงข้อมูลผู้รีวิว
                        $reviewer = getUserById($conn, $review['user_id']);
                        $reviewer_name = $reviewer ? $reviewer['username'] : 'ผู้ใช้ที่ไม่ระบุตัวตน'; // ถ้าหา user ไม่เจอ
                        ?>
                        <strong><?php echo htmlspecialchars($reviewer_name); ?></strong> 
                        <span class="badge bg-warning text-dark"><?php echo $review['rating']; ?>/5</span> - 
                        <?php echo htmlspecialchars($review['comment']); ?>
                        <em class="text-muted">(<?php echo $review['review_date']; ?>)</em>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p class="alert alert-info mt-3">ยังไม่มีรีวิวสำหรับสถานที่นี้</p>
        <?php endif; ?>

        <!-- ฟอร์มรีวิว -->
        <?php if (checkLogin()): ?>
            <h2 class="mt-4">เพิ่มรีวิว</h2>
            <form method="post" class="border p-4 rounded">
                <div class="mb-3">
                    <label for="rating" class="form-label">คะแนน:</label>
                    <select id="rating" name="rating" class="form-select" required>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="comment" class="form-label">ความคิดเห็น:</label>
                    <textarea id="comment" name="comment" class="form-control" rows="4" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">ส่งรีวิว</button>
            </form>
        <?php else: ?>
            <p class="mt-3">กรุณา <a href="login.php">เข้าสู่ระบบ</a> เพื่อเขียนรีวิว</p>
        <?php endif; ?>
    </div>

    <!-- Bootstrap 5 JS (with Popper.js) -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>
