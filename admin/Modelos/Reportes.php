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

		// Function that deletes a record from reportes table
		public function eliminar_reporte($id_reporte)
		{
			try
			{
				$sql_search = "SELECT id_reporte FROM reportes
							   WHERE id_reporte = :id_reporte";

				$result_search = $this->db->prepare($sql_search);
				$result_search->bindValue(":id_reporte", 
										   $id_reporte);

				// if search query fails, throw error
				if(!$result_search->execute())
				{
					header("Location:index.php?reportes&m=1");
					exit();
				}
				else
				{
					// if record exists in DB
					if($result_search->rowCount() > 0)
					{
						$sql= "DELETE FROM reportes 
							   WHERE id_reporte = :id_reporte";

						$result = $this->db->prepare($sql);
						$result->bindValue(":id_reporte",
											$id_reporte);

						// if query fails, throw error
						if(!$result->execute())
						{
							header("Location:index.php?reportes" 
									. "&m=1");
						}
						else
						{
							// if record has been deleted
							if($result->rowCount() > 0)
							{
								header("Location:index.php?reportes"
									   . "&m=2");
							}
						}
					}
					else
					{
						// if record has not been found, throw error
						header("Location:index.php?reportes&m=3");
					}
				}
			}
			catch(Exception $e)
			{
				die("Error: {$e->getMessage()}");
			}
		}

		// function that gets the number of reporte records
		public function get_numero_reportes()
		{
			try
			{
				$sql = "SELECT * FROM reportes";

				$resultado = $this->db->prepare($sql);

				// failed query
				if(!$resultado->execute())
				{
					echo "<h1 class='text-danger'>Falla en la consulta</h1>";
				}
				else
				{
					// Number of records
					return $resultado->rowCount();
				}
			}
			catch(Exception $e)
			{
				die("Error: {$e->getMessage()}");
			}
		}
	}

?>