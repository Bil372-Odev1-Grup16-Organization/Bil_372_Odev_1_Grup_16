<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';

// Check if the data is empty
if (!empty($_POST)) {
    // Insert values into columns
    $barcode = isset($_POST['BRAND_BARCODE']) ? $_POST['BRAND_BARCODE'] : '';
    $name = isset($_POST['BRAND_NAME']) ? $_POST['BRAND_NAME'] : '';
    $id = isset($_POST['MANUFACTURER_ID']) ? $_POST['MANUFACTURER_ID'] : '';
    $code = isset($_POST['M_SYSCODE']) ? $_POST['M_SYSCODE'] : '';

    // Insert new record into the contacts table
    $stmt = $pdo->prepare('INSERT INTO PRODUCT_BRANDS VALUES (?, ?, ?, ?)');
    $stmt->execute([$barcode, $name, $id, $code]);
    // Output message
    $msg = 'Created Successfully!';
}
?>

<?=template_header('Create')?>

<div class="content update">
	<h2>Create Product Brand</h2>
    <form action="create_product_brands.php" method="post">
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
