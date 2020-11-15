<?php
include 'functions.php';
$pdo = pdo_connect_mysql();

$stmt = $pdo->prepare('SELECT * FROM MANUFACTURERS ORDER BY MANUFACTURER_ID');
$stmt->execute();
$product = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?= template_header('Read') ?>

<div class="content read">
	<h2>All Manufacturers</h2>
	<a href="create_manufacturers.php" class="add-product">Add a new manufacturer</a>
	<input class="form-control" id="myInput" type="text" placeholder="Search..">
	<table>
        <thead>
            <tr>
                <td>#</td>
                <td>Manufacturer Name</td>
                <td>Manufacturer Address</td>
                <td>Manufacturer City</td>
                <td>Manufacturer Country</td>
                <td></td>
            </tr>
        </thead>
        <tbody id="myTable">
            <?php foreach ($product as $element): ?>
            <tr>
                <td><?= $element['MANUFACTURER_ID'] ?></td>
                <td><?= $element['MANUFACTURER_NAME'] ?></td>
                <td><?= $element['MANUFACTURER_ADDRESS'] ?></td>
				<?php
					$stmt = $pdo->prepare('SELECT CITY_NAME FROM COUNTRY_CITY  WHERE CITY_ID = ?');
                	$stmt->execute([$element['CITY']]);
                	$temp = $stmt->fetch();
				?>
                <td><?=$temp['CITY_NAME']?></td>
				<?php
					$stmt = $pdo->prepare('SELECT COUNTRY_NAME FROM COUNTRY  WHERE COUNTRY_CODE = ?');
					$stmt->execute([$element['COUNTRY']]);
					$temp = $stmt->fetch();
				?>
                <td><?= $temp['COUNTRY_NAME'] ?></td>
                <td class="actions">
                    <a href="update_manufacturers.php?MANUFACTURER_ID=<?= $element[
                        'MANUFACTURER_ID'
                    ] ?>" class="edit"><i class="fas fa-pen fa-xs"></i></a>
                    <a href="delete_manufacturers.php?MANUFACTURER_ID=<?= $element[
                        'MANUFACTURER_ID'
                    ] ?>" class="trash"><i class="fas fa-trash fa-xs"></i></a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?= template_footer()
?>
