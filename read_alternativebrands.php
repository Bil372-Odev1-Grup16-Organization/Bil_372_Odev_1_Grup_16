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

$stmt = $pdo->prepare('SELECT * FROM ALTERNATIVE_BRANDS');
$stmt->execute();
$alternativebrands = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?= template_header('Read') ?>

<style>
.read table tbody tr td:nth-child(1) {
  	color: #000000;
}
</style>


<div class="content read">
	<h2>All Brands and Their Alternatives</h2>
	<a href="create_alternativebrand.php" class="add-product">Link Alternative Brands</a>
	<input class="form-control" id="myInput" type="text" placeholder="Search..">
	<table>
        <thead>
            <tr>
                <td>Brand Barcode</td>
                <td>Brand Name</td>
                <td>Alternative Brand Barcode</td>
                <td>Alternative Brand</td>

            </tr>
        </thead>
        <tbody id="myTable">
            <?php foreach ($alternativebrands as $element): ?>
            <tr>
                <?php  $stmt = $pdo->prepare('SELECT BRAND_NAME FROM PRODUCT_BRANDS WHERE BRAND_BARCODE=?');       ?>
                <?php  $stmt->execute([$element['BRAND_BARCODE']]);      ?>
                <?php  $brandName = $stmt->fetch();                  ?>

                <?php  $stmt = $pdo->prepare('SELECT BRAND_NAME FROM PRODUCT_BRANDS WHERE BRAND_BARCODE=?');   ?>
                <?php  $stmt->execute([$element['ALTERNATIVE_BRAND_BARCODE']]);                                   ?>
                <?php  $alternativebrandName=$stmt->fetch();           ?>

                <td><?= $element['BRAND_BARCODE'] ?></td>
                <td><?= $brandName['BRAND_NAME'] ?></td>
                <td><?= $element['ALTERNATIVE_BRAND_BARCODE'] ?></td>
                <td><?= $alternativebrandName['BRAND_NAME'] ?></td>

            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?= template_footer()
?>
