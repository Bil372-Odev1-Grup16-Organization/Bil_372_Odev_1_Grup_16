<?php
include 'functions.php';
error_reporting(0);
$conn = mysqli_connect("localhost","root","","Odev1");
if(count($_POST)>0) {
  $roll_no=$_POST[roll_no];
  $result = mysqli_query($conn,"SELECT * FROM FEATURES where FEATURE_NAME='$roll_no' ");
}
?>


<?=template_header('Read')?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Search Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css">
</head>
<body>
<div class="container">
  <form class="form-inline" method="post" action="search_feature.php">
    <input type="text" name="roll_no" class="form-control" placeholder="Search roll no..">
    <button type="submit" name="save" class="btn btn-primary">Search</button>
  </form>
</div>
</body>
</html>

<div class="content read">
<!DOCTYPE html>
<html>
<head>
  <title> Retrive data</title>
  <style>
  table, th, td {
    border: 1px solid black;
  }
</style>
</head>

<body>
  <table>
    <thead>
      <tr>
        <td>FEATURE_ID</td>
        <td>FEATURE_NAME</td>
      </tr>
    </thead>

    <tbody>
      <?php
      $i=0;
      while($row = mysqli_fetch_array($result)) {
        ?>
        <tr>
          <td><?php echo $row["FEATURE_ID"]; ?></td>
          <td><?php echo $row["FEATURE_NAME"]; ?></td>
        </tr>
        <?php
        $i++;
      }
      ?>
    </tbody>

  </table>
</body>
</html>
</div>
