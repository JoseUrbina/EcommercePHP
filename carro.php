<!-- Adding file conexion.php-->
<?php require_once "includes/conexion.php";?>
<!-- File header.php => It is important cause contains the session_start() -->
<?php require_once "includes/header.php";?>

<?php
	// if it exists the variable GET
	if(isset($_GET['agregar']))
	{
		try
		{
			$conectar = Conectar::conexion();

			$id_producto = $_GET['agregar'];
			$sql = "SELECT * FROM productos WHERE id_producto = :id_producto";

			$resultado = $conectar->prepare($sql);
			$resultado->bindValue(":id_producto", $id_producto);

			if(!$resultado->execute())
			{
				echo "<h2 style='color:red;'>Failed query</h2>";
			}
			else
			{
				if($resultado->rowCount() > 0)
				{
					while($reg = $resultado->fetch(PDO::FETCH_ASSOC)){
						// ** if amount is different to amount of session variable : add**
						if($reg['producto_cantidad'] != $_SESSION["producto_" . $_GET['agregar']]){
						// We add a product : quantity is the amount of times that add the product
							$_SESSION["producto_" . $_GET['agregar']] += 1;
							header("Location: checkout.php");
						}
						else
						{
							// ** if amount of db and amount of session are equals **
							header("Location:checkout.php?cantidad={$reg['producto_cantidad']}&producto_titulo={$reg['producto_titulo']}");
						}
					}
				}
				else
				{
					echo "<h2 style='color:red;'>it has not found any record</h2>";
				}
			}
		}
		catch(Exception $e)
		{
			die("Error: {$e->getMessage()}");
		}
		finally{
			$conectar = null;
		}
	}

?>