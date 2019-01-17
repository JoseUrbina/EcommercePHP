<?php
	class Pedidos extends Conectar{

		private $db;
		private $pedidos;

		// Setting up default values for variables
		public function __construct()
		{
			try
			{
				$this->db = Conectar::conexion();
				$this->pedidos = array();
			}
			catch(Exception $e)
			{
				die("Error: {$e->getMessage()}");
			}
		}

		// Function that get all pedidos -> Table: pedidos
		public function get_pedidos()
		{
			try
			{
				$sql = "SELECT * FROM pedidos";

				$result = $this->db->prepare($sql);

				if(!$result->execute())
				{
					echo "<h1 class='text-danger bg-danger'>Failed query!</h1>";
				}
				else
				{
					while($reg = $result->fetch(PDO::FETCH_ASSOC))
					{
						// We can send $reg like an array directly
						$this->pedidos[] = $reg;
					}

					return $this->pedidos;
				}
			}
			catch(Exception $e){
				die("Error: {$e->getMessage()}");
			}
		}

		// function that allows us to delete a determinated pedido by id_pedido
		public function eliminar_pedido($id_pedido)
		{
			try
			{	
				// First: Verificy if it exist this pedido by id_pedido
				$sql = "SELECT * FROM pedidos WHERE id_pedido = :id_pedido";

				$result = $this->db->prepare($sql);
				$result->bindValue(":id_pedido", $id_pedido);

				// in case: failed query
				if(!$result->execute())
				{
					header("Location:index.php?pedidos&m=1");
				}
				else
				{	
					// if it exist this pedido, do the next
					if($result->rowCount() > 0)
					{
						$sql_delete = "DELETE FROM pedidos WHERE id_pedido = :id_pedido";

						$result_delete = $this->db->prepare($sql_delete);
						$result_delete->bindValue(":id_pedido", $id_pedido);

						// in case: failed query
						if(!$result_delete->execute())
						{
							header("Location:index.php?pedidos&m=1");
						}
						else
						{	
							// Deleting successfully
							if($result_delete->rowCount() > 0)
							{
								/*Delete pedido correctly*/
								header("Location:index.php?pedidos&m=2");
							}
						}
					}else
					{
						/* Does not exist the id_pedido*/
						header("Location:index.php?pedidos&m=3");
					}
				}

			}
			catch(Exception $e)
			{
				die("Error: {$e->getMessage()}");
			}
		}
	}
?>