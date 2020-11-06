<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "Odev1";
$queryfile= "queries.txt";
// Create connection
$conn = mysqli_connect($servername, $username, $password);
// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

// Create database
$sql = " CREATE DATABASE IF NOT EXISTS $database";

if (mysqli_query($conn, $sql)) {
  //echo "Database created successfully";
  $conn = mysqli_connect($servername, $username, $password, $database);
  $query = file_get_contents($queryfile); 

  if (mysqli_multi_query($conn,$query) ) {
   // echo "all tables created successfully <br/>";
  } else {
    echo "Error creating tables: " . $conn->error;
  }

} else {
  echo "Error creating database: " . mysqli_error($conn);
}

mysqli_close($conn);
?>