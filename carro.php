<!-- Adding file conexion.php-->
<?php require_once "includes/conexion.php";?>
<!-- File header.php => It is important cause contains the session_start() -->
<?php require_once "includes/header.php";?>

<?php
	// if it exists the variable GET
	if(isset($_GET['agregar']))
	{
		// We add a product : quantity is the amount of times that add the product
		$_SESSION["producto_" . $_GET['agregar']] += 1;
		header("Location: index.php");
	}

?>