<?php
  
  try
  {
    $reporte = new Reportes();

    // Get all reportes
    $datos = $reporte->get_reportes();

    // Delete reporte if it exists this variable
    if(isset($_GET["eliminar"]))
    {
      $id_reporte = $_GET["eliminar"];

      $reporte->eliminar_reporte($id_reporte);
    }
  }
  catch(Exception $e)
  {
    die("Error: {$e->getMessage()}");
  }
?>

<div class="row">
  <h1 class="page-header">
    Reportes
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
          <h1 class="text-success bg-success">
            Se elimino el reporte
          </h1>
<?php
          break;
      case 3:
?>
          <h1 class="text-danger bg-danger">
            No existe el id del reporte seleccionado
          </h1>
<?php
          break;
    }
  }
?>

   <table class="table table-hover">
    <thead>
      <tr>
        <th>Id</th>
        <th>Id Producto</th>
        <th>Id Pedido</th>
        <th>Producto Precio</th>
        <th>Producto Titulo</th>
        <th>Producto Cantidad</th>
        <th>Eliminar</th>
      </tr>
    </thead>
    <tbody>
      <?php for($i=0;$i<count($datos);$i++){?>
      <tr>
        <td><?php echo $datos[$i]["id_reporte"];?></td>
        <td><?php echo $datos[$i]["id_producto"];?></td>
        <td><?php echo $datos[$i]["id_pedido"];?></td>
        <td>&#36;<?php echo $datos[$i]["producto_precio"];?></td>
        <td><?php echo $datos[$i]["producto_titulo"];?></td>
        <td><?php echo $datos[$i]["producto_cantidad"];?></td>
        <td>
          <a onclick="javascript:return confirm('¿Esta seguro que lo quiere eliminar?');" class="btn btn-danger"
            href="index.php?reportes&eliminar=<?php echo $datos[$i]['id_reporte']?>"><i class="fa fa-trash"></i> Eliminar</a>
        </td>
      </tr>
      <?php }?>
    </tbody>
  </table>
</div>