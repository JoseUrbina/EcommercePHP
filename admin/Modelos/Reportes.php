<?php

	class Reportes extends Conectar
	{
		private $db;
		private $reportes;

		public function __construct()
		{
			try
			{
				$this->db = parent::conexion();
				$this->reportes = array();
			}
			catch(Exception $e)
			{
				throw $e;
			}
		}

		// Function that gets all reportes
		public function get_reportes()
		{
			try
			{
				$sql = "SELECT * FROM reportes";

				$result = $this->db->prepare($sql);

				if(!$result->execute())
				{
					echo "<h1 class='text-danger bg-danger'>" . 
						 "Failed query!</h1>";
				}
				else
				{
					while($reg = $result->fetch(PDO::FETCH_ASSOC))
					{
						$this->reportes[] = $reg;		
					}

					return $this->reportes;
				}
			}
			catch(Exception $e)
			{
				die("Error: {$e->getMessage()}");
			}
		}
	}

?>