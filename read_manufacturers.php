<?php
include 'functions.php';

$pdo = pdo_connect_mysql();
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
$records_per_page = 5;

$stmt = $pdo->prepare('SELECT * FROM MANUFACTURERS ORDER BY MANUFACTURER_ID LIMIT :current_page, :record_per_page');
$stmt->bindValue(':current_page', ($page-1)*$records_per_page, PDO::PARAM_INT);
$stmt->bindValue(':record_per_page', $records_per_page, PDO::PARAM_INT);
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
	<div class="pagination">
		<?php if ($page > 1): ?>
		<a href="read_manufacturers.php?page=<?=$page-1?>"><i class="fas fa-angle-double-left fa-sm"></i></a>
		<?php endif; ?>
		<?php if ($page*$records_per_page < $num_contacts): ?>
		<a href="read_manufacturers.php?page=<?=$page+1?>"><i class="fas fa-angle-double-right fa-sm"></i></a>
		<?php endif; ?>
	</div>
</div>

<?=template_footer()?>
