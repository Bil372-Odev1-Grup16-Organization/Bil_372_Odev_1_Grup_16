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
if (isset($_GET['FEATURE_ID'])) {
    $stmt = $pdo->prepare('SELECT * FROM FEATURES WHERE FEATURE_ID = ?');
    $stmt->execute([$_GET['FEATURE_ID']]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$product) {
        exit('Feature doesn\'t exist with that primary key!');
    }

    //Asking the users second time if they really want to delete the item
    if (isset($_GET['confirm'])) {
        if ($_GET['confirm'] == 'yes') {
            $stmt = $pdo->prepare('DELETE FROM FEATURES WHERE FEATURE_ID = ?');
            $stmt->execute([$_GET['FEATURE_ID']]);
            $msg = 'Feature deleted successfully!';
        } else {
            header('Location: read_feature.php');
            exit;
        }
    }
} else {
    exit('No primary key has been specified!');
}
?>

<?=template_header('Delete')?>

<div class="feature delete">
	<h2>Delete Feature #<?=$product['FEATURE_ID']?></h2>
    <?php if ($msg): ?>
    <p><?php
    echo "<script>alert('$msg')</script>";
    echo "<script>window.location = 'read_feature.php';</script>";
    ?></p>
    <?php else: ?>
	<p>Are you sure you want to delete the selected feature #<?=$product['FEATURE_ID']?>?</p>
    <div class="yesno1">
        <a href="delete_feature.php?FEATURE_ID=<?=$product['FEATURE_ID']?>&confirm=yes">Yes</a>
        <a href="delete_feature.php?FEATURE_ID=<?=$product['FEATURE_ID']?>&confirm=no">No</a>
    </div>
    <?php endif; ?>
</div>

<?=template_footer()?>
