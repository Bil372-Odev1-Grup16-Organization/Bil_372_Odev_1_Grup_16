<?php
session_start();
if(!isset($_SESSION['NAME'])){ //session check
    header("location: login.php");
 }
 if($_SESSION['NAME'] != 'Admin'){
     echo("<script>alert('Unauthorized Access')</script>");
     echo("<script>window.location = 'logout.php';</script>"); 
 }
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';

if (isset($_GET['BRAND_BARCODE']) & isset($_GET['M_SYSCODE'])) {
    if (!empty($_POST)) {
        $barcode = isset($_POST['BRAND_BARCODE']) ? $_POST['BRAND_BARCODE'] : '';
        $name = isset($_POST['BRAND_NAME']) ? $_POST['BRAND_NAME'] : '';
        $id = isset($_POST['MANUFACTURER_ID']) ? $_POST['MANUFACTURER_ID'] : '';
        $code = isset($_POST['M_SYSCODE']) ? $_POST['M_SYSCODE'] : '';

        $stmt = $pdo->prepare(
            'UPDATE PRODUCT_BRANDS SET BRAND_BARCODE =? , M_SYSCODE= ? ,BRAND_NAME = ?, MANUFACTURER_ID = ?  WHERE BRAND_BARCODE = ? AND M_SYSCODE = ?');
        $stmt->execute([$barcode, $code, $name, $id,$_GET['BRAND_BARCODE'],$_GET['M_SYSCODE']]);

        $msg = 'Updated Successfully!';
    }

    $stmt = $pdo->prepare(
    'SELECT * FROM PRODUCT_BRANDS WHERE BRAND_BARCODE = ? AND M_SYSCODE = ?');
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

$sql = "SELECT M_SYSCODE, M_NAME FROM PRODUCT";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$products = $stmt->fetchAll();

$sql = "SELECT MANUFACTURER_ID, MANUFACTURER_NAME FROM MANUFACTURERS";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$manufacturers = $stmt->fetchAll();

?>

<style>
select {
  width: 400px;
  height:43px;
  border-radius: 4px;
}
</style>

<?= template_header('Update') ?>

<div class="content update">
	<h2>Update Product Brand #<?= $contact['M_SYSCODE'] ?></h2>
    <form action="update_product_brands.php?BRAND_BARCODE=<?= $contact['BRAND_BARCODE'] ?>&M_SYSCODE=<?= $contact['M_SYSCODE'] ?>" method="post">

    <label for="BRAND_NAME">Brand Name</label>
    <label for="MANUFACTURER_NAME">Manufacturer Name</label>

    <input type="text" name="BRAND_NAME" placeholder="example value" value="<?=$contact['BRAND_NAME']?>" >
    <select name="MANUFACTURER_ID" required="required">
        <option disabled selected>Select a manufacturer</option>
        <?php foreach($manufacturers as $manufacturer): ?>
            <option value="<?= $manufacturer['MANUFACTURER_ID']; ?>"><?= $manufacturer['MANUFACTURER_NAME']; ?></option>
        <?php endforeach; ?>
    </select>

    <label for="product">Product Name</label>
    <label></label>

    <select name="M_SYSCODE" required="required">
        <option disabled selected>Select a product </option>
        <?php foreach($products as $product): ?>
            <option value="<?= $product['M_SYSCODE']; ?>"><?= $product['M_NAME']; ?></option>
        <?php endforeach; ?>
    </select>
    <label></label>

    <input type="submit" value="Update">
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

<?= template_footer()
?>
