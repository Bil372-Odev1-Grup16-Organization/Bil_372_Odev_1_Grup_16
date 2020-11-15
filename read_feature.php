<?php
include 'functions.php';

$pdo = pdo_connect_mysql();

$stmt = $pdo->prepare('SELECT * FROM FEATURES ORDER BY FEATURE_ID');
$stmt->execute();
$product = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<?=template_header('Read')?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Search</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css">
</head>
<body>
<div class="container">
  <form class="form-inline" method="post" action="search_feature.php">
    <input type="text" name="roll_no" class="form-control" placeholder="Search Feature Name">
    <button type="submit" name="save" class="btn btn-primary">Search</button>
  </form>
</div>
</body>
</html>

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
</div>

<?=template_footer()?>
