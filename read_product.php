<?php
include 'functions.php';

$pdo = pdo_connect_mysql();

$stmt = $pdo->prepare('SELECT * FROM PRODUCT ORDER BY M_SYSCODE');
$stmt->execute();
$product = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<?=template_header('Read')?>

<div class="content read">
	<h2>All Products</h2>
	<a href="create_product.php" class="add-product">Add a new product</a>
	<table>
        <thead>
            <tr>
                <td>#</td>
                <td>M_CODE</td>
                <td>M_NAME</td>
                <td>M_SHORTNAME</td>
                <td>M_PARENTCODE</td>
                <td>M_ABSTRACT</td>
                <td>M_CATEGORY</td>
                <td>IS_ACTIVE</td>
                <td></td>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($product as $contact): ?>
            <tr>
                <td><?=$contact['M_SYSCODE']?></td>
                <td><?=$contact['M_CODE']?></td>
                <td><?=$contact['M_NAME']?></td>
                <td><?=$contact['M_SHORTNAME']?></td>
                <td><?=$contact['M_PARENTCODE']?></td>
                <td><?=$contact['M_ABSTRACT']?></td>
                <td><?=$contact['M_CATEGORY']?></td>
                <td><?=$contact['IS_ACTIVE']?></td>
                <td class="actions">
                    <a href="update_product.php?M_SYSCODE=<?=$contact['M_SYSCODE']?>" class="edit"><i class="fas fa-pen fa-xs"></i></a>
                    <a href="delete_product.php?M_SYSCODE=<?=$contact['M_SYSCODE']?>" class="trash"><i class="fas fa-trash fa-xs"></i></a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?=template_footer()?>
