<?php

$pdo = new PDO('mysql:host=localhost;dbname=TEST', 'root', '');
$sql = "SELECT PRODUCT.M_SYSCODE, FEATURES.FEATURE_ID FROM PRODUCT, FEATURES";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$users = $stmt->fetchAll();
?>


<form action="submit.php" method="post">
    <select name="first">
        <?php foreach($users as $user): ?>
            <option value="<?= $user['M_SYSCODE']; ?>"><?= $user['M_SYSCODE']; ?></option>

        <?php endforeach; ?>
    </select>

    <select name="second">
        <?php foreach($users as $user): ?>
            <option value="<?= $user['FEATURE_ID']; ?>"><?= $user['FEATURE_ID']; ?></option>

        <?php endforeach; ?>
    </select>
    <input type="submit" name="submit">
</form>
