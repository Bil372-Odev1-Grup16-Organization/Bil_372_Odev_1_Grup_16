<?php
session_start();
if(!isset($_SESSION['NAME'])){ //session check
   header("location: login.php");
}

include 'functions.php';


?>

<?=template_header('Home page')?>

<div class="content">
	<h2>Welcome <?php echo $_SESSION["NAME"] ?></h2>
</div>

<?=template_footer()?>
