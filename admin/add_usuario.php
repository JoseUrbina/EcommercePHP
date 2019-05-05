<?php
	$usuarios = new Usuarios();

	/*
		we validated if we sent the form
		to add a new user record
	*/
	if(isset($_POST["crear_usuario"]))
	{
		$usuarios->insertar_usuario();
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
				<h2 class="text-danger bg-danger">El formato del password debe tener al menos una letra mayúscula, una letra minúscula, un caracter extraño y un número y que sean minimo 12 caracteres y máximo 15 caracteres</h2>
<?php
				break;
			case 3:
?>
				<h2 class="text-danger bg-danger">Fallo en la consulta</h2>
<?php
				break;
			case 4:

?>
				<h2 class="text-danger bg-danger">El usuario ya existe en la base de datos</h2>
<?php
				break;
			case 5:
?>
				<h2 class="text-danger bg-danger">El correo ya existe en la base de datos</h2>
<?php
				break;
			case 6:
?>
				<h2 class="text-success bg-success">Se insertó el registro</h2>
<?php
				break;
			case 7:
?>
				<h2 class="text-danger bg-danger">No se insertó el registro</h2>
<?php
				break;
		}
	}
?>

<h1 class="text-primary">Agregar usuario</h1>

<form action="" method="POST" enctype="multipart/form-data">
	<div class="form-group">
		<label class="control-label">Nombre:</label>
		<input type="text" name="nombre" class="form-control">
	</div>

	<div class="form-group">
		<label class="control-label">Apellido:</label>
		<input type="text" name="apellido" class="form-control">
	</div>

	<div class="form-group">
		<label class="control-label">Usuario:</label>
		<input type="text" name="usuario" class="form-control" value="Admin">
	</div>

	<div class="form-group">
		<label class="control-label">Email:</label>
		<input type="email" name="correo" class="form-control">
	</div>

	<div class="form-group">
		<label class="control-label">Password:</label>
		<input type="password" name="password" class="form-control">
	</div>

	<div class="form-group">
		<input type="submit" name="crear_usuario" value="Añadir usuario" 
			   class="btn btn-primary">
	</div>
</form>