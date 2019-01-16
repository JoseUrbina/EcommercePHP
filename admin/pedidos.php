<?php
  
  try
  {
    $pedido = new Pedidos();

    $datos = $pedido->get_pedidos();
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
    if(isset($_GET["m"]))
    {
      switch($_GET["m"])
      {
        case 1:
?>
      <h1 class="text-danger bg-danger">Failed query!</h1>
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
                <td><?php echo $datos[$i]["pedido_amount"];?></td>
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