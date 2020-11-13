<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';

if (isset($_GET['BRAND_BARCODE']) & isset($_GET['M_SYSCODE'])) {
    if (!empty($_POST)) {
        $barcode = isset($_POST['BRAND_BARCODE'])
            ? $_POST['BRAND_BARCODE']
            : null;
        $name = isset($_POST['BRAND_NAME']) ? $_POST['BRAND_NAME'] : '';
        $id = isset($_POST['MANUFACTURER_ID']) ? $_POST['MANUFACTURER_ID'] : '';
        $code = isset($_POST['M_SYSCODE']) ? $_POST['M_SYSCODE'] : null;

        $stmt = $pdo->prepare(
            'UPDATE PRODUCT_BRANDS SET BRAND_NAME = ?, MANUFACTURER_ID = ? WHERE BRAND_BARCODE = ? AND M_SYSCODE = ?'
        );
        $stmt->execute([
            $name,
            $id,
            $_GET['BRAND_BARCODE'],
            $_GET['M_SYSCODE']
        ]);

        $msg = 'Updated Successfully!';
        header("location: create_product_brands.php");
        exit();
    }

    $stmt = $pdo->prepare(
        'SELECT * FROM PRODUCT_BRANDS WHERE BRAND_BARCODE = ? AND M_SYSCODE = ?'
    );
    $stmt->execute([$_GET['BRAND_BARCODE'], $_GET['M_SYSCODE']]);

    $contact = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$contact) {
        exit(
            'Product brand doesn\'t exist with that BRAND_BARCODE and M_SYSCODE!'
        );
    }
} else {
    exit('No BRAND_BARCODE and M_SYSCODE are selected!');
}
?>

<?= template_header('Read') ?>

<div class="content update">
	<h2>Update Product Brand #<?= $contact['M_SYSCODE'] ?></h2>
    <form action="update_product_brands.php?BRAND_BARCODE=<?= $contact[
        'BRAND_BARCODE'
    ] ?>&M_SYSCODE=<?= $element['M_SYSCODE'] ?>" method="post">
    <label for="BRAND_BARCODE">BRAND_BARCODE</label>
    <label for="BRAND_NAME">BRAND_NAME</label>
    <input type="text" name="BRAND_BARCODE" placeholder="example value" id="BRAND_BARCODE">
    <input type="text" name="BRAND_NAME" placeholder="example value" id="BRAND_NAME">

    <!-- dropdown menu should be added
    <label for="M_NAME">M_NAME</label>
    <label></label>
    -->
    <input type="text" name="MANUFACTURER_ID" placeholder="example value" id="MANUFACTURER_ID">
    <label></label>

    <input type="submit" value="Create">
    </form>
    <?php if ($msg): ?>
    <p><?= $msg ?></p>
    <?php endif; ?>
</div>

<?= template_footer()
?>
