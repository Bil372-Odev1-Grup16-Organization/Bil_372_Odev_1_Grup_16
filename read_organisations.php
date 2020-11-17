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

$stmt = $pdo->prepare('SELECT * FROM ORGANISATIONS ORDER BY ORG_ID');
$stmt->execute();
$organisations = $stmt->fetchAll(PDO::FETCH_ASSOC);



?>

<?=template_header('Read')?>

<div class="content read">
	<h2>All Organisations</h2>
	<a href="create_organisation.php" class="add-product">Add a new organisation</a>
	<input class="form-control" id="myInput" type="text" placeholder="Search..">
	<table>
        <thead>
            <tr>
                <td>#</td>
                <td>Name</td>
                <td>Parent Organisation</td>
                <td>Abstractness Status</td>
                <td>Address</td>
                <td>City</td>
                <td>District</td>
                <td>Organisation Type</td>
                <td></td>
            </tr>
        </thead>
        <tbody id="myTable">
            <?php foreach ($organisations as $element): ?>
            <tr>
							<?php   $stmt = $pdo->prepare('SELECT ORG_NAME FROM ORGANISATIONS  WHERE ORG_ID = ?');                            ?>
							<?php   $stmt->execute([$element['PARENT_ORG']]);                           ?>
							<?php   $parent_org = $stmt->fetch();                           ?>

							<?php $stmt = $pdo->prepare('SELECT CITY_NAME FROM COUNTRY_CITY  WHERE CITY_ID = ?');           ?>
							<?php  $stmt->execute([$element['ORG_CITY']]);           ?>
							<?php   $city = $stmt->fetch();        ?>


							<?php $stmt = $pdo->prepare('SELECT ORG_TYPE FROM ORGANISATIONS  WHERE ORG_ID = ?');           ?>
							<?php  $stmt->execute([$element['ORG_TYPE']]);           ?>
							<?php   $type = $stmt->fetch();        ?>



                <td><?=$element['ORG_ID']?></td>
                <td><?=$element['ORG_NAME']?></td>
                <?php   if(!$parent_org):                          ?>
	                     <td><?="NONE"?></td>
	                 <?php   else:                         ?>
	                     <td><?=$parent_org['ORG_NAME']?></td>
	                 <?php  endif;     ?>
                <td><?=$element['ORG_ABSTRACT']?></td>
								<td><?= $element['ORG_ADDRESS'] ?></td>
								<td><?=$city['CITY_NAME']?></td>
								<td><?= $element['ORG_DISTRICT'] ?></td>

                <?php  if($element['ORG_TYPE'] == 0):  ?>
                <?php  $type='Supplier'  ?>
                <?php  elseif($element['ORG_TYPE'] == 1): ?>
                <?php  $type='Consumer'  ?>
                <?php else :  ?>
                <?php  $type='Both'  ?>
                <?php endif;  ?>
                <td><?=$type?></td>
                <td class="actions">
                    <a href="update_organisation.php?ORG_ID=<?=$element['ORG_ID']?>" class="edit"><i class="far fa-edit"></i>UPDATE</a>
                    <a href="delete_organisation.php?ORG_ID=<?=$element['ORG_ID']?>" class="trash"><i class="far fa-trash-alt"></i>DELETE</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?=template_footer()?>

