<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';

// Check if the data is empty
if (!empty($_POST)) {
    // Insert values into columns
    $id = isset($_POST['MANUFACTURER_ID']) ? $_POST['MANUFACTURER_ID'] : '';
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
?>

<?=template_header('Create')?>

<div class="content update">
	<h2>Add Manufacturer</h2>
    <form action="create_manufacturers.php" method="post">
        <label for="MANUFACTURER_ID">ID</label>
        <label for="MANUFACTURER_NAME">Name</label>
        <input type="text" name="MANUFACTURER_ID" placeholder="example value" id="MANUFACTURER_ID">
        <input type="text" name="M_NAME" placeholder="example value" id="MANUFACTURER_NAME">

        <label for="MANUFACTURER_ADDRESS">Address</label>
        <label for="CITY">City</label>
        <input type="text" name="MANUFACTURER_ADDRESS" placeholder="example value" id="MANUFACTURER_ADDRESS">
        <input type="text" name="CITY" placeholder="example value" id="CITY">

        <label for="COUNTRY">Country</label>
        <label></label>
        <input type="text" name="Country" placeholder="example value" id="COUNTRY">
        <label></label>

        <input type="submit" value="Create">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>
