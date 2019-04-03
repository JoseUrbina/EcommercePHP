<?php
  
  try
  {
    $pedido = new Pedidos();

    $datos = $pedido->get_pedidos();

    // Verify if it exists this variable : Delete a pedido
    if(isset($_GET["eliminar"]))
    {
        $id_pedido = $_GET["eliminar"];

        // Call eliminar_pedido() : it return an answer
        $pedido->eliminar_pedido($id_pedido);
    }
  }
  catch(Exception $e)
  {
    die("Error: {$e->getMessage()}");
  }

?>

<div class="col-md-12">
    <div class="row">
        <h1 class="page-header">
         Pedidos
        </h1>

<?php
    // Validate if it exists this variable m
    if(isset($_GET["m"]))
    {
      // switch : take different option through the value
      switch($_GET["m"])
      {
        case 1:
?>
      <h1 class="text-danger bg-danger">Failed query!</h1>
<?php
        break;

        case 2:
?>
      <h1 class="text-success bg-success">Se elimino el pedido!</h1>
<?php
        break;

        case 3:
?>
      <h1 class="text-danger bg-danger">No existe el id del pedido seleccionado!</h1>
<?php
        break;
      }
    }
?>
    </div>
</div>

<div class="row">
    <table class="table table-hover">
        <thead>
          <tr>
               <th>Id</th>
               <th>Precio</th>
               <th>Transaccion</th>
               <th>Moneda</th>
               <th>Status</th>
               <th>Eliminar</th>
          </tr>
        </thead>
        <tbody>
          <?php for($i=0;$i<count($datos);$i++){?>
            <tr>
                <td><?php echo $datos[$i]["id_pedido"];?></td>
                <td>&#36;<?php echo $datos[$i]["pedido_amount"];?></td>
                <td><?php echo $datos[$i]["pedido_transaction"];?></td>
                <td><?php echo $datos[$i]["pedido_currency"];?></td>
                <td><?php echo $datos[$i]["pedido_status"];?></td>
                <td>
                  <a onclick="javascript:return confirm('¿Estas seguro que lo quieres eliminar?');" class="btn btn-danger" 
                  href="index.php?pedidos&eliminar=<?php echo $datos[$i]["id_pedido"]?>">
                  <i class="fa fa-trash"></i> Eliminar</a>
                </td>
            </tr>
          <?php }?>
        </tbody>
    </table>
</div>