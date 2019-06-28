<!-- Adding file conexion.php -->
<?php require_once "includes/conexion.php"; ?>
<!-- Adding file header.php -->
<?php require_once "includes/header.php"; ?>
<!-- Adding file Modelos => Usuarios.php-->
<?php require_once "admin/Modelos/Usuarios.php";?>

<?php
	try
	{
		// Instance a new usuario to use its methods
		$usuarios = new Usuarios();
	}
	catch(Exception $e)
	{
		die("Error: {$e->getMessage()}");
	}
?>

<?php
	// Validate if we sent the email via POST
	if(isset($_POST["submit"])){

		$correo = htmlentities(addslashes($_POST["correo"]));
		$length = 60;

		// Generate token
		$token = bin2hex(openssl_random_pseudo_bytes($length));

		// we validated if email exists in the usuarios table in BD
		$verificar_correo = $usuarios->get_correo_en_bd($correo, 
														$token);
	}
?>

<div class="container">
	<div class="row">
		<div class="col-md-4 col-md-offset-4">
			<div class="panel panel-default">
				<div class="panel-body">
					<div class="text-center">
<?php
	// if it does not exist this variable, show message
	if(!isset($correo_enviado)){
?>
					<h3><i class="fa fa-lock fa-4x"></i></h3>
					<h2 class="text-center">Olvidó su Contraseña?</h2>
					<p>Usted puede resetear su contraseña aquí</p>
					<div class="panel-body">
						<form id="registro_form" autocomplete="off"
							  role="form" class="form" method="POST">
						
						<div class="form-group">
							<div class="input-group">
							<span class="input-group-addon"><i class="glyphicon glyphicon-envelope color-blue"></i></span>
							<input id="correo" type="correo" 
								  name="correo" placeholder="Correo electrónico" class="form-control">
							</div>
						</div>

						<div class="form-group">
							<input type="submit" name="submit" class="btn btn-lg btn-block btn-primary" value="Resetear Contraseña">
						</div>	
						
						<input type="hidden" class="hide" name="token" id="token" value="">

						</form>
					</div>
					
<?php }?>


					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- Adding reference to file footer.php -->
<?php require_once "includes/footer.php";?>

