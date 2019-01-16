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
	}
?>