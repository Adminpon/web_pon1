<?php
include('navbar.php');

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>หน้าแรก | เว็บไซต์รีวิวสถานที่ท่องเที่ยว</title>
    
</head>
<body>
    <!-- <h1>สถานที่ท่องเที่ยวยอดนิยม</h1> -->
    <div class="all-000 m-5 mb-2"><h3>เกี่ยวกับเรา<i class="bi bi-people"></i></h3></div>
    <div class="card m-4">
        <div class="row g-0">
            <div class="col-md-4">
                <!-- รูปภาพ -->
                <img src="images/000.jpg" class="img-fluid rounded-start" alt="...">
            </div>
                <div class="col-md-8">
            <div class="card-body">
                    <h5 class="card-title">ประวัติเมืองอุบลราชธานี</h5>
                    <p class="card-text">เราอาจรู้จัก อุบลราชธานี ในฐานะเป็นเมืองท่องเที่ยวริมฝั่งโขงที่เต็มไปด้วยแหล่งท่องเที่ยวธรรมชาติสุด คาเฟ่ และ วัดสวย แต่ความจริงแล้วที่นี่เต็มไปด้วยเรื่องราวประวัติศาสตร์ และวัฒนธรรมที่น่าสนใจไม่น้อยไปกว่ากัน ตามเรามาเปิด ประวัติ จังหวัดอุบลราชธานี จังหวัดแห่งภาคอีสานที่ลงท้ายด้วย "ราชธานี" เพียงแห่งเดียวในประเทศไทยกัน</p>
                    <a href="about.php" class="btn btn-primary">อ่านเพิ่มเติม...</a>
            </div>
            </div>
        </div>
    </div>
    <div class="all-001 m-5 mb-2"><h3><?php echo htmlspecialchars($name_url)?> ทั้งหมด <i class="bi bi-geo-alt" style="color: red;"></i></i></h3></div>
    <div class="place-list">
    </div>
    <div class="place-list">
        <?php foreach ($places as $place): ?>
            <div class="place-card">
                <a href="place_detail.php?id=<?php echo $place['id']; ?>"><img src="uploads/<?php echo htmlspecialchars($place['image']); ?>" alt="<?php echo htmlspecialchars($place['name']); ?>"> </a>
                <h2><a href="place_detail.php?id=<?php echo $place['id']; ?>"><?php echo htmlspecialchars($place['name']); ?></a></h2>
                <div class="overflow-hidden"><?php echo ($place['description']); ?></div>
                <p>หมวดหมู่:  <?php echo htmlspecialchars($place['category']); ?></p>
            </div>
        <?php endforeach; ?>
    </div>

  
   
</body>
</html>

<?php include('footer.php'); ?>