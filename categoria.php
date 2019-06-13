<!-- Adding file conexion.php -->
<?php require_once "includes/conexion.php";?>
<!-- Adding file header.php -->
<?php require_once "includes/header.php";?>

<!-- Page Content -->
<div class="container">

    <!-- Jumbotron Header -->
    <!-- <header class="jumbotron hero-spacer">
        <h1>A Warm Welcome!</h1>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ipsa, ipsam, eligendi, in quo sunt possimus non incidunt odit vero aliquid similique quaerat nam nobis illo aspernatur vitae fugiat numquam repellat.</p>
        <p><a class="btn btn-primary btn-large">Call to action!</a>
        </p>
    </header> -->

    <hr>

    <!-- Title -->
    <div class="row">
        <div class="col-lg-12">
            <h3>Ultimos productos</h3>
        </div>
    </div>
    <!-- /.row -->

    <!-- Page Features -->
    <div class="row text-center">
<?php

    try
    {
        $conectar = Conectar::conexion();

        $sql = "SELECT * FROM productos WHERE producto_id_categoria = :idCategoria";
        $id_categoria = htmlentities(addslashes($_GET["id_categoria"]));

        $resultados = $conectar->prepare($sql);
        $resultados->bindValue(":idCategoria", $id_categoria);

        if(!$resultados->execute())
        {
            echo "<h1 style='color:red'>Falla en la consulta</h1>";
        }
        else
        {
            // Validate if query gets more than 0 record
            if($resultados->rowCount() > 0)
            {
                while($reg = $resultados->fetch(PDO::FETCH_ASSOC))
                {
                    $id_producto = $reg["id_producto"];
                    $producto_titulo = $reg["producto_titulo"];
                    $producto_imagen = $reg["producto_imagen"];

                    $descrip_corta = $reg["descripcion_corta"];
?>

        <div class="col-md-3 col-sm-6 hero-feature">
            <div class="thumbnail">
                <img src='<?php echo "uploads/{$producto_imagen}";?>'
                     alt="">
                <div class="caption">
                    <h3><?php echo $producto_titulo;?></h3>
                    <p>
                        <?php echo substr($descrip_corta, 0, 50);?>
                    </p>
                    <p>
                        <a href="carro.php?agregar=<?php 
                        echo $id_producto;?>" 
                        class="btn btn-primary">Agregar al carro</a> 
                        <!-- <a href="#" class="btn btn-default">More Info</a>-->
                    </p>
                </div>
            </div>
        </div>

<?php
                } // Close while
            }// Close validation
            else
            {
                echo "<h1 style='color:red'>La categoria no tiene productos</h1>";
            }
        } // Close else
    }
    catch(Exception $e)
    {
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
