<?php
include 'functions.php';

$pdo = pdo_connect_mysql();

$stmt = $pdo->prepare('SELECT * FROM FLOW ORDER BY SOURCE_LOT_ID');
$stmt->execute();
$product = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?= template_header('Read') ?>

<div class="content read">
	<h2>All Products</h2>
	<a href="create_flow.php" class="add-product">Add a new product</a>
    <input class="form-control" id="myInput" type="text" placeholder="Search..">
	<table>
        <thead>
            <tr>
                <td>SOURCE_LOT_ID</td>
                <td>SOURCE_ORG_ID</td>
                <td>TARGET_LOT_ID</td>
                <td>TARGET_ORG_ID</td>
                <td>BRAND_BARCODE</td>
                <td>QUANTITY</td>
                <td>FLOWDATE</td>
                <td></td>
            </tr>
        </thead>
        <tbody id="myTable">
            <?php foreach ($product as $element): ?>
            <tr>
                <td><?= $element['SOURCE_LOT_ID'] ?></td>
                <td><?= $element['SOURCE_ORG_ID'] ?></td>
                <td><?= $element['TARGET_LOT_ID'] ?></td>
                <td><?= $element['TARGET_ORG_ID'] ?></td>
                <td><?= $element['BRAND_BARCODE'] ?></td>
                <td><?= $element['QUANTITY'] ?></td>
                <td><?= $element['FLOWDATE'] ?></td>
                <td class="actions">

                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?= template_footer()
?>
