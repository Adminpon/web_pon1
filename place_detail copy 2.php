<?php
require_once('config.php');
require_once('functions.php');
session_start();

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

// การเพิ่มรีวิว
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (!checkLogin()) { 
        header("Location: login.php");
        exit;
    }

    $user_id = $_SESSION['user_id'];
    $rating = $_POST['rating']; // รับค่าคะแนนจาก radio button
    $comment = $_POST['comment'];

    // ตรวจสอบว่า $rating มีค่าหรือไม่
    if (empty($rating)) {
        echo "กรุณาเลือกคะแนน";
    } else {
        if (addReview($conn, $place_id, $user_id, $rating, $comment)) {
            header("Location: place_detail.php?id=$place_id");
            exit;
        } else {
            echo "เกิดข้อผิดพลาดในการเพิ่มรีวิว";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($place['name']); ?> | รายละเอียดสถานที่</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h1><?php echo htmlspecialchars($place['name']); ?></h1>
    <img src="<?php echo htmlspecialchars($place['image']); ?>" alt="<?php echo htmlspecialchars($place['name']); ?>">
    <p><?php echo htmlspecialchars($place['description']); ?></p>
    <p>ที่อยู่: <?php echo htmlspecialchars($place['address']); ?></p>

    <h2>รีวิว</h2>
<?php if (count($reviews) > 0): ?>
    <ul>
    <?php foreach ($reviews as $review): ?>
        <li>
            <?php
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
            <em>(<?php echo $review['review_date']; ?>)</em>
        </li>
    <?php endforeach; ?>
</ul>
<?php else: ?>
    <p>ยังไม่มีรีวิวสำหรับสถานที่นี้</p>
<?php endif; ?>

    <?php if (checkLogin()): ?>
        <h2>เพิ่มรีวิว</h2>
        <form method="post">
            <h2 id="title" class="call-to-action-text">เลือกการให้คะแนน:</h2>
            <div class="star-wrap">
                <input class="star" type="radio" value="1" id="st-1" name="rating" autocomplete="off" />
                <label class="star-label" for="st-1">
                    <div class="star-shape"></div>
                </label>
                <input class="star" type="radio" value="2" id="st-2" name="rating" autocomplete="off" />
                <label class="star-label" for="st-2">
                    <div class="star-shape"></div>
                </label>
                <input class="star" type="radio" value="3" id="st-3" name="rating" autocomplete="off" />
                <label class="star-label" for="st-3">
                    <div class="star-shape"></div>
                </label>
                <input class="star" type="radio" value="4" id="st-4" name="rating" autocomplete="off" />
                <label class="star-label" for="st-4">
                    <div class="star-shape"></div>
                </label>
                <input class="star" type="radio" value="5" id="st-5" name="rating" autocomplete="off" />
                <label class="star-label" for="st-5">
                    <div class="star-shape"></div>
                </label>
            </div>

            <label for="comment">ความคิดเห็น:</label>
            <textarea id="comment" name="comment" rows="4" required></textarea><br>

            <input type="submit" value="ส่งรีวิว">
        </form>
    <?php else: ?>
        <p>กรุณา <a href="login.php">เข้าสู่ระบบ</a> เพื่อเขียนรีวิว</p>
    <?php endif; ?>

</body>
</html>

<style>
* {
    padding: 0;
    margin: 0;
    box-sizing: border-box;
}

body {
    font-family: Arial, sans-serif;
}

.call-to-action-text {
    margin: 2rem 0;
    text-align: center;
}

.stars {
    display: inline-block;
}

.star {
    width: 30px;
    height: 30px;
    display: inline-block;
    background-color: lightgray;
    clip-path: polygon(
        50% 0%,
        61% 35%,
        98% 35%,
        68% 57%,
        79% 91%,
        50% 70%,
        21% 91%,
        32% 57%,
        2% 35%,
        39% 35%
    );
    margin-right: 5px;
    cursor: pointer;
}

/* สีทองสำหรับดาวที่เลือก */
.star.filled {
    background-color: gold;
}

/* ลบการแสดงผลของ focus */
.star:focus {
    outline: none;
}

/* กำหนดการแสดงผลของดาวที่ไม่ได้เลือก */
.star:not(:checked) + .star-label .star-shape {
    background-color: lightgray;
}

/* ดาวที่ถูกเลือก (สีทอง) */
.star:checked + .star-label .star-shape {
    background-color: gold;
}

/* ลบเอฟเฟกต์ focus ของ input radio */
.star:focus {
    outline: none;
}

.star-wrap {
    width: max-content;
    margin: 0 auto;
    position: relative;
}
.star-label.hidden {
    display: none;
}
.star-label {
    display: inline-flex;
    justify-content: center;
    align-items: center;
    width: 2rem;
    height: 2rem;
}

@media (min-width: 840px) {
    .star-label {
        width: 3rem;
        height: 3rem;
    }
}

.star-shape {
    width: 80%;
    height: 80%;
    clip-path: polygon(
        50% 0%,
        61% 35%,
        98% 35%,
        68% 57%,
        79% 91%,
        50% 70%,
        21% 91%,
        32% 57%,
        2% 35%,
        39% 35%
    );
}

.star:checked + .star-label ~ .star-label .star-shape {
    background-color: lightgray;
}

.star {
    position: fixed;
    opacity: 0;
    left: -90000px;
}
.skip-button {
    display: block;
    width: 2rem;
    height: 2rem;
    border-radius: 1rem;
    position: absolute;
    top: -2rem;
    right: -1rem;
    text-align: center;
    line-height: 2rem;
    font-size: 2rem;
    background-color: rgba(255, 255, 255, 0.1);
}
.skip-button:hover {
    background-color: rgba(255, 255, 255, 0.2);
}
#skip-star:checked ~ .skip-button {
    display: none;
}
#result {
    text-align: center;
    padding: 1rem 2rem;
}
.exp-link {
    text-align: center;
    padding: 1rem 2rem;
}
.exp-link a {
    color: lightgray;
    text-decoration: underline;
}
</style>
