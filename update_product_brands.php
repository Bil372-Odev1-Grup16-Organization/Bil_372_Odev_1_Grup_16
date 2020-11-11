$id<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
// What should be the key inside GET ?
//if (isset($_GET['MANUFACTURER_ID'])) {
    if (!empty($_POST)) {
        $barcode = isset($_POST['BRAND_BARCODE']) ? $_POST['BRAND_BARCODE'] : NULL;
        $name = isset($_POST['BRAND_NAME']) ? $_POST['BRAND_NAME'] : '';
        $id = isset($_POST['MANUFACTURER_ID']) ? $_POST['MANUFACTURER_ID'] : '';
        $code = isset($_POST['M_SYSCODE']) ? $_POST['M_SYSCODE'] : NULL;

        //$created = isset($_POST['created']) ? $_POST['created'] : date('Y-m-d H:i:s');
        /* Might be double key inside WHERE, also in line there might be 2 GET statements
        $stmt = $pdo->prepare('UPDATE PRODUCT_BRANDS SET BRAND_BARCODE = ?, BRAND_NAME = ?, MANUFACTURER_ID = ?, M_SYSCODE = ? WHERE MANUFACTURER_ID = ?');
        $stmt->execute([$id, $name, $address, $city, $country, $_GET['MANUFACTURER_ID']]);
        */
        $msg = 'Updated Successfully!';
    }
    /* where might take double key, also on line 22
    $stmt = $pdo->prepare('SELECT * FROM PRODUCT_BRANDS WHERE MANUFACTURER_ID = ?');
    $stmt->execute([$_GET['MANUFACTURER_ID']]);
    */
    $contact = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$contact) {
        /* Error message might change due to double key situation
        exit('Product brand doesn\'t exist with that Manufacturer ID!');
        */
    }
} else {
    /* Same as line 26
    exit('No MANUFACTURER_ID is selected!');
    */
}
?>

<?=template_header('Read')?>

<div class="content update">
  <!-- contact statements might change due to double keys
	<h2>Update Product Brand #<?=$contact['MANUFACTURER_ID']?></h2>
    <form action="update_product_brands.php?MANUFACTURER_ID=<?=$contact['MANUFACTURER_ID']?>" method="post">
    <-->
    <label for="BRAND_BARCODE">Brand Barcode</label>
    <label for="BRAND_NAME">Brand Name</label>
    <input type="text" name="BRAND_BARCODE" placeholder="example value" id="BRAND_BARCODE">
    <input type="text" name="BRAND_NAME" placeholder="example value" id="BRAND_NAME">

    <label for="MANUFACTURER_ID">Manufacturer ID</label>
    <label for="M_SYSCODE">Bir seyler kodu</label>
    <input type="text" name="MANUFACTURER_ID" placeholder="example value" id="MANUFACTURER_ID">
    <input type="text" name="M_SYSCODE" placeholder="example value" id="M_SYSCODE">

    <input type="submit" value="Create">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>
