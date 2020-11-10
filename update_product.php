<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
if (isset($_GET['M_SYSCODE'])) {
    if (!empty($_POST)) {
        $syscode = isset($_POST['M_SYSCODE']) ? $_POST['M_SYSCODE'] : NULL;
        $code = isset($_POST['M_CODE']) ? $_POST['M_CODE'] : '';
        $name = isset($_POST['M_NAME']) ? $_POST['M_NAME'] : '';
        $shortname = isset($_POST['M_SHORTNAME']) ? $_POST['M_SHORTNAME'] : '';
        $parentcode = isset($_POST['M_PARENTCODE']) ? $_POST['M_PARENTCODE'] : '';
        $abstract = isset($_POST['M_ABSTRACT']) ? $_POST['M_ABSTRACT'] : '';
        $category = isset($_POST['M_CATEGORY']) ? $_POST['M_CATEGORY'] : '';
        $created = isset($_POST['created']) ? $_POST['created'] : date('Y-m-d H:i:s');
        // Update the record
        $stmt = $pdo->prepare('UPDATE PRODUCT SET M_SYSCODE = ?, M_CODE = ?, NAME = ?,M_SHORTNAME = ?, M_PARENTCODE = ?, M_ABSTRACT = ?, M_CATEGORY = ?, created = ? WHERE M_SYSCODE = ?');
        $stmt->execute([$syscode, $code, $name, $shortname, $parentcode, $abstract, $category, $created, $_GET['M_SYSCODE']]);
        $msg = 'Updated Successfully!';
    }
    $stmt = $pdo->prepare('SELECT * FROM PRODUCT WHERE M_SYSCODE = ?');
    $stmt->execute([$_GET['M_SYSCODE']]);
    $contact = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$contact) {
        exit('Product doesn\'t exist with that M_SYSCODE!');
    }
} else {
    exit('No M_SYSCODE is selected!');
}
?>

<?=template_header('Read')?>

<div class="content update">
	<h2>Update Product #<?=$contact['M_SYSCODE']?></h2>
    <form action="update_product.php?M_SYSCODE=<?=$contact['M_SYSCODE']?>" method="post">
        <label for="M_CODE">M_CODE</label>
        <label for="M_NAME">M_NAME</label>
        <input type="text" name="M_CODE" placeholder="Value" value="<?=$contact['M_CODE']?>" id="M_CODE">
        <input type="text" name="M_NAME" placeholder="Value" value="<?=$contact['M_NAME']?>" id="M_NAME">

        <label for="M_SHORTNAME">M_SHORTNAME</label>
        <label for="M_PARENTCODE">M_PARENTCODE</label>
        <input type="text" name="M_SHORTNAME" placeholder="Value" value="<?=$contact['M_SHORTNAME']?>" id="M_SHORTNAME">
        <input type="text" name="M_PARENTCODE" placeholder="Value" value="<?=$contact['M_PARENTCODE']?>" id="M_PARENTCODE">

        <label for="M_ABSTRACT">M_ABSTRACT</label>
        <label for="M_CATEGORY">M_CATEGORY</label>
        <input type="text" name="M_ABSTRACT" placeholder="Example Value" value="<?=$contact['M_ABSTRACT']?>" id="M_ABSTRACT">
        <input type="text" name="M_CATEGORY" placeholder="Example Value" value="<?=$contact['M_CATEGORY']?>" id="M_CATEGORY">

        <label for="IS_ACTIVE">IS_ACTIVE</label>
        <label for="created">Created</label>
        <input type="text" name="IS_ACTIVE" placeholder="Example Value" value="<?=$contact['IS_ACTIVE']?>" id="IS_ACTIVE">
        <input type="datetime-local" name="created" value="<?=date('Y-m-d\TH:i', strtotime($contact['created']))?>" id="created">
        <input type="submit" value="Update">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>
