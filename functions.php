<?php
function pdo_connect_mysql() {
    $DATABASE_HOST = 'localhost';
    $DATABASE_USER = 'root';
    $DATABASE_PASS = '';
    $DATABASE_NAME = 'odev1';
    try {
    	return new PDO('mysql:host=' . $DATABASE_HOST . ';dbname=' . $DATABASE_NAME . ';charset=utf8', $DATABASE_USER, $DATABASE_PASS);
    } catch (PDOException $exception) {
    	// If there is an error with the connection, stop the script and display the error.
    	exit('Failed to connect to database!');
    }
}
function template_header($title) {
echo <<<EOT
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>$title</title>
		<link href="style.css" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
        <title>Bootstrap Example</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
	</head>
    <body>
    <script>
    $(document).ready(function(){
        $("#myInput").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#myTable tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });
    </script>
    <nav class="navtop">
      <div>
        <a href="index.php"><i class="fas fa-home"></i>Home</a>
        <a href="read_product.php"><i class="fas fa-hammer"></i>Products</a>
        <a href="read_feature.php"><i class="fas fa-toolbox"></i>Features</a>
        <a href="read_product_features.php"><i class="fas fa-toolbox"></i>Product Features</a>
        <a href="read_manufacturers.php"><i class="fas fa-industry"></i>Manufacturers</a>
        <a href="read_product_brands.php"><i class="fas fa-copyright"></i>Product Brands</a>
        <a href="read_organisations.php"><i class="fas fa-sitemap"></i>Organisations</a>
        <a href="read_brand_organisations.php"><i class="fas fa-school"></i>Brand Organisations</a>
        <a href="read_flow.php"><i class="fas fa-exchange-alt"></i>Flow</a>
        <a href="read_alternativebrands.php"><i class="fas fa-copyright"></i>Alternative Brands</a>
        <a href="read_organisations.php"><i class="fas fa-sitemap"></i>Organisations</a>
        
      </div>
    </nav>
EOT;
}
function template_footer() {
echo <<<EOT
    </body>
</html>
EOT;
}
?>
