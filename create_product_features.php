<?php
session_start();
if(!isset($_SESSION['NAME'])){ //session check
   header("location: login.php");
}
include 'functions.php';
$pdo = pdo_connect_mysql();

if (isset($_POST['submit'])) {
    echo "Don't leave any field empty";
    $stmt = $pdo->prepare('INSERT INTO PRODUCT_FEATURES(M_SYSCODE,FEATURE_ID,MINVAL,MAXVAL) VALUES (?,?,?,?)');
    if($stmt->execute([$_POST['product'],$_POST['feature'], $_POST['minval'],$_POST['maxval']])){
        echo("<script>alert('Created Successfully')</script>");
        echo("<script>window.location = 'read_product_features.php';</script>");
    }    
}

$sql = "SELECT M_SYSCODE, M_NAME FROM PRODUCT";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$products = $stmt->fetchAll();

$sql = "SELECT FEATURE_ID, FEATURE_NAME FROM FEATURES";
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
    <label for="Product">Product</label>  
    <label for="Feature">Feature</label>   
    <select name="product" required="required">
        <option disabled selected>Select a product </option>
        <?php foreach($products as $product): ?>
            <option value="<?= $product['M_SYSCODE']; ?>"><?= $product['M_NAME']; ?></option>
        <?php endforeach; ?>
    </select>
        
    <select name="feature" style="margin-left: 25px">
        <option disabled selected required="required">Select a feature </option>
        <?php foreach($features as $feature): ?>
            <option value="<?= $feature['FEATURE_ID']; ?>"><?= $feature['FEATURE_NAME']; ?></option>
        <?php endforeach; ?>
    </select>

    <label for="MINVAL">Minimum Value</label>
    <label for="MAXVAL">Maximum Value</label>
    <input type="number" name="minval" placeholder="example value" min="0" required="required">
    <input type="number" name="maxval" placeholder="example value" min="0" required="required">      



    <input type="submit" name="submit" value="Link">
</form>
</div>
