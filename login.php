<!-- Adding file conexion.php -->
<?php require_once "includes/conexion.php";?>
<!-- Adding file header.php -->
<?php require_once "includes/header.php";?>

<?
    if(isset($_POST['login']))
    {
        $correo = htmlentities(addslashes($_POST['correo']));
        $password = htmlentities(addslashes($_POST['password']));

        // Validate empty fields
        if(empty($correo) && empty($password))
        {
            echo "<h1 class='text-center text-danger bg-danger'>Empty fields in the form</h1>";
        }
        else
        {
            // Validating if the email exist in the database
            
            try
            {
                $conectar = Conectar::conexion();

                $sql = "SELECT * FROM usuarios WHERE correo = :correo";
                $resultado = $conectar->prepare($sql);
                $resultado->bindValue(':correo', $correo);

                // Validate if it exist an query error
                if(!$resultado->execute())
                {
                    echo "<h1 class='text-center text-danger bg-danger'>Failded query</h1>";
                }
                else
                {
                    // Validating if email exists in database
                    if($resultado->rowCount() > 0)
                    {
                        $reg = $resultado->fetch(PDO::FETCH_ASSOC);

                        $id_usuario = $reg['id_usuario'];
                        $usuario_bd = $reg['usuario'];
                        $password_bd = $reg['password'];
                        $nombre_bd = $reg['nombre'];
                        $correo_bd = $reg['correo'];

                        /* I validated if password are the same with the database */

                        if($password == $password_bd)
                        {
                            header('location:admin/index.php');
                        }
                        else
                        {
                            // If the email and passwrod are different against database
                            header('location:login.php');
                        }
                    }
                    else
                    {
                        // ** Email has not found in database **
                        echo "<h1 class='text-center text-danger bg-danger'>Email has not found in database</h1>";
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