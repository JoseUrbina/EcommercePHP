<!-- File admin_header.php contains the file conexion.php-->
<!-- Adding file admin_header.php -->
<?php require_once "includes/admin_header.php";?>

<!-- Adding file Pedidos.php -->
<?php require_once "Modelos/Pedidos.php";?>

<!-- Adding file Productos.php -->
<?php require_once "Modelos/Productos.php";?>

<!-- Adding file Categorias.php-->
<?php require_once "Modelos/Categorias.php";?>

        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Dashboard <small>Statistics Overview</small>
                        </h1>
                        <ol class="breadcrumb">
                            <li class="active">
                                <i class="fa fa-dashboard"></i> Dashboard
                            </li>
                        </ol>
                    </div>
                </div>
                <!-- /.row -->

                <?php

                    // GETTING URL WITHOUT localhost/
                    $url = $_SERVER["REQUEST_URI"];

                    // Condition: with and without index.php from admin page index
                   if($url == "/EccomercePHP/admin/" || $url == "/EccomercePHP/admin/index.php")
                    {
                        require_once "includes/admin_contenido.php";
                    }

                    // if it exists this variable, call pedidos.php
                    if(isset($_GET['pedidos']))
                    {
                        require_once "pedidos.php";
                    }

                    // if it exists this variable, call productos.php
                    if(isset($_GET["productos"]))
                    {
                        require_once "productos.php";
                    }

                    // if it exists this variable, call categorias.php
                    if(isset($_GET["categorias"]))
                    {
                        require_once "categorias.php";
                    }

                    // if it exists this variable, call add_producto.php
                    if(isset($_GET["add_producto"]))
                    {
                        require_once "add_producto.php";
                    }
                ?>
            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

<!-- Adding file admin_footer.php -->
<?php require_once "includes/admin_footer.php";?>