<!-- Adding file conexion.php -->
<?php require_once "includes/conexion.php";?>
<!-- Adding file header.php -->
<?php require_once "includes/header.php";?>
<!-- Adding file admin/Modelos/Usuarios.php -->
<?php require_once "admin/Modelos/Usuarios.php";?>

<?
    if(isset($_POST['login']))
    {
        $correo = htmlentities(addslashes($_POST['correo']));
        $password = htmlentities(addslashes($_POST['password']));

        try
        {
            // New instance usuarios.
            $usuarios = new Usuarios();
            $usuarios->Login($correo, $password);
        }
        catch(Exception $e)
        {
            die("Error: {$e->getMessage()}");
        }
    }
?>

<?php
    if(isset($_GET["m"]))
    {
        switch($_GET["m"])
        {
            case 1:
?>
    <h2 class="text-success text-center">
        Se ha reseteado la contraseña satisfactoriamente, ahora puede loguearse con la nueva contraseña
    </h2>
<?php
                break;
        }
    }
?>

    <!-- Page Content -->
    <div class="container">

      <header>
        <h1 class="text-center">Login</h1>
        <div class="col-sm-4 col-sm-offset-5">         
            <form class="" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
                <div class="form-group"><label for="">
                    Correo<input type="text" name="correo" class="form-control"></label>
                </div>
                 <div class="form-group"><label for="password">
                    Password<input type="password" name="password" class="form-control"></label>
                </div>

                <div class="form-group">
                  <input type="submit" name="login" class="btn btn-primary" >
                </div>
                <div class="form-group">
                    <a href="recuperar_password.php">¿Olvido su contraseña?</a>
                </div>
            </form>
        </div>  


    </header>
    </div>
    <!-- /.container -->

<!-- Adding file footer.php -->
<?php require_once "includes/footer.php";?>