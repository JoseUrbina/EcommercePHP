<!-- Adding file conexion.php -->
<?php require_once "includes/conexion.php";?>
<!-- Adding file header.php -->
<?php require_once "includes/header.php";?>


<!-- Page Content -->
<div class="container">

    <!-- Jumbotron Header -->
    <header>
        <h1>Tienda</h1>
    </header>

    <hr>

    <!-- Page Features -->
    <div class="row text-center">
<?php
    try
    {
        $conectar = Conectar::conexion();
        
        $sql = "SELECT * FROM productos";
        $resultados = $conectar->prepare($sql);

        if(!$resultados->execute())
        {
            echo "<h1 style='color:red;'>Failed query</h1>";
        }
        else
        {
            if($resultados->rowCount() > 0)
            {
                while($reg = $resultados->fetch(PDO::FETCH_ASSOC)){
                    $id_producto = $reg["id_producto"];
                    $producto_titulo = $reg["producto_titulo"];
                    $producto_imagen = $reg["producto_imagen"]; 

                    // --> ** Pendient its use in the interface
                    $descripcion_corta = $reg["descripcion_corta"];             
?>

        <div class="col-md-3 col-sm-6 hero-feature">
            <div class="thumbnail">
                <img src="<?php echo $producto_imagen;?>" alt="">
                <div class="caption">
                    <h3><?php echo $producto_titulo;?></h3>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
                    <p>
                        <a href="item.php?id_producto=<?php echo $id_producto;?>" class="btn btn-primary">Buy Now!</a> <a href="#" class="btn btn-default">More Info</a>
                    </p>
                </div>
            </div>
        </div>

<?php

                } // Cierre While
            } // Cierra if conditional
            else
            {
                echo "<h1 style='color:red;'>Doesn't exist any product</h1>";
            }
        }// Cierre else first if conditional
    }
    catch(Exception $e){
        die("Error: {$e->getMessage()}");
    }
    finally{
        $conectar = null;
    }       
?>

    </div>
    <!-- /.row -->

    <hr

</div>
<!-- /.container -->

<?php require_once "includes/footer.php";?>