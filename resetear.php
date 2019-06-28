<!-- Adding reference to file conexion.php -->
<?php require_once "includes/conexion.php";?>
<!-- Adding reference to file header.php -->
<?php require_once "includes/header.php";?>

<?php
	/*
		if parameters (correo, token) do not exist in URL, redirect to index.php
	*/
	if(!isset($_GET["correo"]) && !isset($_GET["token"]))
	{
		header("Location:index.php");
	}
	else
	{
		/*
			Parameters in URL which are send from click in the link that is in your email
		*/
	
		$correo = htmlentities(addslashes($_GET["correo"]));
		$token = htmlentities(addslashes($_GET["token"]));

		/*
			Consultamos si el correo y el token existen en la tabla usuarios, en caso que existan procedemos a resetear el password
		*/
	
		try
		{
			$conectar = Conectar::conexion();

			$sql = "SELECT correo, token FROM usuarios
					WHERE correo = :correo AND token = :token";

			$resultado = $conectar->prepare($sql);
			$resultado->bindValue(":correo", $correo);
			$resultado->bindValue(":token", $token);

			// failed query
			if(!$resultado->execute())
			{
				echo "<h2 class='text-danger'>Falló en la consulta</h2>";
			}
			else
			{
				/*
					SI existe la consulta y los campos password coinciden, entonces reseteamos el password
				 */
				if($resultado->rowCount() > 0)
				{
					if(isset($_POST["submit"]))
					{
						// validamos que los campos no esten vacios
						
						if(empty($_POST["password"]) AND 
						   empty($_POST["confirmar_password"]))
						{
							echo "<h2 class='text-center text-danger'>Los campos esta vacíos</h2>";
						}
						else if(!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&])([A-Za-z\d$@$!%*?&]|[^ ]){12,15}$/",$_POST["password"]))
						{
						/*
							Si no se cumple esta expresion regular con un formato del password de que al menos tenga una letra mayúscula, una letra minúscula,un caracter extraño y un número y que sean minimo 12 caracteres	
						 */
						
							echo "<h2 class='text-center text-danger'>El formato de la contraseña debe tener al menos una letra mayúscula, una letra minúscula, un caracter extraño y un número. Minimo 12 caracteres y máximo 15 caracteres</h2>";
						}
						else
						{
							/*SI los campos del password coinciden, editamos el password*/

							if($_POST["password"] === $_POST["confirmar_password"])
							{
							$password = htmlentities(addslashes($_POST["password"]));

							// encriptar password
							$pass_encrypt = password_hash($password, PASSWORD_DEFAULT);

							$sql_upd = "UPDATE usuarios 
										SET password = :password
										WHERE correo = :correo AND
										token = :token";

							$result_upd=$conectar->prepare($sql_upd);
							$result_upd->bindValue(":password", 
												   $pass_encrypt);

							$result_upd->bindValue(":correo", 
												   $correo);
							$result_upd->bindValue(":token", 
												   $token);

							if(!$result_upd->execute())
							{
								echo "<h2 class='text-center text-danger'>Falló en la consulta</h2>";
							}
							else
							{
								/*Verificar si hay filas afectadas*/
								if($result_upd->rowCount() > 0)
								{
									/*Redireccionar al login con un mensaje de exito y loguearse con el nuevo password*/

									header("Location:login.php?m=1");
								}
							}

							}
							else
							{
								echo "<h2 class='text-center text-danger'>Las contraseñas no coinciden</h2>";
							}
						}

						/*
							Cierre del else si los campos no estan vacíos y los passwords cumplen con el formato

						 */
					}
					else
					{
						echo "<h2 class='text-center text-success'>Debe ingresar la nueva contraseña y que ambos coincidan</h2>";
					}
				}
				else
				{
					/*SI no existe la consulta entonces lo redirecciona a index.php*/
					header("Location:index.php");
				}
			}
		}
		catch(Exception $e)
		{
			die("Error: {$e->getMessage()}");
		}
	}

?>

<div class="container">
	<div class="row">
		<div class="col-md-4 col-md-offset-4">
			<div class="panel panel-default">
				<div class="panel-body">
					<div class="text-center">
					<h3><i class="fa fa-lock fa-4x"></i></h3>
					<h2 class="text-center">Resetear Contraseña</h2>
					<p>Usted puede resetear su contraseña aquí</p>
					<div class="panel-body">
						<form id="registro_form" autocomplete="off"
							  role="form" class="form" method="POST">
						
						<div class="form-group">
							<div class="input-group">
							<span class="input-group-addon"><i class="glyphicon glyphicon-user color-blue"></i></span>
							<input id="password" type="password" 
								  name="password" placeholder="Escriba su contraseña" class="form-control">
							</div>
						</div>

						<div class="form-group">
							<div class="input-group">
							<span class="input-group-addon"><i class="glyphicon glyphicon-ok color-blue"></i></span>
							<input id="confirmar_password" 
								  type="password" 
								  name="confirmar_password" placeholder="Confirmar contraseña" class="form-control">
							</div>
						</div>

						<div class="form-group">
							<input type="submit" name="submit" 
							class="btn btn-lg btn-block btn-primary" value="Resetear Contraseña">
						</div>	
						</form>
					</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- Adding reference to file footer.php -->
<?php require_once "includes/footer.php";?>