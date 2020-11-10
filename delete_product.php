<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
// Check that the contact ID exists
if (isset($_GET['M_SYSCODE'])) {
    // Select the record that is going to be deleted
    $stmt = $pdo->prepare('SELECT * FROM PRODUCT WHERE M_SYSCODE = ?');
    $stmt->execute([$_GET['M_SYSCODE']]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$product) {
        exit('Product doesn\'t exist with that primary key!');
    }
    // Make sure the user confirms beore deletion
    if (isset($_GET['confirm'])) {
        if ($_GET['confirm'] == 'yes') {
            // User clicked the "Yes" button, delete record
            $stmt = $pdo->prepare('DELETE FROM PRODUCT WHERE M_SYSCODE = ?');
            $stmt->execute([$_GET['M_SYSCODE']]);
            $msg = 'You have deleted the selecteed product!';
        } else {
            // User clicked the "No" button, redirect them back to the read page
            header('Location: read_product.php');
            exit;
        }
    }
} else {
    exit('No primary key has been specified!');
}
?>

<?=template_header('Delete')?>

<div class="product delete">
	<h2>Delete Product #<?=$product['M_SYSCODE']?></h2>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php else: ?>
	<p>Are you sure you want to delete the selected product #<?=$product['M_SYSCODE']?>?</p>
    <div class="yesno">
        <a href="delete_product.php?M_SYSCODE=<?=$product['M_SYSCODE']?>&confirm=yes">Yes</a>
        <a href="delete_product.php?M_SYSCODE=<?=$product['M_SYSCODE']?>&confirm=no">No</a>
    </div>
    <?php endif; ?>
</div>

<?=template_footer()?>
