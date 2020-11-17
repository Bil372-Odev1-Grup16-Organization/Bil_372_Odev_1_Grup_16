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

if (isset($_POST['submit'])) {
    $brandResult = $_POST['brand'];
    $brand = explode('|', $brandResult);
    $alternativebrandResult = $_POST['alternativebrand'];
    $alternativebrand = explode('|', $alternativebrandResult);

    $stmt = $pdo->prepare('INSERT INTO ALTERNATIVE_BRANDS VALUES (?,?,?,?)');
    if($stmt->execute([$brand[1],$brand[0], $alternativebrand[1],$alternativebrand[0]])){
        echo("<script>alert('Created Successfully')</script>");
        echo("<script>window.location = 'read_alternativebrands.php';</script>");
    }
}

$sql = "SELECT BRAND_BARCODE, M_SYSCODE,BRAND_NAME FROM PRODUCT_BRANDS";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$brands = $stmt->fetchAll();

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
    <h2>Link Alternative Brands</h2>
    <form action="" method="post">

    <label for="Brand">Brand</label>
    <label for="Alternative Brand">Alternative Brand</label>
    <select name="brand" required="required">
        <option disabled selected>Select a brand </option>
        <?php foreach($brands as $brand): ?>
             <?php $stmt = $pdo->prepare("SELECT M_NAME  FROM PRODUCT WHERE M_SYSCODE = ?");          ?>
             <?php $stmt->execute([$brand['M_SYSCODE']]);   ?>
             <?php $product = $stmt->fetch();             ?>
            <option value="<?= $brand['M_SYSCODE'] . '|' . $brand['BRAND_BARCODE']; ?>"><?= $brand['BRAND_NAME'].  ' ' . $product['M_NAME']; ?></option>
        <?php endforeach; ?>
    </select>

    <select name="alternativebrand" style="margin-left: 25px">
        <option disabled selected required="required">Select an alternative brand </option>
        <?php foreach($brands as $brand): ?>
             <?php $stmt = $pdo->prepare("SELECT M_NAME  FROM PRODUCT WHERE M_SYSCODE = ?");          ?>
             <?php $stmt->execute([$brand['M_SYSCODE']]);   ?>
             <?php $product = $stmt->fetch();             ?>
            <option value="<?= $brand['M_SYSCODE'] . '|' . $brand['BRAND_BARCODE']; ?>"><?= $brand['BRAND_NAME']. '  ' . $product['M_NAME']; ?></option>
        <?php endforeach; ?>
    </select>


    <input type="submit" name="submit" value="Link">
</form>
</div>
