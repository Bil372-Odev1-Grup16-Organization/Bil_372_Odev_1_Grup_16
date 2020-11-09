<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
// Check if POST data is not empty
if (!empty($_POST)) {
    // Post data not empty insert a new record
    // Set-up the variables that are going to be inserted, we must check if the POST variables exist if not we can default them to blank
    $id = isset($_POST['M_SYSCODE']) && !empty($_POST['M_SYSCODE']) && $_POST['M_SYSCODE'] != 'auto' ? $_POST['M_SYSCODE'] : NULL;
    // Check if POST variable "name" exists, if not default the value to blank, basically the same for all variables
    $code = isset($_POST['M_CODE']) ? $_POST['M_CODE'] : '';
    $name = isset($_POST['M_NAME']) ? $_POST['M_NAME'] : '';
    $shortname = isset($_POST['M_SHORTNAME']) ? $_POST['M_SHORTNAME'] : '';
    $parentcode = isset($_POST['M_PARENTCODE']) ? $_POST['M_PARENTCODE'] : '';
    $abstract = isset($_POST['M_ABSTRACT']) ? $_POST['M_ABSTRACT'] : '';
    $category = isset($_POST['M_CATEGORY']) ? $_POST['M_CATEGORY'] : '';
    $active = isset($_POST['IS_ACTIVE']) ? $_POST['IS_ACTIVE'] : '';
    $created = isset($_POST['created']) ? $_POST['created'] : date('Y-m-d H:i:s');
    // Insert new record into the contacts table
    $stmt = $pdo->prepare('INSERT INTO contacts VALUES (?, ?, ?, ?, ?, ?)');
    $stmt->execute([$id, $code, $name, $shortname, $parentcode, $abstract, $abstract, $category, $active, $created]);
    // Output message
    $msg = 'Created Successfully!';
}
?>

<?=template_header('Create')?>

<div class="content update">
	<h2>Create Contact</h2>
    <form action="create.php" method="post">
        <label for="M_SYSCODE">SYSCODE</label>
        <label for="M_CODE">Code</label>
        <input type="text" name="M_SYSCODE" placeholder="example value" value="auto" id="M_SYSCODE">
        <input type="text" name="M_CODE" placeholder="example value" id="M_CODE">
        <label for="M_SHORTNAME">Short Name </label>
        <label for="M_PARENTCODE">Parent Code</label>
        <input type="text" name="M_SHORTNAME" placeholder="evample value" id="M_SHORTNAME">
        <input type="text" name="M_PARENTCODE" placeholder="example value" id="M_PARENTCODE">
        <label for="M_ABSTRACT">Is Abstract?</label>
        <label for="M_CATEGORY">Category</label>
        <input type="text" name="M_ABSTRACT" placeholder="example value" id="M_ABSTRACT">
        <input type="text" name="M_CATEGORY" placeholder="example value" id="M_CATEGORY">
        <label for="IS_ACTIVE">Is Active?</label>
        <label for="created">Created on </label>
        <input type="text" name="IS_ACTIVE" placeholder="example value" id="IS_ACTIVE">
        <input type="datetime-local" name="created" value="<?=date('Y-m-d\TH:i')?>" id="created">
        <input type="submit" value="Create">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>
