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

		/* INsertar el registro de pedidos*/

		try
		{
			$conectar = Conectar::conexion();

			$sql = "INSERT INTO pedidos(pedido_amount, pedido_transaction, pedido_status, pedido_currency) VALUES(:amount, :transaction, :status, :currency);";

			$resultado = $conectar->prepare($sql);

			$resultado->bindValue(":amount", $amount);
			$resultado->bindValue(":transaction", $transaction);
			$resultado->bindValue(":status", $status);
			$resultado->bindValue(":currency", $currency);

			if($resultado->execute())
			{
				echo "<h1 class='text-center text-success'>It has done a new pedido record</h1>";
			}
			else
			{
				echo "<h1 class='text-danger text-center'>Failed query<h1>";
			}
		}
		catch(Exception $e)
		{
			die("Error: {$e->getMessage()}");
		}
		finally{
			$conectar = null;
		}

	}else{
		// If it doesn't exist the variable tx, return tu index.php
		header("location:index.php");
	}

	// Destruir la session para volver checkout a 0
	session_destroy();
?>

<div class="container">
	<h1 class="text-center">Gracias</h1>
</div>

<!-- Adding footer.php -->
<?php require_once "includes/footer.php"?>