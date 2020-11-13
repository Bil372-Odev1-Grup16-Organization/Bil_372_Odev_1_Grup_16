<?php
include 'functions.php';

$pdo = pdo_connect_mysql();

$stmt = $pdo->prepare('SELECT * FROM PRODUCT_FEATURES ORDER BY M_SYSCODE');
$stmt->execute();
$product = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?= template_header('Read') ?>

<div class="content read">
	<h2>All Products</h2>
	<a href="create_product_features.php" class="add-product">Link Product & Features</a>
	<table>
        <thead>
            <tr>
                <td>#</td>
                <td>M_CODE</td>
                <td>FEATURE_ID</td>
                <td>MINVAL</td>
                <td>MAXVAL</td>
                <td></td>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($product as $element): ?>
            <tr>
                <td><?= $element['M_SYSCODE'] ?></td>
                <td><?= $element['FEATURE_ID'] ?></td>
                <td><?= $element['MINVAL'] ?></td>
                <td><?= $element['MAXVAL'] ?></td>
                <td class="actions">
                    <a href="update_product.php?M_SYSCODE=<?= $element[
                        'M_SYSCODE'
                    ] ?>" class="edit"><i class="fas fa-pen fa-xs"></i></a>
                    <a href="delete_product.php?M_SYSCODE=<?= $element[
                        'M_SYSCODE'
                    ] ?>" class="trash"><i class="fas fa-trash fa-xs"></i></a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?= template_footer()
?>
