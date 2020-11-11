<?php
include 'functions.php';

$pdo = pdo_connect_mysql();

$stmt = $pdo->prepare('SELECT * FROM MANUFACTURERS ORDER BY MANUFACTURER_ID');
$stmt->execute();
$product = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<?=template_header('Read')?>

<div class="content read">
	<h2>All Manufacturers</h2>
	<a href="create_manufacturers.php" class="add-product">Add a new manufacturer</a>
	<table>
        <thead>
            <tr>
                <td>#</td>
                <td>MANUFACTURER_NAME</td>
                <td>MANUFACTURER_ADDRESS</td>
                <td>CITY</td>
                <td>COUNTRY</td>
                <td></td>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($product as $contact): ?>
            <tr>
                <td><?=$contact['MANUFACTURER_ID']?></td>
                <td><?=$contact['MANUFACTURER_NAME']?></td>
                <td><?=$contact['MANUFACTURER_ADDRESS']?></td>
                <td><?=$contact['CITY']?></td>
                <td><?=$contact['COUNTRY']?></td>
                <td class="actions">
                    <a href="update_manufacturers.php?MANUFACTURER_ID=<?=$contact['MANUFACTURER_ID']?>" class="edit"><i class="fas fa-pen fa-xs"></i></a>
                    <a href="delete_manufacturers.php?MANUFACTURER_ID=<?=$contact['MANUFACTURER_ID']?>" class="trash"><i class="fas fa-trash fa-xs"></i></a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?=template_footer()?>
