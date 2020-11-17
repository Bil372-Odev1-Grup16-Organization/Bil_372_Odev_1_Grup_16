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

$stmt = $pdo->prepare('SELECT * FROM FEATURES ORDER BY FEATURE_ID');
$stmt->execute();
$product = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<?=template_header('Read')?>

<div class="content read">
	<h2>All Features</h2>
	<a href="create_feature.php" class="add-product">Add a new feature</a>
	<input class="form-control" id="myInput" type="text" placeholder="Search..">
	<table>
        <thead>
            <tr>
                <td>#</td>
                <td>Feature Name</td>
                <td></td>
            </tr>
        </thead>
        <tbody id="myTable">
            <?php foreach ($product as $contact): ?>
            <tr>
                <td><?=$contact['FEATURE_ID']?></td>
                <td><?=$contact['FEATURE_NAME']?></td>
                <td class="actions">
                    <a href="update_feature.php?FEATURE_ID=<?=$contact['FEATURE_ID']?>" class="edit"><i class="far fa-edit"></i>UPDATE</a>
                    <a href="delete_feature.php?FEATURE_ID=<?=$contact['FEATURE_ID']?>" class="trash"><i class="far fa-trash-alt"></i>DELETE</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?=template_footer()?>
