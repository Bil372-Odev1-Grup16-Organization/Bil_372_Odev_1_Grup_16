<?php
include 'functions.php';

$pdo = pdo_connect_mysql();

$stmt = $pdo->prepare('SELECT * FROM PRODUCT ORDER BY M_SYSCODE');
$stmt->execute();
$product = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?= template_header('Read') ?>

<div class="content read">
	<h2>All Products</h2>
	<a href="create_product.php" class="add-product">Add a new product</a>
    <input class="form-control" id="myInput" type="text" placeholder="Search..">
	<table>
        <thead>
            <tr>
                <td>#</td>
                <td>Product Code</td>
                <td>Product Name</td>
                <td>Product's Short Name</td>
                <td>Parent Product</td>
                <td>Abstractness Status</td>
                <td>Category</td>
                <td>Activity Status</td>
                <td></td>
            </tr>
        </thead>
        <tbody id="myTable">
            <?php foreach ($product as $element): ?>
            <tr>
                <td><?= $element['M_SYSCODE'] ?></td>
                <td><?= $element['M_CODE'] ?></td>
                <td><?= $element['M_NAME'] ?></td>
                <td><?= $element['M_SHORTNAME'] ?></td>
                <td><?= $element['M_PARENTCODE'] ?></td>
                <td><?= $element['M_ABSTRACT'] ?></td>
                <td><?= $element['M_CATEGORY'] ?></td>
                <td><?= $element['IS_ACTIVE'] ?></td>
                <td class="actions">
                    <a href="update_product.php?M_SYSCODE=<?= $element[
                        'M_SYSCODE'
                    ] ?>" class="edit"><i class="fas fa-pen fa-xs"></i></a>
                    <a href="delete_product.php?M_SYSCODE=<?= $element[
                        'M_SYSCODE'
                    ] ?>" class="trash"><i class="fas fa-trash fa-xs"></i></a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?= template_footer()
?>
