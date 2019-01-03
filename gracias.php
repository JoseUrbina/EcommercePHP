<!-- Adding file conexion.php -->
<?php require_once "includes/conexion.php"?>
<!-- Adding file header.php -->
<?php require_once "includes/header.php";?>

<?php
	if(isset($_GET["tx"]))
	{
		// Get values which was sent by paypal
		$amount = $_GET['amt'];
		$currency = $_GET['cc'];
		$transaction = $_GET['tx'];
		$status = $_GET['st'];

	}else{
		// If it doesn't exist the variable tx, return tu index.php
		header("location:index.php");
	}
?>

<div class="container">
	<h1 class="text-center">Gracias</h1>
</div>

<!-- Adding footer.php -->
<?php require_once "includes/footer.php"?>