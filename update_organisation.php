<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
if (isset($_GET['ORG_ID'])) {
    if (!empty($_POST)) {
        $name = isset($_POST['ORG_NAME']) ? $_POST['ORG_NAME'] : '';
        $parent_org = isset($_POST['PARENT_ORG']) ? $_POST['PARENT_ORG'] : '';
        $abstract = isset($_POST['ORG_ABSTRACT']) ? $_POST['ORG_ABSTRACT'] : '';
        $address = isset($_POST['ORG_ADDRESS']) ? $_POST['ORG_ADDRESS'] : '';
        $city = isset($_POST['ORG_CITY']) ? $_POST['ORG_CITY'] : '';
        $district = isset($_POST['ORG_DISTRICT']) ? $_POST['ORG_DISTRICT'] : '';
        $type = isset($_POST['ORG_TYPE']) ? $_POST['ORG_TYPE'] : '';

        $stmt = $pdo->prepare(
            'UPDATE ORGANISATIONS SET ORG_NAME = ?, PARENT_ORG = ?, ORG_ABSTRACT = ?, ORG_ADDRESS = ?, ORG_CITY = ?, ORG_DISTRICT = ?, ORG_TYPE = ? WHERE ORG_ID = ?'
        );
        $stmt->execute([
            $name,
            $parent_org,
            $abstract,
            $address,
            $city,
            $district,
            $type,
            $_GET['ORG_ID'],
        ]);
        $msg = 'Updated Successfully!';
        header("location: read_organisations.php");
    }
    $stmt = $pdo->prepare('SELECT * FROM ORGANISATIONS WHERE ORG_ID = ?');
    $stmt->execute([$_GET['ORG_ID']]);
    $contact = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$contact) {
        exit('Product doesn\'t exist with that ORG_ID!');
    }
} else {
    exit('No ORG_ID is selected!');
}
?>

<?= template_header('Update') ?>

<div class="content update">
	<h2>Update Organisation #<?= $contact['ORG_ID'] ?></h2>
    <form action="update_organisation.php?ORG_ID=<?= $contact['ORG_ID'] ?>" method="post">
        <label for="ORG_NAME">ORG_NAME</label>
        <label for="PARENT_ORG">PARENT_ORG</label>
        <input type="text" name="ORG_NAME" placeholder="Value" value="<?= $contact['ORG_NAME'] ?>" id="ORG_NAME">
        <input type="text" name="PARENT_ORG" placeholder="Value" value="<?= $contact['PARENT_ORG'] ?>" id="PARENT_ORG">

        <label for="ORG_ABSTRACT">ORG_ABSTRACT</label>
        <label for="ORG_ADDRESS">ORG_ADDRESS</label>
        <input type="text" name="ORG_ABSTRACT" placeholder="Value" value="<?= $contact['ORG_ABSTRACT'] ?>" id="ORG_ABSTRACT">
        <input type="text" name="ORG_ADDRESS" placeholder="Value" value="<?= $contact['ORG_ADDRESS'] ?>" id="ORG_ADDRESS">

        <label for="ORG_CITY">ORG_CITY</label>
        <label for="ORG_DISTRICT">M_CATEGORY</label>
        <input type="text" name="ORG_CITY" placeholder="Example Value" value="<?= $contact['ORG_CITY'] ?>" id="ORG_CITY">
        <input type="text" name="ORG_DISTRICT" placeholder="Example Value" value="<?= $contact['ORG_DISTRICT'] ?>" id="ORG_DISTRICT">

        <label for="ORG_TYPE">ORG_TYPE</label>
        <label></label>
        <input type="text" name="ORG_TYPE" placeholder="Example Value" value="<?= $contact['ORG_TYPE'] ?>" id="ORG_TYPE">
        <label></label>

        <input type="submit" value="Update">
    </form>
    <?php if ($msg): ?>
    <p><?= $msg ?></p>
    <?php endif; ?>
</div>

<?= template_footer()
?>
