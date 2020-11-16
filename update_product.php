<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
if (isset($_GET['M_SYSCODE'])) {
    if (!empty($_POST)) {
        $code = isset($_POST['M_CODE']) ? $_POST['M_CODE'] : '';
        $name = isset($_POST['M_NAME']) ? $_POST['M_NAME'] : '';
        $shortname = isset($_POST['M_SHORTNAME']) ? $_POST['M_SHORTNAME'] : '';
        $parentcode = isset($_POST['M_PARENTCODE']) ? $_POST['M_PARENTCODE'] : '';
        $abstract = isset($_POST['M_ABSTRACT']) ? 1 : 0 ;
        $category = isset($_POST['M_CATEGORY']) ? $_POST['M_CATEGORY'] : '';
        $active = isset($_POST['IS_ACTIVE']) ? 1 : 0;

        // line[16, 31] and line[32, 40] should change order ?
        $stmt = $pdo->prepare(
            'UPDATE PRODUCT SET M_CODE = ?, M_NAME = ?,M_SHORTNAME = ?, M_PARENTCODE = ?, M_ABSTRACT = ?, M_CATEGORY = ?, IS_ACTIVE = ? WHERE M_SYSCODE = ?'
        );
        $stmt->execute([
            $code,
            $name,
            $shortname,
            $parentcode,
            $abstract,
            $category,
            $active,
            $_GET['M_SYSCODE'],
        ]);
        $msg = 'Product updated successfully!';
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

<?= template_header('Update') ?>

<div class="content update">
	<h2>Update Product #<?= $contact['M_SYSCODE'] ?></h2>
    <form action="update_product.php?M_SYSCODE=<?= $contact[
        'M_SYSCODE'
    ] ?>" method="post">
        <label for="M_CODE">Product Code</label>
        <label for="M_NAME">Product Name</label>
        <input type="text" name="M_CODE" placeholder="Value" value="<?= $contact[
            'M_CODE'
        ] ?>" id="M_CODE">
        <input type="text" name="M_NAME" placeholder="Value" value="<?= $contact[
            'M_NAME'
        ] ?>" id="M_NAME">

        <label for="M_SHORTNAME">Product's Short Name</label>
        <label for="M_PARENTCODE">Parent Product</label>
        <input type="text" name="M_SHORTNAME" placeholder="Value" value="<?= $contact[
            'M_SHORTNAME'
        ] ?>" id="M_SHORTNAME">
        <input type="text" name="M_PARENTCODE" placeholder="Value" value="<?= $contact[
            'M_PARENTCODE'
        ] ?>" id="M_PARENTCODE">

        <label for="M_CATEGORY">Category</label>
        <label></label>
        <input type="text" name="M_CATEGORY" placeholder="Value" value="<?= $contact[
            'M_CATEGORY'
        ] ?>" id="M_CATEGORY">
        <label></label>

        <!-- should be checked if it is already checked -->
        <!-- need debug -->
        <label for="M_ABSTRACT">Abstractness Status</label>
        <label for="IS_ACTIVE">Activity Status</label>
        <label><input style="width: 20px" type="checkbox" name="M_ABSTRACT" value="1" id="M_ABSTRACT"> Yes</label>
        <label><input style="width: 20px" type="checkbox" name="IS_ACTIVE" value="1" id="IS_ACTIVE"> Yes</label>

        <input type="submit" value="Update">
    </form>
    <?php if ($msg): ?>
    <?php
        $abstract = isset($_POST['M_ABSTRACT']) ? 1 : 0;
        $active = isset($_POST['IS_ACTIVE']) ? 1 : 0;
    ?>
    <p><?php
    echo "<script>alert('$msg')</script>";
    echo "<script>window.location = 'read_product.php';</script>";
    ?></p>
    <?php endif; ?>
</div>

<?= template_footer()
?>
