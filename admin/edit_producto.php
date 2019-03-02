<?php
    try
    {
        $producto = new Productos();

        $categoria = new Categorias();

        $listar_categorias = $categoria->get_categorias();

        if(isset($_GET["editar"]))
        {
            $id_producto = $_GET["editar"];

            $datos = $producto->get_producto_por_id($id_producto);
        }

        // Conditional to edit a product
        if(isset($_POST["editar_producto"]))
        {
            $producto->editar_producto();
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
           Editar Producto
        </h1>
        
        <!-- Area: Show messages -->
        <?php
            if(isset($_GET["m"]))
            {
                switch($_GET["m"])
                {
                    case 1:
        ?>
                        <h1 class="text-danger bg-danger">Los campos estan vacíos</h1>
        <?php
                        break;
                    case 2:
        ?>
                        <h1 class="text-danger bg-danger">Falla en la consulta</h1>
        <?php
                        break;
                    case 3:
        ?>
                        <h1 class="text-success bg-success">Se edito el producto</h1>
        <?php
                        break;
                    case 4:
        ?>
                        <h1 class="bg-danger text-danger">No se edito el producto</h1>
        <?php
                        break;
                }
            }
        ?>
    </div>               
</div>

<form action="" method="post" enctype="multipart/form-data">
    <div class="col-md-8">
        <!-- Store the id_producto for sending it -->
        <input type="hidden" name="id_producto" 
               value="<?php echo $datos[0]['id_producto']?>">

        <div class="form-group">
            <label for="producto-titulo">Producto Titulo </label>
            <input type="text" name="producto_titulo" class="form-control"
                   value="<?php echo $datos[0]['producto_titulo']?>">   
        </div>

        <div class="form-group">
            <label for="producto-descripcion">Producto Descripción</label>
            <textarea name="producto_descripcion" id="" cols="30" rows="10" class="form-control"><?php echo $datos[0]["producto_descripcion"];?></textarea>
        </div>

        <div class="form-group row">
            <div class="col-xs-3">
                <label for="producto-precio">Producto Precio</label>
                <input type="number" name="producto_precio" class="form-control" size="60" value="<?php echo $datos[0]['producto_precio'];?>">
            </div>
        </div>

        <div class="form-group">
            <label for="descripcion_corta">Descripcion Corta</label>
            <textarea name="descripcion_corta" cols="30" rows="3" class="form-control"><?php echo $datos[0]["descripcion_corta"];?></textarea>
        </div>

    </div><!--Main Content-->

    <!-- SIDEBAR-->
    <aside id="admin_sidebar" class="col-md-4">
        <div class="form-group">
            <!--<input type="submit" name="draft" class="btn btn-warning btn-lg" value="Draft">-->
            <input type="submit" name="editar_producto" class="btn btn-primary btn-lg" value="Editar Producto">
        </div>

        <hr>

         <!-- Product Categories-->
        <div class="form-group">
            <label for="producto-id_categoria">Producto Categoria</label>
            <select name="producto_id_categoria" id="" class="form-control">
                <!-- <option value="<?php echo $datos[0]['producto_id_categoria'];?>">
                    <?php echo $producto->mostrar_categoria_titulo($datos[0]['producto_id_categoria']);?>
                </option> -->

            <?php
                for($i=0;$i<count($listar_categorias);$i++){
                    echo "<option value='".$listar_categorias[$i]['id_categoria']."' ".
                          (($datos[0]['producto_id_categoria'] == $listar_categorias[$i]['id_categoria'])?'selected':'') .">
                          {$listar_categorias[$i]['cat_titulo']}</option>";
                }
            ?>
            </select>
        </div>

        <!-- Product Brands-->
        <div class="form-group">
            <label for="producto-cantidad">Producto Cantidad</label>
            <input type="number" name="producto_cantidad" 
                   value="<?php echo $datos[0]['producto_cantidad'];?>">
        </div>

        <!-- Product Tags 
        <div class="form-group">
            <label for="product-title">Product Keywords</label>
            <hr>
            <input type="text" name="product_tags" class="form-control">
        </div> -->

        <!-- Product Image -->
        <div class="form-group">
            <label for="producto-imagen">Producto Imagen</label>
            <input type="file" name="producto_imagen">
            <hr>
            <img width="200" src="../uploads/<?php echo $datos[0]['producto_imagen'];?>">
        </div>
    
        <!-- 
            Campo que almacena el valor de la imagen que se encuentra en la BD,
            utilizado en caso de que el input file sea vacío
        -->
        <input type="hidden" name="archivo" 
               value="<?php echo $datos[0]['producto_imagen'];?>">
    </aside><!--SIDEBAR-->   
</form>