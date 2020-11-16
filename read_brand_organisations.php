<?php
include 'functions.php';

$pdo = pdo_connect_mysql();

$stmt = $pdo->prepare('SELECT * FROM BRAND_ORGS ORDER BY LOT_ID');
$stmt->execute();
$product = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?= template_header('Read') ?>

<div class="content read">
	<h2>All Products</h2>
	<a href="create_brand_organisations.php" class="add-product">Link Product & Features</a>
	<input class="form-control" id="myInput" type="text" placeholder="Search..">
	<table>
        <thead>
            <tr>
                <td>#</td>
                <td>ORG_ID</td>
                <td>BRAND_BARCODE</td>
                <td>EXPIRY_DATE</td>
                <td>BASEPRICE</td>
                <td>IN_AMOUNT</td>
		<td>OUT_AMOUNT</td>
		<td>QUANTITY</td>
		<td>UNIT</td>
                <td></td>
            </tr>
        </thead>
        <tbody id="myTable">
            <?php foreach ($product as $element): ?>
            <tr>
                <td><?= $element['LOT_ID'] ?></td>
                <td><?= $element['ORG_ID'] ?></td>
                <td><?= $element['BRAND_BARCODE'] ?></td>
                <td><?= $element['EXPIRY_DATE'] ?></td>
                <td><?= $element['BASEPRICE'] ?></td>
                <td><?= $element['IN_AMOUNT'] ?></td>
		<td><?= $element['OUT_AMOUNT'] ?></td>
		<td><?= $element['QUANTITY'] ?></td>
		<td><?= $element['UNIT'] ?></td>
                <td class="actions">
                    <a href="update_brand_organisations.php?M_SYSCODE=<?= $element[
                        'M_SYSCODE'
                    ] ?>" class="edit"><i class="far fa-edit"></i>UPDATE</a>
                    <a href="delete_brand_organisations.php?M_SYSCODE=<?= $element[
                        'M_SYSCODE'
                    ] ?>" class="trash"><i class="far fa-trash-alt"></i>DELETE</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?= template_footer()
?>
