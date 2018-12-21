<!-- Adding file conexion.php -->
<?php require_once "includes/conexion.php";?>
<!-- Adding file header.php -->
<?php require_once "includes/header.php";?>

<?php
    if(isset($_POST['submit']))
    {
        if(empty($_POST['nombre']) && empty($_POST['email']) 
            && empty($_POST['titulo']) && empty($_POST['mensaje']))
        {
            echo "<h2 class='text-center text-danger'>Los campos estan vacíos.</h2>";
        }
        else if(empty($_POST['nombre']) || empty($_POST['email']) 
            || empty($_POST['titulo']) || empty($_POST['mensaje'])){
            echo "<h2 class='text-center text-danger'>Los campos estan vacíos.</h2>";
        }
        else
        {
            $to = "joseantonioug.99@gmail.com";
            $asunto = wordwrap($_POST['titulo'], 70);
            $cuerpo = $_POST['mensaje'];

            // Para el envío en formato html
            $cabecera = "MIME-Version: 1.0\r\n";
            $cabecera .= "Content-type: text-html;charset=iso-8859-1\r\n";
            $cabecera .= " From: " . $_POST['email'];

            // send email
            
            if(mail($to, $asunto, $cuerpo, $cabecera))
            {
                echo "<h2 class='text-danger text-center'>Se ha enviado el comentario satifactoriamente</h2>";
            }
            else
            {
                echo "<h2 class='text-danger text-center'>No se envio el correo</h2>";
            }
        }
    }
?>

         <!-- Contact Section -->

        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2 class="section-heading">Contacto</h2>
                    <h3 class="section-subheading text-muted"></h3>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <form method="post" name="sentMessage" id="contactForm" >
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="text" name="nombre" class="form-control" placeholder="Nombre *" id="nombre" required data-validation-required-message="Ingrese el nombre">
                                    <p class="help-block text-danger"></p>
                                </div>
                                <div class="form-group">
                                    <input type="email" class="form-control" name="email" placeholder="Email *" id="email" required data-validation-required-message="Ingrese su correo">
                                    <p class="help-block text-danger"></p>
                                </div>
                                <div class="form-group">
                                    <input type="tel" class="form-control" name="titulo" placeholder="Titulo *" id="titulo" required data-validation-required-message="Escriba su titulo.">
                                    <p class="help-block text-danger"></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <textarea name="mensaje" class="form-control" placeholder="Mensaje *" id="mensaje" required data-validation-required-message="Escriba su mensaje."></textarea>
                                    <p class="help-block text-danger"></p>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="col-lg-12 text-center">
                                <div id="success"></div>
                                <button type="submit" name="submit" class="btn btn-primary btn-xl">Enviar mensaje</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
    <!-- /.container -->

<?php require_once "includes/footer.php";?>