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

// Check if the data is empty
if (!empty($_POST)) {
    // Insert values into columns
    $id = isset($_POST['MANUFACTURER_ID']) && !empty($_POST['MANUFACTURER_ID']) && $_POST['MANUFACTURER_ID'] != 'auto' ? $_POST['MANUFACTURER_ID'] : NULL;
    $name = isset($_POST['MANUFACTURER_NAME']) ? $_POST['MANUFACTURER_NAME'] : '';
    $address = isset($_POST['MANUFACTURER_ADDRESS']) ? $_POST['MANUFACTURER_ADDRESS'] : '';
    $city = isset($_POST['CITY']) ? $_POST['CITY'] : '';
    $country = isset($_POST['COUNTRY']) ? $_POST['COUNTRY'] : '';
    // Insert new record into the contacts table
    $stmt = $pdo->prepare('INSERT INTO MANUFACTURERS VALUES (?, ?, ?, ?, ?)');
    $stmt->execute([$id, $name, $address, $city, $country]);
    // Output message
    $msg = 'Created Successfully!';
}

$sql = "SELECT CITY_ID, CITY_NAME FROM COUNTRY_CITY";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$cities = $stmt->fetchAll();

$sql = "SELECT COUNTRY_CODE, COUNTRY_NAME FROM COUNTRY";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$country = $stmt->fetchAll();

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
	<h2>Add Manufacturer</h2>
    <form action="create_manufacturers.php" method="post">
        <label for="MANUFACTURER_NAME">Manufacturer Name</label>
        <label for="MANUFACTURER_ADDRESS">Manufacturer Address</label>
        <input type="text" name="MANUFACTURER_NAME" placeholder="example value" id="MANUFACTURER_NAME">
        <input type="text" name="M_NAME" placeholder="example value" id="MANUFACTURER_ADDRESS">

        <label for="CITY">City</label>
        <label for="COUNTRY">Country</label>

        <select name="CITY" required="required">
            <option disabled selected>Select a city </option>
            <?php foreach($cities as $cities): ?>
                <option value="<?= $cities['CITY_ID']; ?>"><?= $cities['CITY_NAME']; ?></option>
            <?php endforeach; ?>
        </select>

        <select name="COUNTRY" required="required" style="margin-left: 25px">
            <option disabled selected>Select a country </option>
            <?php foreach($country as $country): ?>
                <option value="<?= $country['COUNTRY_CODE']; ?>"><?= $country['COUNTRY_NAME']; ?></option>
            <?php endforeach; ?>
        </select>

        <input type="submit" value="Create">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>
