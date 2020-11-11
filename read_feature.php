<?php
include 'functions.php';

$pdo = pdo_connect_mysql();
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
$records_per_page = 5;

$stmt = $pdo->prepare('SELECT * FROM FEATURES ORDER BY FEATURE_ID LIMIT :current_page, :record_per_page');
$stmt->bindValue(':current_page', ($page-1)*$records_per_page, PDO::PARAM_INT);
$stmt->bindValue(':record_per_page', $records_per_page, PDO::PARAM_INT);
$stmt->execute();
$product = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<?=template_header('Read')?>

<div class="content read">
	<h2>All Features</h2>
	<a href="create_feature.php" class="add-product">Add a new feature</a>
	<table>
        <thead>
            <tr>
                <td>#</td>
                <td>FEATURE_NAME</td>
                <td></td>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($product as $contact): ?>
            <tr>
                <td><?=$contact['FEATURE_ID']?></td>
                <td><?=$contact['FEATURE_NAME']?></td>
                <td class="actions">
                    <a href="update_feature.php?FEATURE_ID=<?=$contact['FEATURE_ID']?>" class="edit"><i class="fas fa-pen fa-xs"></i></a>
                    <a href="delete_feature.php?FEATURE_ID=<?=$contact['FEATURE_ID']?>" class="trash"><i class="fas fa-trash fa-xs"></i></a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
	<div class="pagination">
		<?php if ($page > 1): ?>
		<a href="read_feature.php?page=<?=$page-1?>"><i class="fas fa-angle-double-left fa-sm"></i></a>
		<?php endif; ?>
		<a href="read_feature.php?page=<?=$page+1?>"><i class="fas fa-angle-double-right fa-sm"></i></a>
		
	</div>
</div>

<?=template_footer()?>
