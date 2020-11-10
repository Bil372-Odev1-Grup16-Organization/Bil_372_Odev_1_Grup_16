<?php
include 'functions.php';
include 'connect.php';
$msg = '';

//check if the given item with the primary key exists 
if (isset($_GET['ORG_ID'])) {
    $row=$_GET['ORG_ID'];
    $sql = "SELECT * FROM ORGANISATIONS WHERE ORG_ID = $row";
    $result = mysqli_query($conn,$sql);
    $organisation =mysqli_fetch_assoc($result);
    if (!$organisation) {
        exit('Organisation doesn\'t exist with that primary key!');
    }
   
    //Asking the users second time if they really want to delete the item
    if (isset($_GET['confirm'])) {
        if ($_GET['confirm'] == 'yes') {

            $sql = "DELETE FROM ORGANISATIONS WHERE ORG_ID = $row";
            $result = mysqli_query($conn,$sql);

            $msg = 'You have deleted the selected product!';
        } else {
            header('Location: read_organisation.php');
            exit;
        }
    }
} else {
    exit('No primary key has been specified!');
}
?>

<?=template_header('Delete')?>

<div class="Organisation delete">
	<h2>Delete Organisation #<?=$organisation['ORG_ID']?></h2>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php else: ?>
	<p>Are you sure you want to delete the selected organisation #<?=$organisation['ORG_ID']?>?</p>
    <div class="yesno">
        <a href="delete_organisation.php?ORG_ID=<?=$organisation['ORG_ID']?>&confirm=yes">Yes</a>
        <a href="delete_product.php?ORG_ID=<?=$organisation['ORG_ID']?>&confirm=no">No</a>
    </div>
    <?php endif; ?>
</div>

<?=template_footer()?>
