<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
if (isset($_GET['FEATURE_ID'])) {
    if (!empty($_POST)) {
        $FEATURE_ID = isset($_POST['FEATURE_ID']) ? $_POST['FEATURE_ID'] : NULL;
        $FEATURE_NAME = isset($_POST['FEATURE_NAME']) ? $_POST['FEATURE_NAME'] : '';
        //$created = isset($_POST['created']) ? $_POST['created'] : date('Y-m-d H:i:s');
        $stmt = $pdo->prepare('UPDATE FEATURES SET FEATURE_ID = ?, FEATURE_NAME = ? WHERE FEATURE_ID = ?');
        $stmt->execute([$FEATURE_ID, $FEATURE_NAME, $_GET['FEATURE_ID']]);
        $msg = 'Updated Successfully!';
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
        <label for="FEATURE_NAME">FEATURE_NAME</label>
        <!-- <label for="created">Created</label> -->
        <input type="text" name="FEATURE_NAME" placeholder="Example Value" value="<?=$contact['FEATURE_NAME']?>" id="FEATURE_NAME">
        <!-- <input type="datetime-local" name="created" value="<?=date('Y-m-d\TH:i', strtotime($contact['created']))?>" id="created"> -->
        <input type="submit" value="Update">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>
