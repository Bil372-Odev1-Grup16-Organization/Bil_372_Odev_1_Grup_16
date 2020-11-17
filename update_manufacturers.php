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

if (isset($_GET['MANUFACTURER_ID'])) {
    if (!empty($_POST)) {
        $name = isset($_POST['MANUFACTURER_NAME']) ? $_POST['MANUFACTURER_NAME'] : '';
        $address = isset($_POST['MANUFACTURER_ADDRESS']) ? $_POST['MANUFACTURER_ADDRESS'] : '';
        $city = isset($_POST['CITY']) ? $_POST['CITY'] : '';
        $country = isset($_POST['COUNTRY']) ? $_POST['COUNTRY'] : '';

        $stmt = $pdo->prepare('UPDATE MANUFACTURERS SET MANUFACTURER_NAME = ?, MANUFACTURER_ADDRESS = ?, CITY = ?, COUNTRY = ? WHERE MANUFACTURER_ID = ?');
        $stmt->execute([$name, $address, $city, $country, $_GET['MANUFACTURER_ID']]);
        $msg = 'Manufacturer updated successfully!';
    }
    $stmt = $pdo->prepare('SELECT * FROM MANUFACTURERS WHERE MANUFACTURER_ID = ?');
    $stmt->execute([$_GET['MANUFACTURER_ID']]);
    $contact = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$contact) {
        exit('Manufacturer doesn\'t exist with that Manufacturer ID!');
    }
} else {
    exit('No Manufacturer is selected!');
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

<?=template_header('Update')?>

<div class="content update">
	<h2>Update Manufacturer #<?=$contact['MANUFACTURER_ID']?></h2>
    <form action="update_manufacturers.php?MANUFACTURER_ID=<?=$contact['MANUFACTURER_ID']?>" method="post">
        <label for="MANUFACTURER_NAME">Manufacturer Name</label>
        <label for="MANUFACTURER_ADDRESS">Manufacturer Address</label>
        <input type="text" name="MANUFACTURER_NAME" placeholder="Example Value" value="<?=$contact['MANUFACTURER_NAME']?>" required="required" id="MANUFACTURER_NAME">
        <input type="text" name="MANUFACTURER_ADDRESS" placeholder="Example Value" value="<?=$contact['MANUFACTURER_ADDRESS']?>" required="required" id="MANUFACTURER_ADDRESS">

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

        <input type="submit" value="Update">
    </form>
    <?php if ($msg): ?>
    <p><?php
    echo "<script>alert('$msg')</script>";
    echo "<script>window.location = 'read_manufacturers.php';</script>";
    ?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>
