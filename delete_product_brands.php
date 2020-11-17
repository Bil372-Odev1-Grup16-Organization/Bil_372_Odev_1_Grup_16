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

if (isset($_GET['BRAND_BARCODE']) & isset($_GET['M_SYSCODE'])) {
    $stmt = $pdo->prepare('SELECT * FROM PRODUCT_BRANDS WHERE BRAND_BARCODE = ? AND M_SYSCODE = ?');
    $stmt->execute([$_GET['BRAND_BARCODE'], $_GET['M_SYSCODE']]);

    $product = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$product) {
        exit('Product brand doesn\'t exist with those primary keys!');
    }

    //Asking the users second time if they really want to delete the item
    if (isset($_GET['confirm'])) {
        if ($_GET['confirm'] == 'yes') {
            $stmt = $pdo->prepare('DELETE FROM PRODUCT_BRANDS WHERE BRAND_BARCODE = ? AND M_SYSCODE = ?');
            $stmt->execute([$_GET['BRAND_BARCODE'], $_GET['M_SYSCODE']]);

            $msg = 'You have deleted the selected product brand!';
            header('Location: read_product_brands.php');
            exit();
        } else {
            header('Location: read_product_brands.php');
            exit;
        }
    }
} else {
    exit('No primary key has been specified!');
}
?>

<?=template_header('Delete')?>

<div class="product brand delete">
	<h2>Delete Product Brand #<?=$product['BRAND_BARCODE']?></h2>
    <?php if ($msg): ?>
        <p><?php
        echo "<script>alert('$msg')</script>";
        echo "<script>window.location = 'read_product_brands.php';</script>";
        ?></p>
    <?php else: ?>
	<p>Are you sure you want to delete the selected product brand #<?=$product['BRAND_BARCODE']?>?</p>
    <div class="yesno1">
        <a href="delete_product_brands.php?BRAND_BARCODE=<?=$product['BRAND_BARCODE']?>&M_SYSCODE=<?=$product['M_SYSCODE']?>&confirm=yes">Yes</a>
        <a href="delete_product_brands.php?BRAND_BARCODE=<?=$product['BRAND_BARCODE']?>&M_SYSCODE=<?=$product['M_SYSCODE']?>&confirm=no">No</a>
    </div>
    <?php endif; ?>
</div>

<?=template_footer()?>
