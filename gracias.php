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

		/* try
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
	//session_destroy();

	*/
	}
?>

<?php

	try
	{
		// A way to foreach all stored SESSIONS
          foreach($_SESSION as $name => $valor){
              // Validacion para listar solo productos con una cantidad > 0
              if($valor > 0)
              {
                // Verify if session name it's a product
                if(substr($name, 0 , 9) == "producto_")
                {
                    // Variable which stores the length to use
                    // in the next substr function
                    $length = strlen($name) - 9;

                    // Getting the id_product from the session name
                    // 9: Represent the space after _
                    $id_producto = substr($name, 9, $length);

                    /***** INSERTAR PEDIDO INICIO *****/

                    $conectar = Conectar::conexion();

					$sql = "INSERT INTO pedidos(pedido_amount, pedido_transaction,
												pedido_status, pedido_currency) 
							VALUES(:amount, :transaction, :status, :currency);";

					$resultado = $conectar->prepare($sql);

					$resultado->bindValue(":amount", $amount);
					$resultado->bindValue(":transaction", $transaction);
					$resultado->bindValue(":status", $status);
					$resultado->bindValue(":currency", $currency);

					if($resultado->execute())
					{
						/* echo "<h1 class='text-center text-success'>It has done a new pedido record</h1>"; */

						$ultimo_id_pedido = $conectar->lastInsertId();
					}
					else
					{
						echo "<h1 class='text-danger text-center'>Failed query<h1>";
					}

                    /***** INSERTAR PEDIDO FIN *****/

                    // SELECCIONA LOS PRODUCTOS EN CHECKOUT.PHP

                    $sql = "SELECT * FROM productos WHERE id_producto = :id_producto";

                    $resultado = $conectar->prepare($sql);
                    $resultado->bindValue(":id_producto", $id_producto);

                    if($resultado->execute())
                    {
                        while($reg = $resultado->fetch(PDO::FETCH_ASSOC)){
                            $producto_titulo = $reg["producto_titulo"];
                            $producto_precio = $reg["producto_precio"]; 
                            $producto_cantidad = $reg["producto_cantidad"];

                        /***** INSERTAR REPORTE INICIO *****/

                        $insertar_reporte = "INSERT INTO reportes(id_producto, id_pedido, producto_precio, producto_titulo, producto_cantidad) 
                        	VALUES(:id_producto, :id_pedido, :p_precio, :p_titulo, :p_cantidad);";

                       	$resultado = $conectar->prepare($insertar_reporte);

                       	$resultado->bindValue(":id_producto", $id_producto);
                       	$resultado->bindValue(":id_pedido", $ultimo_id_pedido);
                       	$resultado->bindValue(":p_precio", $producto_precio);
                       	$resultado->bindValue(":p_titulo", $producto_titulo);
                       	// Valor : cantidad a comprar de un determinado producto
                       	$resultado->bindValue(":p_cantidad", $valor);

                       	if(!$resultado->execute())
                       	{
                       		echo "<h1 class='text-danger'>Failed query</h1>";
                       	}

                        /***** INSERTAR REPORTE FIN *****/

                        } // Cierre while

                    } // Cierre IF Conditional
                    else
                    {
                        echo "<h1 style='color:red;'>Failed query</h1>";
                    }
                } // Cierre de la validacion substr
            } // Cierre validacion del valor > 0
        } // Cierre del foreach

        /*
        	Una vez que se inserten los pedido y reportes se destruye la session para evitar que se hagan nuevos registros al refrescar la pagina gracias.php con los parametros
        */
        session_destroy();
	}
	catch(Exception $e)
	{
		die("Error: {$e->getMessage()}");
	}
	finally{
		$conectar = null;
	}

?>

<div class="container">
	<h1 class="text-center">Gracias</h1>
</div>

<!-- Adding footer.php -->
<?php require_once "includes/footer.php"?>