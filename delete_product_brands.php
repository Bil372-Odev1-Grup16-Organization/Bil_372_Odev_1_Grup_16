<?php
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
  <!-- double pk situation
	<h2>Delete Product Brand #<?=$product['MANUFACTURER_ID']?></h2>
  <-->
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php else: ?>
    <!-- double pk in product
	<p>Are you sure you want to delete the selected product brand #<?=$product['MANUFACTURER_ID']?>?</p>
    <div class="yesno">
        <a href="delete_product_brands.php?MANUFACTURER_ID=<?=$product['MANUFACTURER_ID']?>&confirm=yes">Yes</a>
        <a href="delete_product_brands.php?MANUFACTURER_ID=<?=$product['MANUFACTURER_ID']?>&confirm=no">No</a>
        <-->
    </div>
    <?php endif; ?>
</div>

<?=template_footer()?>
