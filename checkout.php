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

<!-- Use URL www.sandbox.paypal.com -->
<form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post">
    <input type="hidden" name="cmd" value="_cart">
    <!-- Use your Business Account -->
    <input type="hidden" name="business" value="msn.guti5395@outlook.com">
    <!-- CUrrency to use for buying products -->
    <input type="hidden" name="currency_code" value="USD">
 
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

                  // Variable which the price total of the shopping
                  $total = 0;

                  $item_cantidad = 0;

                  // Variable to use as counter for sending products to paypal
                  $item_name = 1;
                  $item_number = 1;
                  $amount = 1;
                  $quantity = 1;

                  // A way to foreach all stored SESSIONS
                  foreach($_SESSION as $name => $valor){
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
                            $resultado->bindValue(":id_producto", $id_producto);

                            if($resultado->execute())
                            {
                                while($reg = $resultado->fetch(PDO::FETCH_ASSOC)){
                                    $id_producto = $reg["id_producto"];
                                    $producto_titulo = $reg["producto_titulo"];
                                    $producto_precio = $reg["producto_precio"]; 
                                    $producto_cantidad = $reg["producto_cantidad"];
                                    $producto_imagen = $reg["producto_imagen"]; 
                              
                                    // Calculo del subtotal
                                    $sub_total = $producto_precio * $valor;
                                
                                    /*cantidad de items*/
                                    $item_cantidad += $valor;
          ?>
            <tr>
                <td><?php echo $producto_titulo;?></td>
                <td>&#36;<?php echo "{$producto_precio}";?></td>
                <td><?php echo $valor;?></td>
                <td>&#36;<?php echo $sub_total;?></td>
                <td>
                    <a class="btn btn-warning" href="carro.php?remover=<?php echo $id_producto;?>">
                    <span class="glyphicon glyphicon-minus"></span></a>

                    <a class="btn btn-success" href="carro.php?agregar=<?php echo $id_producto;?>">
                    <span class="glyphicon glyphicon-plus"></span></a>

                    <a class="btn btn-danger" href="carro.php?eliminar=<?php echo $id_producto;?>">
                    <span class="glyphicon glyphicon-remove"></span></a>
                </td>
            </tr>
            
            <!-- Put _ on the name , because it can be 1 o more products (Cicle) -->

            <input type="hidden" name="item_name_<?php echo $item_name;?>" 
                   value="<?php echo $producto_titulo;?>">
            <input type="hidden" name="item_number_<?php echo $item_number;?>" 
                   value="<?php echo $id_producto;?>">
            <!-- Precio del producto -->
            <input type="hidden" name="amount_<?php echo $amount;?>" 
                   value="<?php echo $producto_precio;?>">
            <!-- Cantidad del producto --> 
            <input type="hidden" name="quantity_<?php echo $quantity;?>" 
                   value="<?php echo $valor;?>">
  
          <?php
                              // Aumentar contadores
                              
                              $item_name++;
                              $item_number++;
                              $amount++;
                              $quantity++;


                                } // Cierre while

                                // Store the total of the shopping
                                $_SESSION['item_total'] = $total += $sub_total;

                                // Calculo del numero de items
                                $_SESSION['item_cantidad'] = $item_cantidad;

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
        </tbody>
    </table>
    <input type="image" name="upload"
           src="https://www.paypalobjects.com/en_US/i/btn/btn_buynow_LG.gif"
           alt="PayPal - The safer, easier way to pay online">
</form>



<!--  ***********CART TOTALS*************-->
            
<div class="col-xs-4 pull-right ">
<h2>Cart Totals</h2>

<table class="table table-bordered" cellspacing="0">

<tr class="cart-subtotal">
<th>Items:</th>
<td>
    <span class="amount">
      <!-- item_cantidad = all quantity of products -->
      <?php echo isset($_SESSION['item_cantidad'])?$_SESSION['item_cantidad']:
                      $_SESSION['item_cantidad']="0";?>
    </span>
</td>
</tr>
<tr class="shipping">
<th>Shipping and Handling</th>
<td>Free Shipping</td>
</tr>

<tr class="order-total">
<th>Order Total</th>
<td>
  <strong>
    <span class="amount">
        &#36;<?php echo isset($_SESSION['item_total'])?$_SESSION['item_total']:
                        $_SESSION['item_total']="0";?></span>
  </strong>
</td>
</tr>


</tbody>

</table>

</div><!-- CART TOTALS-->


 </div><!--Main Content-->

</div>
    <!-- /.container -->

<!-- Adding file footer.php -->
<?php require_once "includes/footer.php";?>