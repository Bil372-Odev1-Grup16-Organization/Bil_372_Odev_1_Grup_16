<?php
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
                <td>ORG_NAME</td>
                <td>PARENT_ORG</td>
                <td>ORG_ABSTRACT</td>
                <td>ORG_ADDRESS</td>
                <td>ORG_CITY</td>
                <td>ORG_DISTRICT</td>
                <td>ORG_TYPE</td>
                <td></td>
            </tr>
        </thead>
        <tbody id="myTable">
            <?php foreach ($organisations as $organisation): ?>
            <tr>
                <td><?=$organisation['ORG_ID']?></td>
                <td><?=$organisation['ORG_NAME']?></td>
                <?php   $stmt = $pdo->prepare('SELECT ORG_NAME FROM ORGANISATIONS  WHERE ORG_ID = ?');                            ?>
                <?php   $stmt->execute([$organisation['PARENT_ORG']]);                           ?>
                <?php   $temp = $stmt->fetch();                           ?>
                <?php   if(!$temp):                          ?>
                    <td><?="NONE"?></td>
                <?php   else:                         ?>
                    <td><?=$temp['ORG_NAME']?></td>
                <?php  endif;     ?>
                <td><?=$organisation['ORG_ABSTRACT']?></td>
                <td><?=$organisation['ORG_ADDRESS']?></td>
                <?php $stmt = $pdo->prepare('SELECT CITY_NAME FROM COUNTRY_CITY  WHERE CITY_ID = ?');           ?>
                <?php  $stmt->execute([$organisation['ORG_CITY']]);           ?>
                <?php   $temp = $stmt->fetch();        ?>

                <td><?=$temp['CITY_NAME']?></td>
                <td><?=$organisation['ORG_DISTRICT']?></td>

                <?php  if($organisation['ORG_TYPE'] == 0):  ?>
                <?php  $temp='Supplier'  ?>
                <?php  elseif($organisation['ORG_TYPE'] == 1): ?>
                <?php  $temp='Consumer'  ?>
                <?php else :  ?>
                <?php  $temp='Both'  ?>
                <?php endif;  ?>
                <td><?=$temp?></td>
                <td class="actions">
                    <a href="update_organisation.php?ORG_ID=<?=$organisation['ORG_ID']?>" class="edit"><i class="fas fa-pen fa-xs"></i></a>
                    <a href="delete_organisation.php?ORG_ID=<?=$organisation['ORG_ID']?>" class="trash"><i class="fas fa-trash fa-xs"></i></a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?=template_footer()?>
