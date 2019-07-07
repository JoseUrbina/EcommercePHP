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
				echo "<h2 style='color:red;'>" . 
					 "Falla en la consulta</h2>";
			}
			else
			{
				if($resultado->rowCount() > 0)
				{
					while($reg = $resultado->fetch(PDO::FETCH_ASSOC))
					{
						// ** if amount is different to amount 
						// of session variable : add**
						if($reg['producto_cantidad'] != $_SESSION["producto_" . $_GET['agregar']] && 
							$reg["producto_cantidad"] != 0){
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
					echo "<h2 style='color:red;'>Ningún registro ha sido encontrado</h2>";
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

	// Conditional : Remove amount of product -1
	// $_GET['remover'] : Contain the id_product
	if(isset($_GET["remover"]))
	{
		$_SESSION["producto_" . $_GET['remover']]--;

		// If product is less than 1 or not it the same
		// redirect to checkout.php
		if($_SESSION["producto_" . $_GET['remover']] < 1)
		{
			/*El unset es para que ponga en 0 en el orden total y en la cantidad de items total
		 	  si se eliminan todos los productos a comprar en el checkout.php
			*/
		
			unset($_SESSION['item_total']);
			unset($_SESSION['item_cantidad']);

			header('Location: checkout.php');
		}
		else
		{
			header('Location: checkout.php');
		}
	}

	// Delete complete a product from checkout.php : assign 0
	// $_GET['eliminar'] : Contain the id_product
	if(isset($_GET['eliminar']))
	{
		/*El unset es para que ponga en 0 en el orden total y en la cantidad de items total
		  si se eliminan todos los productos a comprar en el checkout.php
		*/

		unset($_SESSION['item_total']);
		unset($_SESSION['item_cantidad']);

		$_SESSION["producto_" . $_GET['eliminar']] = "0";

		header('Location: checkout.php');
	}

?>