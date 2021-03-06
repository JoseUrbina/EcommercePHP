<!-- Start session and storing in buffer-->
<?php ob_start();?>
<?php session_start();?>

<!-- It must be commented because we added products to checkout.php,
     we discommented for wiping out the SESSION and then clear the products
     which have added to checkout.php
-->

<?php //session_destroy();?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Ecommerce - Home</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/shop-homepage.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>

<body>

    <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php">Home</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li>
                        <a href="tienda.php">Tienda</a>
                    </li>
                    <li>
                        <?php 

                            // if it exists the SESSION, 
                            // show us up the ADMIN choice
                            if(isset($_SESSION["usuario"])){
                        ?>
                        
                            <a href="admin">Admin</a>

                        <?php }else{?>

                            <a href="login.php">Login</a>
                        
                        <?php }?>
                    </li>

                    <?php

                        // if it exists the SESSION, show us up the ADMIN choice
                        /*if(isset($_SESSION["usuario"]))
                        {
                            echo "<li>
                                    <a href='admin'>Admin</a>
                                  </li>";
                        }*/

                    ?>

                     <li>
                        <a href="checkout.php">Checkout</a>
                    </li>
                    <li>
                        <a href="contacto.php">Contacto</a>
                    </li>

                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>