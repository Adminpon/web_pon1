<?php include('navbar.php'); ?>
<?php 

$name_url = isset($_GET['category']) ? $_GET['category'] : '';?>
       <h1><?php echo ( htmlspecialchars($name_url))?><h1>