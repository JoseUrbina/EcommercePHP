<?php
  
  try
  {
    $producto = new Productos();

    // Get all products
    $datos = $producto->get_productos();

    // Delete product if it exists this variable
    if(isset($_GET["eliminar"]))
    {
      $id_producto = $_GET["eliminar"];

      $producto->eliminar_producto($id_producto);
    }
  }
  catch(Exception $e)
  {
    die("Error: {$e->getMessage()}");
  }
?>

<div class="row">
  <h1 class="page-header">
    Productos
  </h1>

<?php 

/*Show message error or success*/

  if(isset($_GET["m"]))
  {
    switch($_GET["m"])
    {
      case 1:
?>
          <h1 class="text-danger bg-danger">Failed Query!</h1>
<?php
          break;
      case 2:
?>
          <h1 class="text-success bg-success">Se elimino el producto</h1>
<?php
          break;
      case 3:
?>
          <h1 class="text-danger bg-danger">No existe el id del producto seleccionado</h1>
<?php
          break;
    }
  }
?>

  <a href="index.php?add_producto" class="btn btn-primary">Añadir producto</a>

  <table class="table table-hover">
    <thead>
      <tr>
        <th>Id</th>
        <th>Titulo</th>
        <th>Categoria</th>
        <th>Precio</th>
        <th>Cantidad</th>
        <th>Editar</th>
        <th>Eliminar</th>
      </tr>
    </thead>
    <tbody>
      <?php for($i=0;$i<count($datos);$i++){?>
      <tr>
        <td><?php echo $datos[$i]["id_producto"]; ?></td>
        <td>
          <?php echo $datos[$i]["producto_titulo"]; ?> <br>
          <a href="index.php?edit_producto&editar=<?php echo $datos[$i]['id_producto'];?>">
            <img src="../uploads/<?php echo $datos[$i]['producto_imagen'];?>" alt="" width="100">
          </a>  
        </td>
        <td>
          <?php 

            // SEND PARAMETER FOR GETTING THE CATEGORIA TITLE
            $producto_id_categoria = $datos[$i]["producto_id_categoria"];

            $producto->mostrar_categoria_titulo($producto_id_categoria); 
          ?>
        </td>
        <td>&#36;<?php echo $datos[$i]["producto_precio"]; ?></td>
        <td><?php echo $datos[$i]["producto_cantidad"]; ?></td>
        <td>
          <a class="btn btn-success" 
             href="index.php?edit_producto&editar=<?php echo $datos[$i]['id_producto'];?>">
             <i class="fa fa-pencil"></i> Editar</a>
        </td>
        <td>
          <a onclick="javascript:return confirm('¿Esta seguro que lo quiere eliminar?')" 
             class="btn btn-danger" 
             href="index.php?productos&eliminar=<?php echo $datos[$i]['id_producto']?>">
          <i class="fa fa-trash"></i> Eliminar</a>
        </td>
      </tr>
      <?php }?>
    </tbody>
  </table>
</div>