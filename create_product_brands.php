<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';

if (!empty($_POST)) {
    $barcode = isset($_POST['BRAND_BARCODE']) ? $_POST['BRAND_BARCODE'] : '';
    $name = isset($_POST['BRAND_NAME']) ? $_POST['BRAND_NAME'] : '';
    $id = isset($_POST['MANUFACTURER_ID']) ? $_POST['MANUFACTURER_ID'] : '';
    $m_syscode = isset($_POST['M_SYSCODE']) ? $_POST['M_SYSCODE'] : '';

    $stmt = $pdo->prepare('INSERT INTO PRODUCT_BRANDS VALUES (?, ?, ?, ?)');
    $stmt->execute([$barcode, $name, $id, $m_syscode]);
    $msg = 'Created Successfully!';
}

$sql = "SELECT M_SYSCODE, M_NAME FROM PRODUCT";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$product = $stmt->fetchAll();


$sql = "SELECT MANUFACTURER_ID, MANUFACTURER_NAME FROM MANUFACTURERS";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$manufacturer = $stmt->fetchAll();

?>

<style>
select {
  width: 400px;
  height:43px;
  border-radius: 4px;
}
</style>

<?=template_header('Create')?>

<div class="content update">
	<h2>Create Product Brand</h2>
    <form action="create_product_brands.php" method="post">
      <label for="BRAND_BARCODE">Brand Barcode</label>
      <label for="BRAND_NAME">Brand Name</label>
      <input type="text" name="BRAND_BARCODE" placeholder="example value" id="BRAND_BARCODE">
      <input type="text" name="BRAND_NAME" placeholder="example value" id="BRAND_NAME">

      <label for="M_SYSCODE">Product</label>
      <label for="MANUFACTURER_NAME">Manufacturer Name</label>

      <select name="M_SYSCODE" required="required">
          <option disabled selected>Select a product</option>
          <?php foreach($product as $product): ?>
              <option value="<?= $product['M_SYSCODE']; ?>"><?= $product['M_NAME']; ?></option>
          <?php endforeach; ?>
      </select>

      <select name="MANUFACTURER_ID" required="required" style="margin-left: 25px">
          <option disabled selected>Select a manufacturer</option>
          <?php foreach($manufacturer as $manufacturer): ?>
              <option value="<?= $manufacturer['MANUFACTURER_ID']; ?>"><?= $manufacturer['MANUFACTURER_NAME']; ?></option>
          <?php endforeach; ?>
      </select>

      <input type="submit" value="Create">
    </form>
    <?php if ($msg): ?>
        <p>
        <?php
        echo "<script>alert('$msg')</script>";
        echo "<script>window.location = 'read_product_brands.php';</script>";
        ?>
        </p>
    <?php endif; ?>
</div>

<?=template_footer()?>
