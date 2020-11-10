<?php
include 'functions.php';
// Connect to MySQL database
$pdo = pdo_connect_mysql();
// Get the page via GET request (URL param: page), if non exists default the page to 1
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
// Number of records to show on each page
$records_per_page = 5;

// Prepare the SQL statement and get records from our contacts table, LIMIT will determine the page
$stmt = $pdo->prepare('SELECT * FROM PRODUCT ORDER BY id LIMIT :current_page, :record_per_page');
$stmt->bindValue(':current_page', ($page-1)*$records_per_page, PDO::PARAM_INT);
$stmt->bindValue(':record_per_page', $records_per_page, PDO::PARAM_INT);
$stmt->execute();
// Fetch the records so we can display them in our template.
$contacts = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Get the total number of contacts, this is so we can determine whether there should be a next and previous button

?>

<?=template_header('Read')?>

<div class="content read">
	<h2>All Products</h2>
	<a href="create.php" class="add-product">Add a new product</a>
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
                <td>Created</td>
                <td></td>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($contacts as $contact): ?>
            <tr>
                <td><?=$contact['M_SYSCODE']?></td>
                <td><?=$contact['M_CODE']?></td>
                <td><?=$contact['M_NAME']?></td>
                <td><?=$contact['M_SHORTNAME']?></td>
                <td><?=$contact['M_PARENTCODE']?></td>
                <td><?=$contact['M_ABSTRACT']?></td>
                <td><?=$contact['M_CATEGORY']?></td>
                <td><?=$contact['IS_ACTIVE']?></td>
                <td><?=$contact['created']?></td>
                <td class="actions">
                    <a href="update.php?id=<?=$contact['M_SYSCODE']?>" class="edit"><i class="fas fa-pen fa-xs"></i></a>
                    <a href="delete.php?id=<?=$contact['M_SYSCODE']?>" class="trash"><i class="fas fa-trash fa-xs"></i></a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
	<div class="pagination">
		<?php if ($page > 1): ?>
		<a href="read.php?page=<?=$page-1?>"><i class="fas fa-angle-double-left fa-sm"></i></a>
		<?php endif; ?>
		<?php if ($page*$records_per_page < $num_contacts): ?>
		<a href="read.php?page=<?=$page+1?>"><i class="fas fa-angle-double-right fa-sm"></i></a>
		<?php endif; ?>
	</div>
</div>

<?=template_footer()?>
