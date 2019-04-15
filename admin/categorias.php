<?php
    
    try
    {
        $categoria = new Categorias();

        // Get all categories from DB
        $datos = $categoria->get_categorias();

        // we are validating if we are sending datas
        if(isset($_POST["submit"]))
            $categoria->insertar_categoria();        
    }
    catch(Exception $e)
    {
        die("Error: {$e->getMessage()}");
    }
?>

<h1 class="page-header">
  Producto Categorias
</h1>

<?php  
    if(isset($_GET["m"]))
    {
        switch($_GET["m"])
        {
            case 1:
?>
                <h1 class="text-danger bg-danger">El campo esta vacio</h1>
<?php
                break;
            case 2:
?>
                <h1 class="text-danger bg-danger">Fallo en la consulta</h1>
<?php
                break;
            case 3:
?>
                <h1 class="text-danger bg-danger">Ya existe la categoria</h1>
<?php
                break;
            case 4: 
?>
                <h1 class="text-success bg-success">Se ha insertado la categoria</h1>
<?php  
                break;
            case 5:
?>
                <h1 class="text-danger bg-danger">No se ha insertado la categoria</h1>
<?php
                break;
            case 6:
?>
                <h1 class="text-danger bg-danger">No existe el id de la categoria</h1>
<?php
                break;
        }
    }
?>

<div class="col-md-4">
    <form action="" method="post">
        <div class="form-group">
            <label for="category-title">Titulo</label>
            <input type="text" name="cat_titulo" class="form-control">
        </div>

        <div class="form-group">
            <input type="submit" name="submit" class="btn btn-primary" value="Añadir Categoria">
        </div>      
    </form>

    <?php
        // if we click on the editar button, show us the form 
        if(isset($_GET["editar"]))
        {
            require_once "edit_categorias.php";
        }
    ?>
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
                        <a class="btn btn-primary" href="index.php?categorias&editar=<?php echo $cat['id_categoria'];?>"><i class="fa fa-pencil"></i> Editar</a>
                    </td>
                    <td>
                        <!-- Boton Eliminar -->
                        <a onClick="javascript:return Confirm('¿Estas seguro que lo quieres eliminar?');" class="btn btn-danger" 
                        href="index.php?categorias&eliminar=<?php echo $cat["id_categoria"];?>"><i class="fa fa-trash"></i> Eliminar</a>
                    </td>
                </tr>
            <?php }?>
        </tbody>
    </table>
</div>