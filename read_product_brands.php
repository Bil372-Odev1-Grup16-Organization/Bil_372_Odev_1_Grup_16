<?php
include 'functions.php';

$pdo = pdo_connect_mysql();

//TODO : Some PHP work to do
//$stmt = $pdo->prepare('SELECT * FROM MANUFACTURERS ORDER BY MANUFACTURER_ID');
$stmt->execute();
$product = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<?=template_header('Read')?>

<div class="content read">
	<h2>All Product Brands</h2>
	<a href="create_product_brands.php" class="add-product">Add a new product brand</a>
	<table>
        <thead>
            <tr>
                <td>#</td>
                <td>BRAND_BARCODE</td>
                <td>BRAND_NAME</td>
                <td>MANUFACTURER_ID</td>
                <td>M_SYSCODE</td>
                <td></td>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($product as $contact): ?>
            <tr>
                <td><?=$contact['BRAND_BARCODE']?></td>
                <td><?=$contact['BRAND_NAME']?></td>
                <td><?=$contact['MANUFACTURER_ID']?></td>
                <td><?=$contact['M_SYSCODE']?></td>
                <td class="actions">
										<!-- Double primary key lookup
                    <a href="update_product_brands.php?MANUFACTURER_ID=<?=$contact['MANUFACTURER_ID']?>" class="edit"><i class="fas fa-pen fa-xs"></i></a>
                    <a href="delete_product_brands.php?MANUFACTURER_ID=<?=$contact['MANUFACTURER_ID']?>" class="trash"><i class="fas fa-trash fa-xs"></i></a>
										<-->
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?=template_footer()?>
