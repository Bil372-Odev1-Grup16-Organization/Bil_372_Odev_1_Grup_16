<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';


if (!empty($_POST)) {
    $id = isset($_POST['FEATURE_ID']) && !empty($_POST['FEATURE_ID']) && $_POST['FEATURE_ID'] != 'auto' ? $_POST['FEATURE_ID'] : NULL;

    $name = isset($_POST['FEATURE_NAME']) ? $_POST['FEATURE_NAME'] : '';
    $stmt = $pdo->prepare('INSERT INTO FEATURES VALUES (?, ?)');
    $stmt->execute([$id, $name]);
    $msg = 'Created Successfully!';
}
?>

<?=template_header('Create')?>SELECT 

<div class="content update">
	<h2>Create Feature</h2>
    <form action="create_feature.php" method="post">
        <label for="FEATURE_NAME">Feature Name?</label>

        <input type="text" name="FEATURE_NAME" placeholder="example value" id="FEATURE_NAME">


        <input type="submit" value="Create">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>
