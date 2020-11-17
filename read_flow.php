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

$stmt = $pdo->prepare('SELECT * FROM FLOW ORDER BY SOURCE_LOT_ID');
$stmt->execute();
$product = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?= template_header('Read') ?>

<div class="content read">
	<h2>All Products</h2>
	<a href="create_flow.php" class="add-product">Add a new flow</a>
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
							<?php   $stmt = $pdo->prepare('SELECT ORG_NAME FROM ORGANISATIONS  WHERE ORG_ID = ?');                            ?>
							<?php   $stmt->execute([$element['SOURCE_ORG_ID']]);                           ?>
							<?php   $source_org = $stmt->fetch();                           ?>

							<?php   $stmt2 = $pdo->prepare('SELECT ORG_NAME FROM ORGANISATIONS  WHERE ORG_ID = ?');                            ?>
							<?php   $stmt2->execute([$element['TARGET_ORG_ID']]);                           ?>
							<?php   $target_org = $stmt2->fetch();                           ?>

							<?php   $stmt = $pdo->prepare('SELECT BRAND_NAME FROM PRODUCT_BRANDS  WHERE BRAND_BARCODE = ?');                            ?>
							<?php   $stmt->execute([$element['BRAND_BARCODE']]);                           ?>
							<?php   $brand = $stmt->fetch();                           ?>

                <td><?= $element['SOURCE_LOT_ID'] ?></td>
                <td><?= $source_org['ORG_NAME'] ?></td>
                <td><?= $element['TARGET_LOT_ID'] ?></td>
                <td><?= $target_org['ORG_NAME'] ?></td>
                <td><?= $brand['BRAND_NAME'] ?></td>
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
