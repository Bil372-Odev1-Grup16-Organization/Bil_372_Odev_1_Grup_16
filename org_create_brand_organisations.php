<?php
session_start();
if(!isset($_SESSION['NAME'])){ //session check
   header("location: login.php");
}
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';

if (!empty($_POST)) {
  $id = isset($_POST['LOT_ID']) && !empty($_POST['LOT_ID']) && $_POST['LOT_ID'] != 'auto' ? $_POST['LOT_ID'] : NULL;
    $org_id = isset($_POST['ORG_ID']) ? $_POST['ORG_ID'] : '';
    $barcode = isset($_POST['BRAND_BARCODE']) ? $_POST['BRAND_BARCODE'] : '';
    $expiry_date = isset($_POST['EXPIRY_DATE']) ? $_POST['EXPIRY_DATE'] : '';
    $base_price = isset($_POST['BASE_PRICE']) ? $_POST['BASE_PRICE'] : '';
    $in_amount = isset($_POST['IN_AMOUNT']) ? $_POST['IN_AMOUNT'] : '';
    $out_amount = isset($_POST['OUT_AMOUNT']) ? $_POST['OUT_AMOUNT'] : '';
    $unit = isset($_POST['UNIT']) ? $_POST['UNIT'] : '';

    $stmt = $pdo->prepare('INSERT INTO brand_orgs (LOT_ID,ORG_ID,BRAND_BARCODE,EXPIRY_DATE,BASE_PRICE,IN_AMOUNT,OUT_AMOUNT,UNIT) VALUES (?, ?, ?, ?, ?, ?, ?,?)');
    $stmt->execute([$id, $org_id, $barcode, $expiry_date,$base_price, $in_amount, $out_amount, $unit]);
    $msg = 'Created Successfully!';
}

$sql = "SELECT ORG_ID, ORG_NAME FROM organisations";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$org = $stmt->fetchAll();


$sql = "SELECT BRAND_BARCODE, BRAND_NAME FROM product_brands";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$brand = $stmt->fetchAll();

?>

<style>
select {
  width: 400px;
  height:43px;
  border-radius: 4px;

}
</style>

<?=template_header_organisation('Create')?>

<div class="content update">
	<h2>Link Brand & Organisation</h2>
    <form action="org_create_brand_organisations.php" method="post">

      <label for="ORG_ID">Organisation ID</label>
      <label for="BRAND_BARCODE">Brand Barcode</label>

      <select name="ORG_ID" required="required">
          <option disabled selected>Select an organisation </option>
          <?php foreach($org as $org): ?>
              <option value="<?= $org['ORG_ID']; ?>"><?= $org['ORG_NAME']; ?></option>
          <?php endforeach; ?>
      </select>

      <select name="BRAND_BARCODE" required="required" style="margin-left: 25px">
          <option disabled selected>Select a brand </option>
          <?php foreach($brand as $brand): ?>
              <option value="<?= $brand['BRAND_BARCODE']; ?>"><?= $brand['BRAND_NAME']; ?></option>
          <?php endforeach; ?>
      </select>

      <label for="EXPIRY_DATE">Expiry Date</label>
      <label for="BASE_PRICE">Base Price</label>
      <input type="date" name="EXPIRY_DATE" placeholder="example value" id="EXPIRY_DATE">
      <input type="float" name="BASE_PRICE" placeholder="example value" id="BASE_PRICE">

      <label for="IN_AMOUNT">In Amount</label>
      <label for="OUT_AMOUNT">Out Amount</label>
      <input type="float" name="IN_AMOUNT" placeholder="example value" id="IN_AMOUNT">
      <input type="float" name="OUT_AMOUNT" placeholder="example " id="OUT_AMOUNT">

      <label for="UNIT">Unit</label>
      <label></label>
      <select  name="UNIT"  >
                <option>kg</option>
                <option>number</option>
                <option>litres</option>
        </select>
      <label></label>

      <input type="submit" value="Create">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>
