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

$stmt = $pdo->prepare(
    'SELECT * FROM PRODUCT_BRANDS ORDER BY M_SYSCODE, BRAND_BARCODE'
);
$stmt->execute();
$product = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?= template_header('Read') ?>

<div class="content read">
	<h2>All Product Brands</h2>
	<a href="create_product_brands.php" class="add-product">Add a new product brand</a>
	<input class="form-control" id="myInput" type="text" placeholder="Search..">
	<table>
        <thead>
            <tr>

                <td>BRAND_BARCODE</td>
                <td>BRAND_NAME</td>
                <td>MANUFACTURER_NAME</td>
                <td>M_SYSCODE</td>
                <td></td>
            </tr>
        </thead>
        <tbody id="myTable">
            <?php foreach ($product as $element): ?>
            <tr>

                <td><?= $element['BRAND_BARCODE'] ?></td>
                <td><?= $element['BRAND_NAME'] ?></td>

				<?php
					$stmt = $pdo->prepare('SELECT MANUFACTURER_NAME FROM MANUFACTURERS  WHERE MANUFACTURER_ID = ?');
                	$stmt->execute([$element['MANUFACTURER_ID']]);
                	$temp = $stmt->fetch();
				?>
                <td><?= $temp['MANUFACTURER_NAME'] ?></td>
                <td><?= $element['M_SYSCODE'] ?></td>
                <td class="actions">
                    <a href="update_product_brands.php?BRAND_BARCODE=<?= $element[
                        'BRAND_BARCODE'
                    ] ?>&M_SYSCODE=<?= $element[
    'M_SYSCODE'
] ?>" class="edit"><i class="far fa-edit"></i>UPDATE</a>
                    <a href="delete_product_brands.php?BRAND_BARCODE=<?= $element['BRAND_BARCODE'] ?>&M_SYSCODE=<?= $element['M_SYSCODE'
] ?>" class="trash"><i class="far fa-trash-alt"></i>DELETE</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?= template_footer()
?>

