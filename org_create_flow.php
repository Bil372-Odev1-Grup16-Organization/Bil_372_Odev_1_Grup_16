<?php
session_start();
if(!isset($_SESSION['NAME'])){ //session check
   header("location: login.php");
}
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';

// Check if the data is empty
if (!empty($_POST)) {
    // Insert values into columns
    $source_lot = isset($_POST['SOURCE_LOT_ID']) ? $_POST['SOURCE_LOT_ID'] : '';
    $source_org = isset($_POST['SOURCE_ORG_ID']) ? $_POST['SOURCE_ORG_ID'] : '';
    $target_lot = isset($_POST['TARGET_LOT_ID']) ? $_POST['TARGET_LOT_ID'] : '';
    $target_org = isset($_POST['TARGET_ORG_ID']) ? $_POST['TARGET_ORG_ID'] : '';
    $barcode = isset($_POST['BRAND_BARCODE']) ? $_POST['BRAND_BARCODE'] : '';
    $quantitiy = isset($_POST['QUANTITIY']) ? $_POST['QUANTITIY'] : '';
    $flowdate = isset($_POST['FLOWDATE']) ? $_POST['FLOWDATE'] : '';

    //if target is a consumer
    $sql="SELECT ORG_TYPE FROM organisations WHERE ORG_ID = \"$source_org\"";
    $type = $pdo->prepare($sql);
    $type->execute();
    $row = (int)$type->fetchColumn();

      //checking if transferring to inside
      if($source_org == $target_org){

          $sql_amount="SELECT IN_AMOUNT FROM brand_orgs WHERE ORG_ID = \"$target_org\"";
          $type2 = $pdo->prepare($sql_amount);
          $type2->execute();
          $count2 = (int)$type2->fetchColumn();
          $count2 = $count2 - $quantitiy;

          if($count2 > 0){
            $sql3="UPDATE brand_orgs SET OUT_AMOUNT = OUT_AMOUNT+$quantitiy, IN_AMOUNT = IN_AMOUNT-$quantitiy WHERE ORG_ID = \"$target_org\" AND BRAND_BARCODE = \"$barcode\"";
            $update = $pdo->prepare($sql3);
            $update->execute();

            $stmt = $pdo->prepare('INSERT INTO flow VALUES (?, ?, ?, ?, ?, ?, ?)');
            $stmt->execute([$source_lot, $source_org,$target_lot, $target_org, $barcode, $quantitiy, $flowdate]);
            // Output message
            $msg = 'Inside transferred moved successfully!';
          }else{
            $msg = 'Not enough quantitiy!';
          }


      }else{  //if transferring to outside

        if($row == 1){
          $msg = 'Buyer cannot transfer!';
        }else{

              $sql3="SELECT IN_AMOUNT FROM brand_orgs WHERE ORG_ID = \"$source_org\"";
              $type2 = $pdo->prepare($sql3);
              $type2->execute();
              $count3 = (int)$type2->fetchColumn();
              $count3 = $count3 - $quantitiy;

              if($count3 > 0){
                $sql3="UPDATE brand_orgs SET OUT_AMOUNT = OUT_AMOUNT+$quantitiy WHERE ORG_ID = \"$target_org\" AND BRAND_BARCODE = \"$barcode\"";
                $update = $pdo->prepare($sql3);
                $update->execute();

                $sql4="UPDATE brand_orgs SET OUT_AMOUNT = IN_AMOUNT + $quantitiy  WHERE ORG_ID = \"$source_org\" AND BRAND_BARCODE = \"$barcode\"";
                $update2 = $pdo->prepare($sql4);
                $update2->execute();

                $stmt = $pdo->prepare('INSERT INTO flow VALUES (?, ?, ?, ?, ?, ?, ?)');
                $stmt->execute([$source_lot, $source_org,$target_lot, $target_org, $barcode, $quantitiy, $flowdate]);
                // Output message
                $msg = 'Outside transferred moved successfully!';
              }else{
                $msg = 'Not enough quantitiy!';
              }




        }
      }




}

$sql = "SELECT LOT_ID FROM brand_orgs";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$source = $stmt->fetchAll();

$sql = "SELECT LOT_ID FROM brand_orgs";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$target = $stmt->fetchAll();


$sql = "SELECT ORG_ID, ORG_NAME FROM organisations";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$source_org = $stmt->fetchAll();

$sql = "SELECT ORG_ID, ORG_NAME FROM organisations";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$target_org = $stmt->fetchAll();

$sql = "SELECT BRAND_BARCODE, BRAND_NAME FROM product_brands";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$brand = $stmt->fetchAll();

?>

<style>
select {
  width: 400px;
  height:43px;
  border-radius: 4px;

}
</style>

<?=template_header_organisation('Create')?>

<div class="content update">
	<h2>Add Flow</h2>
    <form action="org_create_flow.php" method="post">

        <label for="SOURCE_LOT_ID">Source Lot ID</label>
        <label for="TARGET_LOT_ID">Target Lot ID</label>

        <select name="SOURCE_LOT_ID" required="required">
            <option disabled selected>Select a target lot</option>
            <?php foreach($source as $source): ?>
                <option value="<?= $source['LOT_ID']; ?>"><?= $source['LOT_ID']; ?></option>
            <?php endforeach; ?>
        </select>

        <select name="TARGET_LOT_ID" required="required" style="margin-left: 25px;">
            <option disabled selected>Select a target lot</option>
            <?php foreach($target as $target): ?>
                <option value="<?= $target['LOT_ID']; ?>"><?= $target['LOT_ID']; ?></option>
            <?php endforeach; ?>
        </select>

        <label for="SOURCE_ORG_ID">Source Organisation</label>
        <label for="TARGET_ORG_ID">Target Organisation</label>

        <select name="SOURCE_ORG_ID" required="required">
            <option disabled selected>Select a source organisation</option>
            <?php foreach($source_org as $source_org): ?>
                <option value="<?= $source_org['ORG_ID']; ?>"><?= $source_org['ORG_NAME']; ?></option>
            <?php endforeach; ?>
        </select>

        <select name="TARGET_ORG_ID" required="required" style="margin-left: 25px;">
            <option disabled selected>Select a target organisation</option>
            <?php foreach($target_org as $target_org): ?>
                <option value="<?= $target_org['ORG_ID']; ?>"><?= $target_org['ORG_NAME']; ?></option>
            <?php endforeach; ?>


        </select>

        <label for="BRAND_BARCODE">Brand Name</label>
        <label for="QUANTITIY">Quantity</label>


        <select name="BRAND_BARCODE" required="required">
            <option disabled selected>Select a brand </option>
            <?php foreach($brand as $brand): ?>
                <option value="<?= $brand['BRAND_BARCODE']; ?>"><?= $brand['BRAND_NAME']; ?></option>
            <?php endforeach; ?>
        </select>

        <input type="text" name="QUANTITIY" placeholder="example value" style="margin-left: 25px;"required="required" >

        <label for="FLOWDATE">Flow Date</label>
        <label></label>
        <input type="date" name="FLOWDATE" placeholder="example value" required="required" >
        <label></label>


        <input type="submit" value="Create">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>
