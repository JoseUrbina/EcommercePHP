<?php
	try
	{
		$usuarios = new Usuarios();

		// with this, we can edit x user then a post request
		if(isset($_POST["editar_usuario"]))
		{
			$usuarios->editar_usuario();
		}

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

<?php
	if(isset($_GET["m"]))
	{
		switch($_GET["m"])
		{
			case 1:
?>
				<h2 class="text-danger bg-danger">El campo está vacío</h2>
<?php
				break;
			case 2:
?>
				<h2 class="text-danger bg-danger">Falló en la consulta</h2>
<?php
				break;
			case 3:
?>
				<h2 class="text-success bg-success">Se editó el registro</h2>
<?php
				break;
			case 4:
?>
				<h2 class="text-danger bg-danger">No se editó el registro</h2>
<?php
				break;
		}
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
		<input type="submit" name="editar_usuario" value="Editar usuario" 
			   class="btn btn-primary">
	</div>
</form>