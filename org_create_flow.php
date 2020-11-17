<?php
session_start();
if(!isset($_SESSION['NAME'])){ //session check
   header("location: login.php");
}
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';

// Check if the data is empty
if (!empty($_POST)) {
    // Insert values into columns
    $source_lot = isset($_POST['SOURCE_LOT_ID']) ? $_POST['SOURCE_LOT_ID'] : '';
    $source_org = isset($_POST['SOURCE_ORG_ID']) ? $_POST['SOURCE_ORG_ID'] : '';
    $target_lot = isset($_POST['TARGET_LOT_ID']) ? $_POST['TARGET_LOT_ID'] : '';
    $target_org = isset($_POST['TARGET_LOT_ID']) ? $_POST['TARGET_LOT_ID'] : '';
    $barcode = isset($_POST['BRAND_BARCODE']) ? $_POST['BRAND_BARCODE'] : '';
    $quantitiy = isset($_POST['QUANTITIY']) ? $_POST['QUANTITIY'] : '';
    $flowdate = isset($_POST['FLOWDATE']) ? $_POST['FLOWDATE'] : '';
    // Insert new record into the contacts table
    $stmt = $pdo->prepare('INSERT INTO FLOW VALUES (?, ?, ?, ?, ?,?, ?)');
    $stmt->execute([$source_lot, $source_org,$target_lot, $target_org, $barcode, $quantitiy, $flowdate]);
    // Output message
    $msg = 'Created Successfully!';
}

$sql = "SELECT LOT_ID FROM brand_orgs";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$source = $stmt->fetchAll();

$sql = "SELECT LOT_ID FROM brand_orgs";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$target = $stmt->fetchAll();


$sql = "SELECT ORG_ID FROM brand_orgs";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$source_org = $stmt->fetchAll();

$sql = "SELECT ORG_ID FROM brand_orgs";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$target_org = $stmt->fetchAll();

$sql = "SELECT BRAND_BARCODE, BRAND_NAME FROM PRODUCT_BRANDS";
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
	<h2>Add Manufacturer</h2>
    <form action="org_create_flow.php" method="post">

        <label for="SOURCE_LOT_ID">Source Lot</label>
        <label for="TARGET_LOT_ID">Target Lot</label>

        <select name="SOURCE_LOT_ID" required="required">
            <option disabled selected>Select a target lot </option>
            <?php foreach($source as $source): ?>
                <option value="<?= $source['LOT_ID']; ?>"><?= $source['LOT_ID']; ?></option>
            <?php endforeach; ?>
        </select>

        <select name="TARGET_LOT_ID" required="required">
            <option disabled selected>Select a target lot </option>
            <?php foreach($target as $target): ?>
                <option value="<?= $target['LOT_ID']; ?>"><?= $target['LOT_ID']; ?></option>
            <?php endforeach; ?>
        </select>

        <label for="SOURCE_ORG_ID">Source Organisation</label>
        <label for="TARGET_ORG_ID">Target Organisation</label>

        <select name="SOURCE_ORG_ID" required="required">
            <option disabled selected>Select a source org </option>
            <?php foreach($source_org as $source_org): ?>
                <option value="<?= $source_org['ORG_ID']; ?>"><?= $source_org['ORG_ID']; ?></option>
            <?php endforeach; ?>
        </select>

        <select name="TARGET_ORG_ID" required="required">
            <option disabled selected>Select a target org </option>
            <?php foreach($target_org as $target_org): ?>
                <option value="<?= $target_org['ORG_ID']; ?>"><?= $target_org['ORG_ID']; ?></option>
            <?php endforeach; ?>
        </select>

        <label for="BRAND_BARCODE">Brand</label>
        <label for="QUANTITIY">Quantity</label>


        <select name="BRAND_BARCODE" required="required">
            <option disabled selected>Select a brand </option>
            <?php foreach($brand as $brand): ?>
                <option value="<?= $brand['BRAND_BARCODE']; ?>"><?= $brand['BRAND_NAME']; ?></option>
            <?php endforeach; ?>
        </select>

        <input type="text" name="QUANTITIY" placeholder="example value" id="QUANTITIY">

        <label for="FLOWDATE">Flow date</label>
        <input type="date" name="FLOWDATE" placeholder="example value" id="FLOWDATE">


        <input type="submit" value="Create">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>
