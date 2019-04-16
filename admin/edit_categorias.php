<form action="" method="post">
    <div class="form-group">
        <label for="category-title">Editar Categoria</label>
        
		<?php
			// Obtener la categoria por id

			$id_categoria = $_GET["editar"];

			/*
				As we are into the file categorias.php
				we can use the variable categoria that is created
				in this file.
			*/

			$categoria->get_categoria_por_id($id_categoria);
		?>
    </div>

    <div class="form-group">
        <input type="submit" name="editar_categoria" class="btn btn-primary" value="Editar Categoria">
    </div>      
</form>