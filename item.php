<!-- Adding conexion -->
<?php require_once "includes/conexion.php";?>
<!-- Adding file header.php -->
<?php require_once "includes/header.php";?>

    <!-- Page Content -->
<div class="container">

       <!-- Adding file side_nav.php -->
        <?php require_once "includes/side_nav.php";?>
        
<?php
    
    try
    {
        $conectar = Conectar::conexion();

        $sql = "SELECT * FROM productos WHERE id_producto = :idPro";
        $id_producto =htmlentities(addslashes($_GET["id_producto"]));

        $resultados = $conectar->prepare($sql);
        $resultados->bindValue(":idPro", $id_producto);

        if(!$resultados->execute()){
            echo "<h1 style='color:red'>Falla en la consulta</h1>";
        }
        else
        {
            // Validate if exist more than 0 record
            if($resultados->rowCount() > 0)
            {
                // it can do in this way or with a while cicle
                $reg = $resultados->fetch(PDO::FETCH_ASSOC);

                $producto_titulo = $reg["producto_titulo"];
                $producto_precio = $reg["producto_precio"];
                $producto_descripcion = $reg["producto_descripcion"];
                $descripcion_corta = $reg["descripcion_corta"];
                $producto_imagen = $reg["producto_imagen"];
                     
?>

<div class="col-md-9">

<!--Row For Image and Short Description-->

<div class="row">

    <div class="col-md-7">
       <img class="img-responsive" src="<?php echo "uploads/" . 
       $producto_imagen;?>" alt="">

    </div>

    <div class="col-md-5">

        <div class="thumbnail">
         

    <div class="caption-full">
        <h4 class="text-primary"><?php echo $producto_titulo;?></h4>
        <hr>
        <h4 class="">&#36;<?php echo $producto_precio;?></h4>
          
        <p><?php echo $descripcion_corta;?></p>

   
    <form action="">
        <div class="form-group">
            <!-- Button for adding a new product to checkout.php -->
            <a href="carro.php?agregar=<?php echo $id_producto;?>" class="btn btn-primary">
            Agregar al carro</a>
        </div>
    </form>

    </div>
 
</div>

</div>


</div><!--Row For Image and Short Description-->

<hr>

<!--Row for Tab Panel-->
<div class="row">

<div role="tabpanel">

  <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Description</a></li>
  </ul>

  <!-- Tab panes -->
  <div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="home">

        <p><?php echo $producto_descripcion;?></p>

    </div>
  </div>
        </div>
    </div>
</div><!--Row for Tab Panel-->

<?php
            } // Cierre validación if
            else{
                echo "<h1 style='color:red'>No hay registros asociados</h1>";
            }
        }   // Cierre else
    } // Cierre try
    catch(Exception $e)
    {
        die("Error: {$e->getMessage()}");
    }
    finally{
        $conectar = null;
    }
?>

</div>
<!--     /.container -->

<!-- ** Adding file footer.php ** -->
<?php require_once "includes/footer.php";?>