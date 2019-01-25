<div class="col-md-12">
    <div class="row">
        <h1 class="page-header">
           Agregar Producto
        </h1>
    </div>               
</div>

<form action="" method="post" enctype="multipart/form-data">
    <div class="col-md-8">

        <div class="form-group">
            <label for="product-titulo">Producto Titulo </label>
            <input type="text" name="product_titulo" class="form-control">   
        </div>

        <div class="form-group">
            <label for="producto-descripcion">Product Descripción</label>
            <textarea name="producto_descripcion" id="" cols="30" rows="10" class="form-control">
            </textarea>
        </div>

        <div class="form-group row">
            <div class="col-xs-3">
                <label for="producto-precio">Producto Precio</label>
                <input type="number" name="producto_precio" class="form-control" size="60">
            </div>
        </div>

        <div class="form-group">
            <label for="descripcion_corta">Descripcion Corta</label>
            <textarea cols="30" rows="3" class="form-control" name="descripcion_corta"></textarea>
        </div>

    </div><!--Main Content-->

    <!-- SIDEBAR-->
    <aside id="admin_sidebar" class="col-md-4">
        <div class="form-group">
            <!--<input type="submit" name="draft" class="btn btn-warning btn-lg" value="Draft">-->
            <input type="submit" name="publicar" class="btn btn-primary btn-lg" value="Publicar">
        </div>

         <!-- Product Categories-->
        <div class="form-group">
            <label for="product-id_categoria">Product Categoria</label>
            <hr>
            <select name="product_id_categoria" id="" class="form-control">
                <option value="">Seleccione Categoria</option>
            </select>
        </div>

        <!-- Product Brands-->
        <div class="form-group">
            <label for="producto-cantidad">Product Cantidad</label>
            <input type="number" name="producto_cantidad">
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
        </div>
    </aside><!--SIDEBAR-->   
</form>