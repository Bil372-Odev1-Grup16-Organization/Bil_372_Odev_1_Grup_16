<?php
include 'functions.php';

session_start();
 if(!isset($_SESSION['NAME'])){
	header("location: login.php");
 }
?>

<?=template_header('Home page')?>

<div class="content">
	<h2>Welcome <?php echo $_SESSION["NAME"] ?></h2>
</div>

<?=template_footer()?>
