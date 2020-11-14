<?php
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
	<h2>All Links</h2>
	<a href="create_product_features.php" class="add-product">Link Product & Features</a>
	<table>
        <thead>
            <tr>
                <td>PRODUCT</td>
                <td>FEATURE</td>
                <td>MINVAL</td>
                <td>MAXVAL</td>
                
            </tr>
        </thead>
        <tbody>
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
