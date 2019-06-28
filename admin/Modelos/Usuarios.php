<?php

class Usuarios extends Conectar
{
	private $db;
	private $usuarios;
	private $usuario_por_id;

	public function __construct()
	{
		try
		{
			$this->db = parent::conexion();
			$this->usuarios = array();
			$this->usuario_por_id = array();
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
				echo "<h1 class='text-danger bg-danger'>Falla en la consulta</h1>";
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

	// Getting usser by id
	public function get_usuario_por_id($id_usuario)
	{
		try
		{
			$sql = "SELECT * FROM usuarios 
					WHERE id_usuario = :id_usuario";

			$resultado = $this->db->prepare($sql);
			$resultado->bindValue(":id_usuario", $id_usuario);

			// Failed query
			if(!$resultado->execute())
			{
				header("Location:index.php?usuarios&m=1");
			}
			else
			{
				// if user exists then we need to return data
				if($resultado->rowCount() > 0)
				{
					while($reg = $resultado->fetch(PDO::FETCH_ASSOC))
					{
						$this->usuario_por_id[] = $reg;
					}

					return $this->usuario_por_id;
				}
				else
				{
					// Else: return m : error message to file usuarios.php
					header("Location:index.php?usuarios&m=2");
				}
			}
		}
		catch(Exception $e)
		{
			throw $e;
		}
	}

	/* Edit Usuario */
	public function editar_usuario()
	{

		/*Declare variables which are sent by user from the form*/

		$id_usuario = $_GET["id_usuario"];
		$nombre = htmlentities(addslashes($_POST["nombre"]));
		$apellido = htmlentities(addslashes($_POST["apellido"]));

		/*
		
			*** 
				We declared these variables, but it's not necessary
				because we did not use them. 
			***
		
			$usuario = $_POST["usuario"];
			$correo = $_POST["correo"];
			$password = $_POST["password"];
		*/

		// Validate if fields are empty and to return a error message
		if(empty($nombre) or empty($apellido))
		{
			header("Location:index.php?edit_usuario&id_usuario=" . 
				    $id_usuario . "&m=1");
			exit();
		}
		else
		{
			try
			{
				/*Validate if it exists the id usuario into DB*/

				$sql_search = "SELECT id_usuario FROM usuarios
							   WHERE id_usuario = :id_usuario";

				$resultado_search = $this->db->prepare($sql_search);
				$resultado_search->bindValue(":id_usuario", $id_usuario);

				// Failed query
				if(!$resultado_search->execute())
				{
					header("Location:index.php?edit_usuario&id_usuario=" .
							$id_usuario . "&m=2");
				}
				else
				{
					// if user exist, we will follow to edit it
					if($resultado_search->rowCount() > 0)
					{
						/** Editing User **/

						$sql = "UPDATE usuarios 
								SET nombre = :nombre, 
								    apellido = :apellido 
								WHERE id_usuario = :id_usuario";

						$resultado = $this->db->prepare($sql);
						$resultado->bindValue(":nombre", $nombre);
						$resultado->bindValue(":apellido",$apellido);
						$resultado->bindValue(":id_usuario", 
											  $id_usuario);

						// failed query : return edit_usuario page
						if(!$resultado->execute())
						{
							header("Location:index.php?edit_usuario" . "&id_usuario={$id_usuario}&m=2");
						}
						else
						{
							// if record has been edited successfully
							if($resultado->rowCount() > 0)
							{
							header("Location:index.php?edit_usuario"
								. "&id_usuario={$id_usuario}&m=3");
							}
							else
							{
								// if record has not been edited
							header("Location:index.php?edit_usuario"
								. "&id_usuario={$id_usuario}&m=4");
							}
						}
					}
					else
					{	
						// if id_usuario has not found, return to usuarios page
						header("Location:index.php?usuarios&m=2");
					}
				}
			}
			catch(Exception $e)
			{
				throw $e;
			}
		}
	}

	// function which deletes a user by id
	public function eliminar_usuario($id_usuario)
	{
		try
		{
			// Searching if user exists in DB

			$sql_search = "SELECT id_usuario FROM usuarios
						   WHERE id_usuario = :id_usuario";

			$resultado_search = $this->db->prepare($sql_search);
			$resultado_search->bindValue(":id_usuario", $id_usuario);

			// failed query
			if(!$resultado_search->execute())
			{
				header("Location:index.php?usuarios&m=1");
			}
			else
			{	
				// User has been found in the DB
				if($resultado_search->rowCount() > 0)
				{
					// we are gonna delete the user by id

					$sql_delete = "DELETE FROM usuarios 
								   WHERE id_usuario = :id_usuario";

					$resultado_delete = $this->db->prepare($sql_delete);
					$resultado_delete->bindValue(":id_usuario", $id_usuario);

					// failed query
					if(!$resultado_delete->execute())
					{
						header("Location:index.php?usuarios&m=1");
					}
					else
					{
						if($resultado_delete->rowCount() > 0)
						{
							// User has been deleted successfully
							header("Location:index.php?usuarios&m=3");
						}
						else
						{
							// User has not been deleted
							header("Location:index.php?usuarios&m=4");
						}
					}
				}
				else
				{
					// if user has not been found in DB
					header("Location:index.php?usuarios&m=5");
				}
			}
		}
		catch(Exception $e)
		{
			throw $e;
		}
	}

	/*Function LOGIN*/

	public function Login($correo, $password)
	{
        // Validate empty fields
        if(empty($correo) && empty($password))
        {
            echo "<h1 class='text-center text-danger bg-danger'>Los campos del formulario estan vacios.</h1>";
        
        /*
			El formato del password debe tener al menos una letra mayúscula, una letra minúscula, un caracter extraño y un número, por ejemplo en este proyecto esta $Qw/*12345678$ no importa el orden lo importante es que se cumple el formato.
		*/
	
		/*
			Si no se cumple esta expresion regular con un formato del password de que al menos tenga una letra mayúscula, una letra minúscula, un caracter extraño y un número y que sean minimo 12 caracteres.
		 */
		
		}
		else if(!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&])([A-Za-z\d$@$!%*?&]|[^ ]){12,15}$/",$password))
		{
			echo "<h2 class='text-center text-danger bg-danger'>" 
				. "La contraseña no existe en la base de datos</h2>";
		}
        else
        {
            // Validating if the email exist in the database
            
            try
            {
                $sql = "SELECT * FROM usuarios 
                		WHERE correo = :correo";
                $resultado = $this->db->prepare($sql);
                $resultado->bindValue(':correo', $correo);

                // Validate if it exist an query error
                if(!$resultado->execute())
                {
                    echo "<h1 class='text-center text-danger bg-danger'>Falla en la consulta</h1>";
                }
                else
                {
                    // Validating if email exists in database
                    if($resultado->rowCount() > 0)
                    {
                        $reg = $resultado->fetch(PDO::FETCH_ASSOC);

                        $id_usuario = $reg['id_usuario'];
                        $usuario_bd = $reg['usuario'];
                        $password_bd = $reg['password'];
                        $nombre_bd = $reg['nombre'];
                        $correo_bd = $reg['correo'];

                        /* I validated if password are the same with the database  which is encrypted*/
                        if(password_verify($password, $password_bd))
                        {
                            $_SESSION["id_usuario"] = $id_usuario;
                            $_SESSION["usuario"] = $usuario_bd;
                            $_SESSION["nombre"] = $nombre_bd;
                            $_SESSION["correo"] = $correo_bd; 

                            header('location:admin/index.php');
                        }
                        else
                        {
                            // If the email and password are different against database
                            header('location:login.php');
                        }
                    }
                    else
                    {
                        // ** Email has not found in database **
                        echo "<h1 class='text-center text-danger bg-danger'>El correo no ha sido encontrado en la base de datos</h1>";
                    }
                }
            }
            catch(Exception $e)
            {
                die("Error: {$e->getMessage()}");
            }
        }
	}

	// function that gets the number of usuario records
	public function get_numero_usuarios()
	{
		try
		{
			$sql = "SELECT * FROM usuarios";

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

	/*
		We validate if email exists in usuarios table from BD
		to reset the password
	*/
	public function get_correo_en_bd($correo, $token)
	{
		try
		{
			$sql = "SELECT correo FROM usuarios 
					WHERE correo = :correo";

			$resultado = $this->db->prepare($sql);
			$resultado->bindValue(":correo", $correo);

			if(!$resultado->execute())
			{
				echo "<h2 class='text-center text-danger'>Falló en la consulta</h2>";
			}
			else
			{
				// Exist a record with that email
				if($resultado->rowCount() > 0)
				{
					// Update token field
					$sql_upd = "UPDATE usuarios 
								SET token = :token
								WHERE correo = :correo";

					$resultado_upd = $this->db->prepare($sql_upd);

					$resultado_upd->bindValue(":token", $token);
					$resultado_upd->bindValue(":correo", $correo);

					if(!$resultado_upd->execute())
					{
						echo "<h2 class='text-center text-danger'>Falló en la consulta</h2>";
					}
					else
					{
						/*
							COMENZAR - ENVIAMOS EL CORREO

							** IMPORTANTE: CUANDO VAYAS A SUBIR EL PROYECTO AL HOSTING PONER EL NOMBRE DEL DOMINIO DEL HOSTING EN EL href DEL ANCLA href='http://tudominio.com/'' QUE SEN ENCUENTRA EN EL $cuerpo **
						 */
						
						$to = $correo;
						$asunto = "Proyecto Ecommerce - Resetear password";

						$cuerpo = " 
							<html>
							<head>
								<title></title>
							</head>
							<body>
								<h1 style='color:black;'>PROYECTO ECOMMERCE</h1>
								<p>Por favor dar click en el link para resetear la contraseña
								
								<a href='http://localhost/EcommercePHP/resetear.php?correo=" . $correo . "&token=" . $token . "'>
								
								http://localhost/EcommercePHP/resetear.php?correo=" . $correo . "&token=" . $token . "</a>


								</p>
							</body>
							</html>
						";

						// COnfiguration to send in HTML Format
						$cabeceras = "MIME-Version:1.0\r\n";
						$cabeceras .= "Content-type:text/html;charset=iso-8859-1\r\n";

						// Validando el envío del correo
						if(mail($to, $asunto, $cuerpo, $cabeceras))
						{	
							$correo_enviado = true;

							echo "<h2 class='text-center text-success'>Se ha enviado un correo, por favor dar click en el link para resetear la contraseña</h2>";

							exit();
						}
						else
						{
							echo "<h2 class='text-center text-danger'>No se envió el correo</h2>";
						}

						/* FIN: ENVIAMOS EL CORREO */
					}
				}
				else
				{
					// Email does not exist in the Database
					
					echo "<h2 class='text-center text-danger'>El correo ingresado no existe en la base de datos</h2>";
				}
			}
		}
		catch(Exception $e)
		{
			throw $e;
		}
	}
}

?>