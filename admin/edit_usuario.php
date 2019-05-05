<?php
	try
	{
		$usuarios = new Usuarios();

		// if url contains the variable id_usuario :
		// we can call the function to get a user by id
		if(isset($_GET["id_usuario"]))
		{
			$id_usuario = $_GET["id_usuario"];

			$datos = $usuarios->get_usuario_por_id($id_usuario);
		}
		else
		{	
			// else: return to usuarios.php and to show a error message
			header("Location:index.php?usuarios&m=2");
		}
	}
	catch(Exception $e)
	{
		die("Error: {$e->getMessage()}");
	}
?>

<h1 class="text-primary">Editar usuario</h1>

<form action="" method="POST">
	<div class="form-group">
		<label class="control-label">Nombre:</label>
		<input type="text" name="nombre" class="form-control"
		       value="<?php echo $datos[0]["nombre"];?>">
	</div>

	<div class="form-group">
		<label class="control-label">Apellido:</label>
		<input type="text" name="apellido" class="form-control"
				value="<?php echo $datos[0]["apellido"];?>">
	</div>

	<div class="form-group">
		<label class="control-label">Usuario:</label>
		<input type="text" name="usuario" class="form-control" disabled
				value="<?php echo $datos[0]["usuario"];?>">
	</div>

	<div class="form-group">
		<label class="control-label">Email:</label>
		<input type="email" name="correo" class="form-control" disabled
				value="<?php echo $datos[0]["correo"];?>">
	</div>

	<div class="form-group">
		<label class="control-label">Password:</label>
		<input type="password" name="password" class="form-control" disabled
				value="<?php echo $datos[0]["password"];?>">
	</div>

	<div class="form-group">
		<input type="submit" name="edit_usuario" value="Editar usuario" 
			   class="btn btn-primary">
	</div>
</form>