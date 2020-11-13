
<?php

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "Odev1";

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    if (isset($_POST['submit'])) {

        $dropdown1 = $_POST['organisations'];
        $dropdown2 = $_POST['product_brands'];

        $sql = "INSERT INTO BRAND_ORGS(LOT_ID, ORG_ID, BRAND_BARCODE, QUANTITY, UNIT, EXPIRY_DATE, BASEPRICE, 'IN' , OUT )
        VALUES ('1', '".$dropdown1."','".$dropdown1."', '1', '2', '1', '1', '1')";

        if ($conn->query($sql) === TRUE) {
            echo "Brand ve Organizasyon link edildi ";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    $conn->close();
?>
