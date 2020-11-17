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
$msg = '';

//check if the given item with the primary key exists 
if (isset($_GET['ORG_ID'])) {
    $stmt = $pdo->prepare('SELECT * FROM ORGANISATIONS WHERE ORG_ID = ?');
    $stmt->execute([$_GET['ORG_ID']]);
    $organisation = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$organisation) {
        exit('Organisation doesn\'t exist with that primary key!');
    }
   
    //Asking the users second time if they really want to delete the item
    if (isset($_GET['confirm'])  and isset($_GET['option'])) {
        if($_GET['option'] == 'cascade'){
            $stmt = $pdo->prepare('DELETE FROM ORGANISATIONS  WHERE PARENT_ORG = ?'); //DELETE CHILDREN
            $stmt->execute([ $_GET['ORG_ID']]);
            
            $stmt = $pdo->prepare('DELETE FROM ORGANISATIONS  WHERE ORG_ID = ?'); //DELETE ORGANISATION
            $stmt->execute([ $_GET['ORG_ID']]);    
            $msg = 'You have deleted the selected product! (CASCADE)';       
        }
        elseif($_GET['option'] == 'link'){
            $stmt = $pdo->prepare('SELECT PARENT_ORG FROM ORGANISATIONS WHERE ORG_ID = ?');
            $stmt->execute([$_GET['ORG_ID']]);
            $parentOrg = $stmt->fetch();

            $stmt = $pdo->prepare('UPDATE ORGANISATIONS SET PARENT_ORG = ?   WHERE PARENT_ORG = ?'); //LINK CHILDREN TO UPPER PARENT
            $stmt->execute([$parentOrg['PARENT_ORG'], $_GET['ORG_ID']]);

            $stmt = $pdo->prepare('DELETE FROM ORGANISATIONS  WHERE ORG_ID = ?'); //DELETE ORGANISATION
            $stmt->execute([ $_GET['ORG_ID']]);           

            $msg = 'You have deleted the selected product! (LINK)';

        }   
    } 
    if (isset($_GET['confirm'])) {
        if ($_GET['confirm'] == 'no') {
            header('Location: read_organisations.php');
            exit();
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
    <?php if (!isset($_GET['confirm'])): ?>
	    <p>Are you sure you want to delete the selected organisation #<?=$organisation['ORG_ID']?>?</p>
        <div class="yesno1">
            <a href="delete_organisation.php?ORG_ID=<?=$organisation['ORG_ID']?>&confirm=yes">Yes</a>
            <a href="delete_organisation.php?ORG_ID=<?=$organisation['ORG_ID']?>&confirm=no">No</a>
        </div>
    <?php elseif ($_GET['confirm'] == 'yes'): ?>
        <p>Cascade Delete or Link Child Organisation to Parent Organisation #<?= $organisation['ORG_ID'] ?>?</p>
        <div class="yesno2">
            <a href="delete_organisation.php?ORG_ID=<?= $organisation['ORG_ID'] ?>&confirm=yes&option=cascade">Cascade delete</a>
            <a href="delete_organisation.php?ORG_ID=<?= $organisation['ORG_ID'] ?>&confirm=yes&option=link">Link child organisations to parent organisation</a>
        </div>
    <?php endif; ?>

    <?php endif; ?>
</div>

<?=template_footer()?>
