<?php
include 'functions.php';
$pdo = pdo_connect_mysql();

if (isset($_POST['submit'])) {
    echo "Don't leave any field empty";
    $id = isset($_POST['LOT_ID']) && !empty($_POST['LOT_ID']) && $_POST['LOT_ID'] != 'auto' ? $_POST['LOT_ID'] : NULL;
    $stmt = $pdo->prepare('INSERT INTO BRAND_ORGS VALUES (?,?,?,?,?,?,?,?,?)');
    if($stmt->execute([$id,$_POST['ORG_ID'], $_POST['BRAND_BARCODE'],$_POST['UNIT'], $_POST['EXPIRY_DATE'],$_POST['BASE_PRICE'], $_POST['IN_AMOUNT'],$_POST['OUT_AMOUNT'],$_POST['QUANTITY']])){
        echo("<script>alert('Created Successfully')</script>");
        echo("<script>window.location = 'read_product_features.php';</script>");
    }
}

$sql = "SELECT ORG_ID, ORG_NAME FROM ORGANISATIONS";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$products = $stmt->fetchAll();

$sql = "SELECT BRAND_BARCODE, BRAND_NAME FROM PRODUCT_BRANDS";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$features = $stmt->fetchAll();



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
<form action="" method="post">
    <label for="Organisation">Organisation</label>
    <label for="Brand">Brand</label>
    <select name="Organisation" required="required">
        <option disabled selected>Select an Organisation </option>
        <?php foreach($products as $product): ?>
            <option value="<?= $product['ORG_ID']; ?>"><?= $product['ORG_NAME']; ?></option>
        <?php endforeach; ?>
    </select>

    <select name="Brand" style="margin-left: 25px">
        <option disabled selected required="required">Select a brand </option>
        <?php foreach($features as $feature): ?>
            <option value="<?= $feature['BRAND_BARCODE']; ?>"><?= $feature['BRAND_NAME']; ?></option>
        <?php endforeach; ?>
    </select>

    <label for="UNIT">UNIT </label>
    <label for="EXPIRY_DATE">EXPIRY_DATE</label>
    <input type="number" name="UNIT" placeholder="example value" min="0" required="required">
    <input type="date" name="EXPIRY_DATE" placeholder="example value" required="required">

    <label for="BASE_PRICE">BASE_PRICE </label>
    <label for="IN_AMOUNT">IN_AMOUNT</label>
    <input type="number" name="BASE_PRICE" placeholder="example value" min="0" required="required">
    <input type="number" name="maxval" placeholder="example value" min="0" required="required">

    <label for="OUT_AMOUNT">OUT_AMOUNT </label>
    <label for="QUANTITY">QUANTITY</label>
    <input type="number" name="minval" placeholder="example value" min="0" required="required">
    <input type="number" name="maxval" placeholder="example value" min="0" required="required">

    <input type="submit" name="submit" value="Link">
</form>
</div>

