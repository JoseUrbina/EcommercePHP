<?php

class Categorias extends Conectar
{
	private $db;
	private $categorias;

	function __construct()
	{
		try
		{
			$this->db = Conectar::conexion();
			$this->categorias = array();
		}
		catch(Exception $e)
		{
			die("Error: {$e->getMessage()}");
		}
	}

	// Function that allows us to get all categories
	public function get_categorias()
	{
		try
		{
			$sql = "SELECT * FROM categorias";

			$resultado = $this->db->prepare($sql);

			if(!$resultado->execute())
			{
				echo "<h1 class='text-danger bd-danger'>Failed query!</h1>";
			}
			else
			{
				while($reg = $resultado->fetch(PDO::FETCH_ASSOC))
				{
					$this->categorias[] = $reg;
				}

				return $this->categorias;
			}
		}
		catch(Exception $e)
		{
			throw $e;
		}
	}
}

?>