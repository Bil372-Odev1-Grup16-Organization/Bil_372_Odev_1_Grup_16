<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';

//check if the given item with the primary key exists
/* double primary key situation
if (isset($_GET['MANUFACTURER_ID'])) {
    $stmt = $pdo->prepare('SELECT * FROM MANUFACTURERS WHERE MANUFACTURER_ID = ?');
    $stmt->execute([$_GET['MANUFACTURER_ID']]);
    */
    $product = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$product) {
        /* Error message might change due to double pk
        exit('Product brand doesn\'t exist with that primary key!');
        */
    }

    //Asking the users second time if they really want to delete the item
    if (isset($_GET['confirm'])) {
        if ($_GET['confirm'] == 'yes') {
            /* WHERE and GET might change due to double pk
            $stmt = $pdo->prepare('DELETE FROM MANUFACTURERS WHERE MANUFACTURER_ID = ?');
            $stmt->execute([$_GET['MANUFACTURER_ID']]);
            */
            $msg = 'You have deleted the selecteed product brand!';
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
