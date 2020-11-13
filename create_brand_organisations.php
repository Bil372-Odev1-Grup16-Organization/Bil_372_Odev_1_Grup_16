<?php

$pdo = new PDO('mysql:host=localhost;dbname=TEST', 'root', 'admin123');
$sql = "SELECT ORGANISATION.ORG_ID, PRODUCT_BRANDS.BRAND_BARCODE FROM ORGANISATION, PRODUCT_BRANDS";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$users = $stmt->fetchAll();
?>


<form action="submit_brand_organisations.php" method="post">
    <select name="organisations">
        <?php foreach($users as $user): ?>
            <option value="<?= $user['ORG_ID']; ?>"><?= $user['ORG_ID']; ?></option>

        <?php endforeach; ?>
    </select>

    <select name="product_brands">
        <?php foreach($users as $user): ?>
            <option value="<?= $user['BRAND_BARCODE']; ?>"><?= $user['BRAND_BARCODE']; ?></option>

        <?php endforeach; ?>
    </select>
    <input type="submit" name="submit">
</form>
