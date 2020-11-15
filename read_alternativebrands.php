<?php
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
	<a href="create_alternativebrand.php" class="add-product">Link Brands</a>
	<table>
        <thead>
            <tr>
                <td>BRAND_BARCODE</td>
                <td>BRAND</td>
                <td>ALTERNATIVE BRAND_BARCODE</td>
                <td>ALTERNATIVE BRAND</td>
                
            </tr>
        </thead>
        <tbody>
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