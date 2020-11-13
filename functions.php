<?php
function pdo_connect_mysql() {
    $DATABASE_HOST = 'localhost';
    $DATABASE_USER = 'root';
    $DATABASE_PASS = '';
    $DATABASE_NAME = 'ODEV1';
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
	</head>
	<body>
    <nav class="navtop">
    	<div>
        <h1>Panel</h1>
          <div>
            <a href="index.php"><i class="fas fa-home"></i>Home</a>
            <a href="read_product.php"><i class="fas fa-hammer"></i>Products</a>
            <a href="read_feature.php"><i class="fas fa-toolbox"></i>Features</a>
            <a href="read_manufacturers.php"><i class="fas fa-industry"></i>Manufacturers</a>
            <a href="read_product_brands.php"><i class="fas fa-copyright"></i>Product Brands</a>
	    <a href="read_product_features.php"><i class="fas fa-toolbox"></i>Product Features</a>
	    <a href="read_brand_organisations.php"><i class="fas fa-school"></i>Brand Organisations</a>
            <a href="read_organisations.php"><i class="fas fa-sitemap"></i>Organisations</a>
          </div>
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
