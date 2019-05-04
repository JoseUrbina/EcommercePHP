<?php

class Usuarios extends Conectar
{
	private $db;
	private $usuarios;

	public function __construct()
	{
		try
		{
			$this->db = parent::conexion();
			$this->usuarios = array();
		}
		catch(Exception $e)
		{
			die("Error: {$e->getMeesage()}");
		}
	}

	// Get all users from the DB
	public function get_usuarios()
	{
		try
		{
			$sql = "SELECT * FROM usuarios";

			$resultado = $this->db->prepare($sql);

			if(!$resultado->execute())
			{
				echo "<h1 class='text-danger bg-danger'>Failed query</h1>";
			}
			else
			{
				while($reg = $resultado->fetch(PDO::FETCH_ASSOC))
				{
					$this->usuarios[] = $reg;
				}

				return $this->usuarios;
			}
		}
		catch(Exception $e)
		{
			die("Error: {$e->getMessage()}");
		}
	}
}

?>