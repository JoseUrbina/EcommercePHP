<div class="col-md-12">
	<div class="row">
		<h1 class="page-header text-primary">Editar usuario</h1>
	</div>
</div>

<form action="" method="POST">
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
		<input type="text" name="usuario" class="form-control" disabled>
	</div>

	<div class="form-group">
		<label class="control-label">Email:</label>
		<input type="email" name="correo" class="form-control" disabled>
	</div>

	<div class="form-group">
		<label class="control-label">Password:</label>
		<input type="password" name="password" class="form-control" disabled>
	</div>

	<div class="form-group">
		<input type="submit" name="edit_usuario" value="Editar usuario" 
			   class="btn btn-primary">
	</div>
</form>