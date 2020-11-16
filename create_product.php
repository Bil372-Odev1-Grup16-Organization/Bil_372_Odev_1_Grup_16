<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';

// Check if the data is empty
if (!empty($_POST)) {
    // Insert values into columns
    $id = isset($_POST['M_SYSCODE']) && !empty($_POST['M_SYSCODE']) && $_POST['M_SYSCODE'] != 'auto' ? $_POST['M_SYSCODE'] : NULL;
    $code = isset($_POST['M_CODE']) ? $_POST['M_CODE'] : '';
    $name = isset($_POST['M_NAME']) ? $_POST['M_NAME'] : '';
    $shortname = isset($_POST['M_SHORTNAME']) ? $_POST['M_SHORTNAME'] : '';
    $parentcode = isset($_POST['M_PARENTCODE']) ? $_POST['M_PARENTCODE'] : '';
    $abstract = isset($_POST['M_ABSTRACT']) ? 1 : 0;
    $category = isset($_POST['M_CATEGORY']) ? $_POST['M_CATEGORY'] : '';
    $active = isset($_POST['IS_ACTIVE']) ? 1 : 0;
    // Insert new record into the contacts table
    $stmt = $pdo->prepare('INSERT INTO PRODUCT VALUES (?, ?, ?, ?, ?, ?, ?, ?)');
    $stmt->execute([$id, $code,$name, $shortname,$parentcode, $abstract, $category,$active,]);
    // Output message
    $msg = 'Product created successfully!';
}
?>

<?= template_header('Create') ?>

<div class="content update">
	<h2>Create Product</h2>
    <form action="create_product.php" method="post">
        <label for="M_CODE">Product Code</label>
        <label for="M_NAME">Product Name</label>
        <input type="text" name="M_CODE" placeholder="example value" id="M_CODE">
        <input type="text" name="M_NAME" placeholder="example value" id="M_NAME">

        <label for="M_SHORTNAME">Product's Short Name</label>
        <label for="M_PARENTCODE">Parent Product</label>
        <input type="text" name="M_SHORTNAME" placeholder="evample value" id="M_SHORTNAME">
        <input type="text" name="M_PARENTCODE" placeholder="example value" id="M_PARENTCODE">

        <label for="M_CATEGORY">Category</label>
        <label></label>
        <input type="text" name="M_CATEGORY" placeholder="example value" id="M_CATEGORY">
        <label></label>

        <label for="M_ABSTRACT">Abstractness Status</label>
        <label for="IS_ACTIVE">Activity Status</label>
        <label><input style="width: 20px" type="checkbox" name="M_ABSTRACT" value="1" id="M_ABSTRACT"> Yes</label>
        <label><input style="width: 20px" type="checkbox" name="IS_ACTIVE" value="1" id="IS_ACTIVE"> Yes</label>

        <input type="submit" value="Create">
    </form>
    <?php if ($msg): ?>
    <?php
        $abstract = !isset($_POST['M_ABSTRACT']) ? 0 : '';
        $active = !isset($_POST['IS_ACTIVE']) ? 0 : '';
    ?>
    <p><?php
    echo "<script>alert('$msg')</script>";
    echo "<script>window.location = 'read_product.php';</script>";
    ?></p>
    <?php endif; ?>
</div>

<?= template_footer()
?>
