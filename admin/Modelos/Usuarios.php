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

	// Insert user
	public function insertar_usuario()
	{
		// Declare variables that are received from form
		
		$nombre = htmlentities(addslashes($_POST["nombre"]));
		$apellido = htmlentities(addslashes($_POST["apellido"]));
		$usuario = htmlentities(addslashes($_POST["usuario"]));
		$correo = htmlentities(addslashes($_POST["correo"]));
		$password = $_POST["password"];

		// validate that fields are not empty
		if(empty($nombre) or empty($apellido) or empty($usuario) 
		   or empty($correo) or empty($password))
		{
			header("Location:index.php?add_usuario&m=1"); exit();
		
		
		/*
			El formato del password debe tener al menos una letra mayúscula, una letra minúscula, un caracter extraño y un número, por ejemplo en este proyecto esta $Qw/*12345678$ no importa el orden lo importante es que se cumple el formato.
		*/
	
		/*
			Si no se cumple esta expresion regular con un formato del password de que al menos tenga una letra mayúscula, una letra minúscula, un caracter extraño y un número y que sean minimo 12 caracteres.
		 */
		
		}
		else if(!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&])([A-Za-z\d$@$!%*?&]|[^ ]){12,15}$/",$password))
		{
			header("Location:index.php?add_usuario&m=2");
		}
		else
		{
			/*
				Entonces si los campos no estan vacios y si se cumple el formato del pasword entonces validamos si existe el correo en la BD
			 */
			
			/*
				Validamos que el usuario y correo no existen en la DB
			*/
		
			$sql_search = "SELECT * FROM usuarios 
						   WHERE usuario = :usuario OR correo = :correo";

			$resultado_search = $this->db->prepare($sql_search);
			$resultado_search->bindValue(":usuario", $usuario);
			$resultado_search->bindValue(":correo", $correo);

			// failed query
			if(!$resultado_search->execute())
			{
				header("Location:index.php?add_usuario&m=3");
			}
			else
			{
				/*if usuario y/o correo exist in the BD*/
				if($resultado_search->rowCount() > 0)
				{
					while($reg = $resultado_search->fetch(PDO::FETCH_ASSOC))
					{
						$usuario_bd = $reg["usuario"];
						$correo_bd = $reg["correo"];
					}

					// Usuario exists in the database
					if($usuario_bd == $usuario)
					{
						header("Location:index.php?add_usuario&m=4");
					}
					else if($correo_bd == $correo)
					{
						// Correo exists in the database
						header("Location:index.php?add_usuario&m=5");
					}
				
				/*
					Entonces si no existe el usuario y correo en la BD insertamos el nuevo registro de usuario
				 */
				}else
				{
					// Insertar el registro
					
					// Encriptamos el password
					$pass_encriptado = password_hash($password,
													 PASSWORD_DEFAULT);

					$sql_insert = "INSERT INTO usuarios 
								   VALUES(null,:nombre,:apellido
										  ,:usuario,:correo
										  ,:password, '0')";

					$result_insert = $this->db->prepare($sql_insert);
					$result_insert->bindValue(":nombre", $nombre);
					$result_insert->bindValue(":apellido", $apellido);
					$result_insert->bindValue(":usuario", $usuario);
					$result_insert->bindValue(":correo", $correo);
					$result_insert->bindValue(":password", $pass_encriptado);

					// failed query
					if(!$result_insert->execute())
					{
						header("Location:index.php?add_usuario&m=3");
					}
					else
					{
						// if it inserted a user record successfully
						if($result_insert->rowCount() > 0)
						{
							header("Location:index.php?add_usuario&m=6");
						}
						else
						{	
							// it did not insert a user record
							header("Location:index.php?add_usuario&m=7");
						}
					}
				}
			}
		}
	} // Cierre de la funcion
}

?>