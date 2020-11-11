$id<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
if (isset($_GET['MANUFACTURER_ID'])) {
    if (!empty($_POST)) {
        $id = isset($_POST['MANUFACTURER_ID']) ? $_POST['MANUFACTURER_ID'] : NULL;
        $name = isset($_POST['MANUFACTURER_NAME']) ? $_POST['MANUFACTURER_NAME'] : '';
        $address = isset($_POST['MANUFACTURER_ADDRESS']) ? $_POST['MANUFACTURER_ADDRESS'] : '';
        $city = isset($_POST['CITY']) ? $_POST['CITY'] : '';
        $country = isset($_POST['COUNTRY']) ? $_POST['COUNTRY'] : '';

        //$created = isset($_POST['created']) ? $_POST['created'] : date('Y-m-d H:i:s');
        $stmt = $pdo->prepare('UPDATE MANUFACTURERS SET MANUFACTURER_ID = ?, MANUFACTURER_NAME = ?, MANUFACTURER_ADDRESS = ?, CITY = ?, COUNTRY = ? WHERE MANUFACTURER_ID = ?');
        $stmt->execute([$id, $name, $address, $city, $country, $_GET['MANUFACTURER_ID']]);
        $msg = 'Updated Successfully!';
    }
    $stmt = $pdo->prepare('SELECT * FROM MANUFACTURERS WHERE MANUFACTURER_ID = ?');
    $stmt->execute([$_GET['MANUFACTURER_ID']]);
    $contact = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$contact) {
        exit('Manufacturer doesn\'t exist with that Manufacturer ID!');
    }
} else {
    exit('No MANUFACTURER_ID is selected!');
}
?>

<?=template_header('Read')?>

<div class="content update">
	<h2>Update Manufacturer #<?=$contact['MANUFACTURER_ID']?></h2>
    <form action="update_manufacturers.php?MANUFACTURER_ID=<?=$contact['MANUFACTURER_ID']?>" method="post">
        <label for="MANUFACTURER_NAME">MANUFACTURER_NAME</label>
        <label for="MANUFACTURER_ADDRESS">MANUFACTURER_ADDRESS</label>
        <input type="text" name="MANUFACTURER_NAME" placeholder="Example Value" value="<?=$contact['MANUFACTURER_NAME']?>" id="MANUFACTURER_NAME">
        <input type="text" name="MANUFACTURER_ADDRESS" placeholder="Example Value" value="<?=$contact['MANUFACTURER_ADDRESS']?>" id="MANUFACTURER_ADDRESS">

        <label for="CITY">CITY</label>
        <label for="COUNTRY">COUNTRY</label>
        <input type="text" name="CITY" placeholder="Example Value" value="<?=$contact['CITY']?>" id="CITY">
        <input type="text" name="COUNTRY" placeholder="Example Value" value="<?=$contact['COUNTRY']?>" id="COUNTRY">

        <input type="submit" value="Update">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>
