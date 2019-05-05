<?php
	class Productos extends Conectar
	{
		private $db;
		private $productos;
		private $producto_por_id;

		public function __construct()
		{
			try
			{
				$this->db = Conectar::conexion();
				$this->productos = array();
				$this->producto_por_id = array();
			}
			catch(Exception $e)
			{
				die("Error: {$e->getMessage()}");
			}
		}

		// FUnction that gets all products
		public function get_productos()
		{
			try
			{
				$sql = "SELECT * FROM productos";

				$result = $this->db->prepare($sql);

				if(!$result->execute())
				{
				   echo "<h1 class='text-danger bg-danger'>Failed query!</h1>";
				}
				else
				{
					while($reg = $result->fetch(PDO::FETCH_ASSOC))
					{
						$this->productos[] = $reg;
					}

					return $this->productos;
				}
			}
			catch(Exception $e)
			{
				die("Error: {$e->getMessage()}");
			}
		}

		// Function that allows us to insert a new product
		public function insertar_producto()
		{
			// print_r($_POST); exit();

			// Validate if the fields are empty
			 
			if(empty($_POST["producto_titulo"]) or
			   empty($_POST["producto_id_categoria"]) or 
			   empty($_POST["producto_precio"]) or 
			   empty($_POST["producto_cantidad"]) or 
			   empty($_POST["producto_descripcion"]) or 
			   empty($_POST["descripcion_corta"]) or
			   empty($_FILES["producto_imagen"]))
			{
				header("Location:index.php?add_producto&m=1"); exit();
			}

			/*
			   Se declaran variables para almacenar los valores que se envian desde el formulario
			*/
		
			$producto_titulo = htmlentities(addslashes($_POST["producto_titulo"]));
			$producto_id_categoria = $_POST["producto_id_categoria"];
			$producto_precio = $_POST["producto_precio"];
			$producto_cantidad = $_POST["producto_cantidad"];
			$producto_descrip = htmlentities(addslashes($_POST["producto_descripcion"]));
			$descripcion_corta = htmlentities(addslashes($_POST["descripcion_corta"]));

			$producto_imagen = $_FILES["producto_imagen"]["name"];
			$producto_imagen_tmp = $_FILES["producto_imagen"]["tmp_name"];

			move_uploaded_file($producto_imagen_tmp, "../uploads/$producto_imagen");

			try
			{
				$sql = "INSERT INTO productos 
						VALUES(null, :producto_titulo, :producto_id_categoria, 
							   :producto_precio, :producto_cantidad, 
							   :producto_descripcion, :descripcion_corta, 
							   :producto_imagen)";

				$resultado = $this->db->prepare($sql);

				$resultado->bindValue(":producto_titulo", $producto_titulo);
				$resultado->bindValue(":producto_id_categoria", 
									   $producto_id_categoria);
				$resultado->bindValue(":producto_precio",$producto_precio);
				$resultado->bindValue(":producto_cantidad",$producto_cantidad);
				$resultado->bindValue(":producto_descripcion",
									  $producto_descrip);
				$resultado->bindValue(":descripcion_corta", 
									   $descripcion_corta);
				$resultado->bindValue(":producto_imagen", $producto_imagen);

				if(!$resultado->execute())
				{
					header("Location:index.php?add_producto&m=2");
				}
				else
				{
					// Insert record successfully
					if($resultado->rowCount() > 0)
					{
						header("Location:index.php?add_producto&m=3");
					}
					else
					{
						// It does not insert the record
						header("Location:index.php?add_producto&m=4");
					}
				}
			}
			catch(Exception $e)
			{
				throw $e;
			}
		}

		// Functio that allows us to get product datas by id
		public function get_producto_por_id($id_producto)
		{
			try
			{
				$sql = "SELECT * FROM productos 
						WHERE id_producto = :id_producto";

				$result = $this->db->prepare($sql);

				$result->bindValue(":id_producto", $id_producto);

				if(!$result->execute())
				{
					echo "<h1 style='color:red;'>Failed query!</h1>";
				}
				else
				{

					if($result->rowCount() > 0)
					{
						while($row = $result->fetch(PDO::FETCH_ASSOC))
						{
							$this->producto_por_id[] = $row;
						}

						return $this->producto_por_id;
					}					
				}
			}
			catch(Exception $e)
			{
				die("Error: {$e->getMessage()}");
			}
		}

		// Function that deletes a product by id_product
		public function eliminar_producto($id_producto)
		{
			try
			{
				$sql_search = "SELECT * FROM productos 
							   WHERE id_producto = :id_producto";

				$result_search = $this->db->prepare($sql_search);
				$result_search->bindValue(":id_producto", $id_producto);

				// ift it does not exist the product
				if(!$result_search->execute())
				{
					header("Location:index.php?productos&m=1");
				}
				else
				{
					// if we find the product by id_product
					if($result_search->rowCount() > 0)
					{
						$sql_delete = "DELETE FROM productos 
									   WHERE id_producto = :id_producto";

						$result_delete = $this->db->prepare($sql_delete);
						$result_delete->bindValue(":id_producto", $id_producto);

						// Error query: Delete productos
						if(!$result_delete->execute())
						{
							header("Location:index.php?productos&m=1");
						}
						else
						{
							// if we delete the product successfully
							if($result_delete->rowCount() > 0)
							{
								header("Location:index.php?productos&m=2");
							}							
						}
					}
					else
					{
						// if it does not exist the product, return m = 3
						header("Location:index.php?productos&m=3");
					}
				}
			}
			catch(Exception $e)
			{
				die("Error: {$e->getMessage()}");
			}
		}

		/* Edit product */
		public function editar_producto()
		{
			// Validate if the fields are empty
			 
			if(empty($_POST["producto_titulo"]) or
			   empty($_POST["producto_id_categoria"]) or 
			   empty($_POST["producto_precio"]) or 
			   empty($_POST["producto_cantidad"]) or 
			   empty($_POST["producto_descripcion"]) or 
			   empty($_POST["descripcion_corta"]))
			{
				header("Location:index.php?edit_producto&editar=" . $_GET["editar"] . 
					   "&m=1"); exit();
			}

			/*
			   Se declaran variables para almacenar los valores que se envian desde el formulario
			*/

			$id_producto = (int)$_GET["editar"];
			$producto_titulo = htmlentities(addslashes($_POST["producto_titulo"]));
			$producto_id_categoria = $_POST["producto_id_categoria"];
			$producto_precio = $_POST["producto_precio"];
			$producto_cantidad = $_POST["producto_cantidad"];
			$producto_descrip = htmlentities(addslashes($_POST["producto_descripcion"]));
			$descripcion_corta = htmlentities(addslashes($_POST["descripcion_corta"]));

			try
			{
				$sql = "UPDATE productos SET 
						producto_titulo = :producto_titulo,
						producto_id_categoria = :producto_id_categoria,
						producto_precio = :producto_precio,
						producto_cantidad = :producto_cantidad,
						producto_descripcion = :producto_descripcion,
						descripcion_corta = :descripcion_corta, 
						producto_imagen = :producto_imagen
						WHERE id_producto = :id_producto";

				// SI el campo de imagen es vació, tomar el valor
				// de la BD almacenado en el input hidden archivo
				
				if(empty($_FILES["producto_imagen"]["name"]))
				{
					$producto_imagen = $_POST["archivo"];
				}
				else
				{
					// Si el campo archivo esta lleno realizar las sig. operaciones
					$producto_imagen = $_FILES["producto_imagen"]["name"];
					$producto_imagen_tmp = $_FILES["producto_imagen"]["tmp_name"];

					move_uploaded_file($producto_imagen_tmp, 
						               "../uploads/$producto_imagen");
				}

				$result = $this->db->prepare($sql);

				$result->bindValue(":producto_titulo", $producto_titulo);
				$result->bindValue(":producto_id_categoria", 
									$producto_id_categoria);
				$result->bindValue(":producto_precio", $producto_precio);
				$result->bindValue(":producto_cantidad", $producto_cantidad);
				$result->bindValue(":producto_descripcion", $producto_descrip);
				$result->bindValue(":descripcion_corta", $descripcion_corta);
				$result->bindValue(":producto_imagen", $producto_imagen);
				$result->bindValue(":id_producto", $id_producto);

				if(!$result->execute())
				{
					header("Location:index.php?edit_producto&editar={$id_producto}&m=2");
				}
				else
				{
					// Edit record
					if($result->rowCount() > 0)
					{
						header("Location:index.php?edit_producto&editar={$id_producto}&m=3");
					}
					else 
					{
						// Record has not edited
						header("Location:index.php?edit_producto&editar={$id_producto}&m=4");
					}
				}
			}
			catch(Exception $e)
			{
				die("Error: {$e->getMessage()}");
			}
		}

		/*
			Mostrar el titulo de la categoria en la tabla productos del admin
		*/
	
		public function mostrar_categoria_titulo($producto_id_categoria)
		{
			try
			{	
				// VALIDATING IF IT EXISTS THE ID CATEGORY
				$sql = "SELECT cat_titulo FROM categorias WHERE id_categoria = :id_categoria";

				$result = $this->db->prepare($sql);
				$result->bindValue(":id_categoria", $producto_id_categoria);

				if(!$result->execute())
				{
					echo "<h1 style='color:red;'>Failed query</h1>";
				}
				else
				{
					// Exist the category
					if($result->rowCount() > 0)
					{
						while($reg = $result->fetch(PDO::FETCH_ASSOC))
						{
							echo $reg["cat_titulo"];
						}
					}
				}
			}
			catch(Exception $e)
			{
				die("Error: {$e->getMessage()}");
			}
		}
	}