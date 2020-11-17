<?php
session_start();
if(!isset($_SESSION['NAME'])){ //session check
   header("location: login.php");
}
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';

// Check if the data is empty
if (!empty($_POST)) {
    // Insert values into columns
    $id = isset($_POST['FEATURE_ID']) && !empty($_POST['FEATURE_ID']) && $_POST['FEATURE_ID'] != 'auto' ? $_POST['FEATURE_ID'] : NULL;
    $name = isset($_POST['FEATURE_NAME']) ? $_POST['FEATURE_NAME'] : '';
    // Insert new record into the contacts table
    $stmt = $pdo->prepare('INSERT INTO FEATURES VALUES (?, ?)');
    $stmt->execute([$id, $name]);
    // Output message
    $msg = 'Feature created successfully!';
}
?>

<?=template_header('Create')?>
<div class="content update">
	<h2>Create Feature</h2>
    <form action="create_feature.php" method="post">
        <label for="FEATURE_NAME">Feature Name</label>
        <label></label>
        <input type="text" name="FEATURE_NAME" placeholder="example value" id="FEATURE_NAME">
        <label></label>

        <input type="submit" value="Create">
    </form>
    <?php if ($msg): ?>
    <p><?php
    echo "<script>alert('$msg')</script>";
    echo "<script>window.location = 'read_feature.php';</script>";
    ?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>
