 <div class="col-md-3">
    <p class="lead">Shop Name</p>
    <div class="list-group">
		
		<?php
			// List all categorias in the sidebar

			try
			{
				$conectar = Conectar::conexion();

				$sql = "SELECT * FROM categorias";
				$resultado = $conectar->prepare($sql);

				// In case error -> showing message
				if(!$resultado->execute())
				{
					echo "<h1 style='color:red'>Failed conection</h1>";
				}
				else
				{
					// fetch each row getting
					while($row = $resultado->fetch(PDO::FETCH_ASSOC)){
						$id_categoria = $row['id_categoria'];
						$cat_titulo = $row['cat_titulo'];

						// show cat_titulo and send id_categoria to categoria.php
						echo "<a class='list-group-item' 
							     href='categoria.php?id_categoria=$id_categoria'>
							     {$cat_titulo}
							  </a>";
					}
				}
			}
			catch(Exception $e){
				die("Error: {$e->getMessage()}");
			}
			finally{
				$conectar = null;
			}
		?>
    </div>
</div>