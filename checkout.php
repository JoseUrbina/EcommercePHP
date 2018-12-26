<!-- Adding file conexion.php-->
<?php require_once "includes/conexion.php";?>
<!-- Adding file header.php -->
<?php require_once "includes/header.php";?>

<!-- Test variable for seeing the amount of a product
     But this space will be used for checking if we are adding products
-->
<?php // echo $_SESSION['producto_1'];?>

    <!-- Page Content -->
<div class="container">

<!-- /.row --> 

<div class="row">

  <?php
      if(isset($_GET['cantidad']) && isset($_GET['producto_titulo']))
      {
          $cantidad = $_GET['cantidad'];
          $producto_titulo = $_GET['producto_titulo'];

          echo "<h1 class='text-danger text-center bg-danger'>Tenemos {$cantidad} productos disponibles del ({$producto_titulo})</h1>";
      }
  ?>

      <h1>Checkout</h1>

<form action="">
    <table class="table table-striped">
        <thead>
          <tr>
           <th>Producto</th>
           <th>Precio</th>
           <th>Cantidad</th>
           <th>Sub-total</th>
     
          </tr>
        </thead>
        <tbody>
          <?php
              try
              {
                  $conectar = Conectar::conexion();

                  // A way to foreach all stored SESSIONS
                  foreach($_SESSION as $name => valor){
                      // Validacion para listar solo productos con una cantidad > 0
                      if($valor > 0)
                      {
                        // Verify if session name it's a product
                        if(substr($name, 0 , 9) == "producto_")
                        {
                            // Variable which stores the length to use
                            // in the next substr function
                            $length = strlen($name) - 9;

                            // Getting the id_product from the session name
                            // 9: Represent the space after _
                            $id_producto = substr($name, 9, $length);  

                            $sql = "SELECT * FROM productos WHERE id_producto = :id_producto";

                            $resultado = $conectar->prepare($sql);

                            if($resultado->execute())
                            {
                                while($reg = $resultado->fetch(PDO::FETCH_ASSOC)){
                                    $id_producto = $reg["id_producto"];
                                    $producto_titulo = $reg["producto_titulo"];
                                    $producto_precio = $reg["producto_precio"]; 
                                    $producto_cantidad = $reg["producto_cantidad"];
                                    $producto_imagen = $reg["producto_imagen"]; 
                                } // Cierre while
                            } // Cierre IF Conditional
                            else
                            {
                              echo "<h1 style='color:red;'>Failed query</h1>";
                            }
                        } // Cierre de la validacion substr
                      } // Cierre validacion del valor > 0
                  } // Cierre del foreach
              }
              catch(Exception $e)
              {
                die("Error: {$e->getMessage()}");
              }
              finally{
                $conectar = null;
              }
          ?>
            <tr>
                <td>apple</td>
                <td>$23</td>
                <td>3</td>
                <td>2</td>
                <td>
                    <a class="btn btn-warning" href="carro.php?remover=<?php echo $id_producto;?>">
                    <span class="glyphicon glyphicon-minus"></span></a>

                    <a class="btn btn-success" href="carro.php?agregar=<?php echo $id_producto;?>">
                    <span class="glyphicon glyphicon-plus"></span></a>

                    <a class="btn btn-danger" href="carro.php?eliminar=<?php echo $id_producto;?>">
                    <span class="glyphicon glyphicon-remove"></span></a>
                </td>
            </tr>

          <?php
                    
          ?>
        </tbody>
    </table>
</form>



<!--  ***********CART TOTALS*************-->
            
<div class="col-xs-4 pull-right ">
<h2>Cart Totals</h2>

<table class="table table-bordered" cellspacing="0">

<tr class="cart-subtotal">
<th>Items:</th>
<td><span class="amount">4</span></td>
</tr>
<tr class="shipping">
<th>Shipping and Handling</th>
<td>Free Shipping</td>
</tr>

<tr class="order-total">
<th>Order Total</th>
<td><strong><span class="amount">$3444</span></strong> </td>
</tr>


</tbody>

</table>

</div><!-- CART TOTALS-->


 </div><!--Main Content-->

</div>
    <!-- /.container -->

<!-- Adding file footer.php -->
<?php require_once "includes/footer.php";?>