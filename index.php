    <!-- ** Adding conexio.php as a global way ** -->
    <?php require_once "includes/conexion.php";?>

    <!-- Adding Header -->
    <?php require_once "includes/header.php";?>

    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <!-- ** Adding Side Navigator ** -->
           <?php require_once "includes/side_nav.php";?>

            <div class="col-md-9">

                <div class="row carousel-holder">

                    <div class="col-md-12">
                        <?php require_once "includes/slider.php";?>
                    </div>

                </div>

                <div class="row">
                    <?php 
                        // List all products
                        try
                        {
                            $conectar = Conectar::conexion();

                            $sql = "SELECT * FROM productos";
                            $resultados = $conectar->prepare($sql);

                            if(!$resultados->execute())
                            {
                                echo "<h1 style='color:red'>Falla en la conexión</h1>";
                            }
                            else
                            {
                                while($row = $resultados->fetch(PDO::FETCH_ASSOC)){
                                    $id_producto = $row["id_producto"];
                                    $producto_titulo = $row["producto_titulo"];
                                    $producto_precio = $row["producto_precio"];
                                    $producto_imagen = $row["producto_imagen"]; 

                                    $descrip_corta = $row["descripcion_corta"];
                    ?>
                    
                    <div class="col-sm-4 col-lg-4 col-md-4">
                        <div class="thumbnail">
                            <a href="item.php?id_producto=<?php echo $id_producto;?>">
                                <!-- Show Product image : Video -->
                                <img height="150"  width="320"
                                     src='<?php echo "uploads/{$producto_imagen}";?>'>
                            </a>
                            
                            <div class="caption">
                                <h4 class="pull-right">&#36;<?php echo $producto_precio;?></h4>
                                <h4>
                                <a href="item.php?id_producto=<?php echo $id_producto;?>">
                                        <?php echo $producto_titulo;?>
                                    </a>
                                </h4>
                                <p>
                                    <?php echo substr($descrip_corta,
                                                      0, 50 );?>
                                </p>
                                <!-- agregar : contain the idProduct -->
                                <a class="btn btn-primary" target="_blank" 
                                href="carro.php?agregar=<?php echo $id_producto;?>">Agregar al Carro</a>
                            </div>                            
                        </div>
                    </div>

                    
                    <?php       
                                } 
                            }
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
            </div>
        </div>
    </div>
    <!-- /.container -->
    
    <!-- ** Adding footer ** -->
   <?php require_once "includes/footer.php";?>