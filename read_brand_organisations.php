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

$stmt = $pdo->prepare('SELECT * FROM BRAND_ORGS ORDER BY LOT_ID');
$stmt->execute();
$product = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?= template_header('Read') ?>

<div class="content read">
	<h2>All Brand Organisations</h2>
	<a href="create_brand_organisations.php" class="add-product">Link Product & Features</a>
	<input class="form-control" id="myInput" type="text" placeholder="Search..">
	<table>
        <thead>
            <tr>
                <td>#</td>
                <td>Organisation Name</td>
                <td>Brand Name</td>
                <td>Expiry Date</td>
                <td>Base Price</td>
                <td>In Amount</td>
		<td>Out Amount</td>
		<td>Quantity</td>
		<td>Unit</td>
                <td></td>
            </tr>
        </thead>
        <tbody id="myTable">
            <?php foreach ($product as $element): ?>
            <tr>

              <?php   $stmt = $pdo->prepare('SELECT BRAND_NAME FROM PRODUCT_BRANDS WHERE BRAND_BARCODE = ?');                            ?>
              <?php   $stmt->execute([$element['BRAND_BARCODE']]);                           ?>
              <?php   $brand = $stmt->fetch();                           ?>
	          <?php   $stmt = $pdo->prepare('SELECT ORG_NAME FROM ORGANISATIONS WHERE ORG_ID = ?');                            ?>
              <?php   $stmt->execute([$element['ORG_ID']]);                           ?>
              <?php   $name = $stmt->fetch();                           ?>

                <td><?= $element['LOT_ID'] ?></td>
                <td><?= $name['ORG_NAME'] ?></td>
                <td><?= $brand['BRAND_NAME'] ?></td>
                <td><?= $element['EXPIRY_DATE'] ?></td>
                <td><?= $element['BASEPRICE'] ?></td>
                <td><?= $element['IN_AMOUNT'] ?></td>
		<td><?= $element['OUT_AMOUNT'] ?></td>
		<td><?= $element['QUANTITY'] ?></td>
		<td><?= $element['UNIT'] ?></td>
                <td class="actions">
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

