<?php
    
    try
    {
        $categoria = new Categorias();

        // Get all categories from DB
        $datos = $categoria->get_categorias();
    }
    catch(Exception $e)
    {
        die("Error: {$e->getMessage()}");
    }

?>

<h1 class="page-header">
  Producto Categorias
</h1>

<div class="col-md-4">
    <form action="" method="post">
        <div class="form-group">
            <label for="category-title">Title</label>
            <input type="text" name="cat_titulo" class="form-control">
        </div>

        <div class="form-group">
            <input type="submit" name="submit" class="btn btn-primary" value="Añadir Categoria">
        </div>      
    </form>
</div>

<div class="col-md-8">
    <table class="table">
        <thead>
            <tr>
                <th>id</th>
                <th>Titulo</th>
                <th>Editar</th>
                <th>Eliminar</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach($datos as $cat){ ?>
                <tr>
                    <td><?php echo $cat["id_categoria"];?></td>
                    <td><?php echo $cat["cat_titulo"];?></td>
                    <td>
                        <!-- Boton editar -->
                        <a class="btn btn-primary" href="index.php?categoria&editar=<?php echo $cat['id_categoria'];?>"><i class="fa fa-pencil"></i> Editar</a>
                    </td>
                    <td>
                        <!-- Boton Eliminar -->
                        <a onClick="javascript:return Confirm('¿Estas seguro que lo quieres eliminar?');" class="btn btn-danger" 
                        href="index.php?categoria&eliminar=<?php echo $cat["id_categoria"];?>"><i class="fa fa-trash"></i> Eliminar</a>
                    </td>
                </tr>
            <?php }?>
        </tbody>
    </table>
</div>