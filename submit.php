
<?php

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "TEST";

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    if (isset($_POST['submit'])) {

        $dropdown1 = $_POST['first'];
        $dropdown2 = $_POST['second'];

        $sql = "INSERT INTO PRODUCT_FEATURES (M_SYSCODE, FEATURE_ID, MINVAL, MAXVAL)
        VALUES ('".$dropdown1."','".$dropdown1."', '1', '2')";

        if ($conn->query($sql) === TRUE) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    $conn->close();
?>
