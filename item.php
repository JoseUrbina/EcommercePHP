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
        $id_producto = htmlentities(addslashes($_GET["id_producto"]));

        $resultados = $conectar->prepare($sql);
        $resultados->bindValue(":idPro", $id_producto);

        if(!$resultados->execute()){
            echo "<h1 style='color:red'>Failed conection</h1>";
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
       <img class="img-responsive" src="<?php echo $producto_imagen;?>" alt="">

    </div>

    <div class="col-md-5">

        <div class="thumbnail">
         

    <div class="caption-full">
        <h4><a href="#"><?php echo $producto_titulo;?></a> </h4>
        <hr>
        <h4 class="">&#36;<?php echo $producto_precio;?></h4>

    <div class="ratings">
     
        <p>
            <span class="glyphicon glyphicon-star"></span>
            <span class="glyphicon glyphicon-star"></span>
            <span class="glyphicon glyphicon-star"></span>
            <span class="glyphicon glyphicon-star"></span>
            <span class="glyphicon glyphicon-star-empty"></span>
            4.0 stars
        </p>
    </div>
          
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
    <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Reviews</a></li>

  </ul>

  <!-- Tab panes -->
  <div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="home">

        <p><?php echo $producto_descripcion;?></p>

    </div>
    <div role="tabpanel" class="tab-pane" id="profile">

  <div class="col-md-6">

       <h3>2 Reviews From </h3>

        <hr>

        <div class="row">
            <div class="col-md-12">
                <span class="glyphicon glyphicon-star"></span>
                <span class="glyphicon glyphicon-star"></span>
                <span class="glyphicon glyphicon-star"></span>
                <span class="glyphicon glyphicon-star"></span>
                <span class="glyphicon glyphicon-star-empty"></span>
                Anonymous
                <span class="pull-right">10 days ago</span>
                <p>This product was great in terms of quality. I would definitely buy another!</p>
            </div>
        </div>

        <hr>

        <div class="row">
            <div class="col-md-12">
                <span class="glyphicon glyphicon-star"></span>
                <span class="glyphicon glyphicon-star"></span>
                <span class="glyphicon glyphicon-star"></span>
                <span class="glyphicon glyphicon-star"></span>
                <span class="glyphicon glyphicon-star-empty"></span>
                Anonymous
                <span class="pull-right">12 days ago</span>
                <p>I've alredy ordered another one!</p>
            </div>
        </div>

        <hr>

        <div class="row">
            <div class="col-md-12">
                <span class="glyphicon glyphicon-star"></span>
                <span class="glyphicon glyphicon-star"></span>
                <span class="glyphicon glyphicon-star"></span>
                <span class="glyphicon glyphicon-star"></span>
                <span class="glyphicon glyphicon-star-empty"></span>
                Anonymous
                <span class="pull-right">15 days ago</span>
                <p>I've seen some better than this, but not at this price. I definitely recommend this item.</p>
            </div>
        </div>

    </div>


    <div class="col-md-6">
        <h3>Add A review</h3>

     <form action="" class="form-inline">
        <div class="form-group">
            <label for="">Name</label>
                <input type="text" class="form-control" >
            </div>
             <div class="form-group">
            <label for="">Email</label>
                <input type="test" class="form-control">
            </div>

        <div>
            <h3>Your Rating</h3>
            <span class="glyphicon glyphicon-star"></span>
            <span class="glyphicon glyphicon-star"></span>
            <span class="glyphicon glyphicon-star"></span>
            <span class="glyphicon glyphicon-star"></span>
        </div>

            <br>
            
             <div class="form-group">
             <textarea name="" id="" cols="60" rows="10" class="form-control"></textarea>
            </div>

             <br>
              <br>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="SUBMIT">
            </div>
        </form>

    </div>

 </div>

 </div>

</div>


</div><!--Row for Tab Panel-->




</div>

<?php
            } // Cierre validación if
            else{
                echo "<h1 style='color:red'>There was not asocciate record</h1>";
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
    <!-- /.container -->

<!-- ** Adding file footer.php ** -->
<?php require_once "includes/footer.php";?>