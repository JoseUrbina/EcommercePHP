<?php

class Categorias extends Conectar
{
	private $db;
	private $categorias;

	function __construct()
	{
		try
		{
			$this->db = parent::conexion();
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

	// Insertar nueva categoria
	public function insertar_categoria()
	{	
		// Validate if the field is empty
		if(empty($_POST["cat_titulo"]))
		{
			header("Location:index.php?categorias&m=1");
		}
		else
		{
			// Validate if it exists that category in DB
			
			try
			{
				$cat_titulo = htmlentities(addslashes($_POST["cat_titulo"]));

				$sql_search = "SELECT cat_titulo FROM categorias 
							   WHERE cat_titulo = :cat_titulo";

				$resultado_search = $this->db->prepare($sql_search);
				$resultado_search->bindValue(":cat_titulo", $cat_titulo);

				// Failed query
				if(!$resultado_search->execute())
				{
					header("Location: index.php?categorias&m=2");
				}
				else
				{	
					// Exist category ?
					if($resultado_search->rowCount() > 0)
					{
						header("Location:index.php?categorias&m=3");
					}
					else
					{
						// Insert category
						
						$sql_insert = "INSERT INTO categorias VALUES(null, :cat_titulo)";

						$result_insert = $this->db->prepare($sql_insert);
						$result_insert->bindValue(":cat_titulo", $cat_titulo);

						if(!$result_insert->execute())
						{
							header("Location:index.php?categorias&m=2");
						}
						else
						{	
							// If category has inserted to DB
							if($result_insert->rowCount() > 0)
							{
								header("Location:index.php?categorias&m=4");
							}
							else
							{
								// if it has not inserted anything
								header("Location:index.php?categorias&m=5");
							}
						}
					}
				}
			}
			catch(Exception $e)
			{
				throw $e;
			}
		}
	}
}

?>