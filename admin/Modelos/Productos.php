<?php
	class Productos extends Conectar
	{
		private $db;
		private $productos;

		public function __construct()
		{
			try
			{
				$this->db = Conectar::conexion();
				$this->productos = array();
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

		// Function that deletes a product by id_product
		public function eliminar_producto($id_producto)
		{
			try
			{
				$sql_search = "SELECT * FROM productos WHERE id_producto = :id_producto";

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
						$sql_delete = "DELETE FROM productos WHERE id_producto = :id_producto";

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