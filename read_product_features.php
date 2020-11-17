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

$stmt = $pdo->prepare('SELECT * FROM PRODUCT_FEATURES ORDER BY M_SYSCODE');
$stmt->execute();
$product_features = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?= template_header('Read') ?>

<style>
.read table tbody tr td:nth-child(1) {
  	color: #000000;
}
</style>


<div class="content read">
	<h2>All Product & Features</h2>
	<a href="create_product_features.php" class="add-product">Link Product & Features</a>
	<input class="form-control" id="myInput" type="text" placeholder="Search..">
	<table>
        <thead>
            <tr>
                <td>Product</td>
                <td>Feature</td>
                <td>Minimum Value</td>
                <td>Maximum Value</td>
                
            </tr>
        </thead>
        <tbody id="myTable">
            <?php foreach ($product_features as $element): ?>
            <tr>
                <?php  $stmt = $pdo->prepare('SELECT M_NAME FROM PRODUCT WHERE M_SYSCODE=?');       ?>
                <?php  $stmt->execute([$element['M_SYSCODE']]);      ?>
                <?php  $productName = $stmt->fetch();                  ?>
                <?php  $stmt = $pdo->prepare('SELECT FEATURE_NAME FROM FEATURES WHERE FEATURE_ID=?');   ?>
                <?php  $stmt->execute([$element['FEATURE_ID']]);                                   ?>
                <?php  $featureName=$stmt->fetch();           ?>

                <td><?= $productName['M_NAME'] ?></td>
                <td><?= $featureName['FEATURE_NAME'] ?></td>
                <td><?= $element['MINVAL'] ?></td>
                <td><?= $element['MAXVAL'] ?></td>
                
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?= template_footer()
?>
