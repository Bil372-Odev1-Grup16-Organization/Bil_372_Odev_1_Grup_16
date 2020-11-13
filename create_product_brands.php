<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';

if (!empty($_POST)) {
    $barcode = isset($_POST['BRAND_BARCODE']) ? $_POST['BRAND_BARCODE'] : '';
    $name = isset($_POST['BRAND_NAME']) ? $_POST['BRAND_NAME'] : '';
    $id = isset($_POST['MANUFACTURER_ID']) ? $_POST['MANUFACTURER_ID'] : '';

    $stmt = $pdo->prepare('INSERT INTO PRODUCT_BRANDS VALUES (?, ?, ?, ?)');
    $stmt->execute([$barcode, $name, $id, $code]);
    $msg = 'Created Successfully!';
}
?>

<?=template_header('Create')?>

<div class="content update">
	<h2>Create Product Brand</h2>
    <form action="create_product_brands.php" method="post">
      <label for="BRAND_BARCODE">BRAND_BARCODE</label>
      <label for="BRAND_NAME">BRAND_NAME</label>
      <input type="text" name="BRAND_BARCODE" placeholder="example value" id="BRAND_BARCODE">
      <input type="text" name="BRAND_NAME" placeholder="example value" id="BRAND_NAME">

      <!-- MANUFACTURER_NAME will be selected by a dropdown menu <-->
      <label for="MANUFACTURER_NAME">MANUFACTURER_NAME</label>
      <label></label>
      <input type="text" name="MANUFACTURER_ID" placeholder="example value" id="MANUFACTURER_ID">
      <label></label>

      <input type="submit" value="Create">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>
