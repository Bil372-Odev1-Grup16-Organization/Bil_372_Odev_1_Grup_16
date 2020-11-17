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
if (isset($_GET['FEATURE_ID'])) {
    if (!empty($_POST)) {
        $name = isset($_POST['FEATURE_NAME']) ? $_POST['FEATURE_NAME'] : '';
        $stmt = $pdo->prepare('UPDATE FEATURES SET FEATURE_NAME = ? WHERE FEATURE_ID = ?');
        $stmt->execute([$name, $_GET['FEATURE_ID']]);
        $msg = 'Feature updated successfully!';
    }
    $stmt = $pdo->prepare('SELECT * FROM FEATURES WHERE FEATURE_ID = ?');
    $stmt->execute([$_GET['FEATURE_ID']]);
    $contact = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$contact) {
        exit('Feature doesn\'t exist with that Feature ID!');
    }
} else {
    exit('No FEATURE_ID is selected!');
}
?>

<?=template_header('Read')?>

<div class="content update">
	<h2>Update Feature #<?=$contact['FEATURE_ID']?></h2>
    <form action="update_feature.php?FEATURE_ID=<?=$contact['FEATURE_ID']?>" method="post">
        <label for="FEATURE_NAME">Feature Name</label>
        <input type="text" name="FEATURE_NAME" placeholder="Example Value" value="<?=$contact['FEATURE_NAME']?>" id="FEATURE_NAME">
        <input type="submit" value="Update">
    </form>
    <?php if ($msg): ?>
    <p><?php
    echo "<script>alert('$msg')</script>";
    echo "<script>window.location = 'read_feature.php';</script>";
    ?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>
