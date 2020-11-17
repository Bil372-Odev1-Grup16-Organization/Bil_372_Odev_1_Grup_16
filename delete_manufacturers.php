<?php
session_start();
if(!isset($_SESSION['NAME'])){ //session check
    header("location: login.php");
 }
 if($_SESSION['NAME'] != 'Admin'){
     echo("<script>alert('Unauthorized Access')</script>");
     echo("<script>window.location = 'logout.php';</script>"); 
 }
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';

//check if the given item with the primary key exists
if (isset($_GET['MANUFACTURER_ID'])) {
    $stmt = $pdo->prepare('SELECT * FROM MANUFACTURERS WHERE MANUFACTURER_ID = ?');
    $stmt->execute([$_GET['MANUFACTURER_ID']]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$product) {
        exit('Manufacturer doesn\'t exist with that primary key!');
    }

    //Asking the users second time if they really want to delete the item
    if (isset($_GET['confirm'])) {
        if ($_GET['confirm'] == 'yes') {
            $stmt = $pdo->prepare('DELETE FROM MANUFACTURERS WHERE MANUFACTURER_ID = ?');
            $stmt->execute([$_GET['MANUFACTURER_ID']]);
            $msg = 'Manufacturer deleted successfully!';
        } else {
            header('Location: read_manufacturers.php');
            exit;
        }
    }
} else {
    exit('No primary key has been specified!');
}
?>

<?=template_header('Delete')?>

<div class="manufacturer delete">
	<h2>Delete Manufacturer #<?=$product['MANUFACTURER_ID']?></h2>
    <?php if ($msg): ?>
    <p><?php
    echo "<script>alert('$msg')</script>";
    echo "<script>window.location = 'read_manufacturers.php';</script>";
    ?></p>
    <?php else: ?>
	<p>Are you sure you want to delete the selected manufacturer #<?=$product['MANUFACTURER_ID']?>?</p>
    <div class="yesno1">
        <a href="delete_manufacturers.php?MANUFACTURER_ID=<?=$product['MANUFACTURER_ID']?>&confirm=yes">Yes</a>
        <a href="delete_manufacturers.php?MANUFACTURER_ID=<?=$product['MANUFACTURER_ID']?>&confirm=no">No</a>
    </div>
    <?php endif; ?>
</div>

<?=template_footer()?>
