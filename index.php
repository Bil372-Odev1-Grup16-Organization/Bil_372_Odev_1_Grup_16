<?php
include 'functions.php';
// Your PHP code here.
session_start();
// Home Page template below.
?>

<?=template_header('Home page')?>

<div class="content">
	<h2>Welcome <?php echo $_SESSION["NAME"] ?></h2>
</div>

<?=template_footer()?>
