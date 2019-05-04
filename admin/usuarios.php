<?php

    try
    {
        $usuario = new Usuarios();

        $datos = $usuario->get_usuarios();
    }
    catch(Exception $e)
    {
        die("Error: {$e->getMessage()}");
    }

?>

<div class="col-lg-12">
    <h1 class="page-header">
        Usuarios
    </h1>
      
    <a href="index.php?add_usuario" class="btn btn-primary">Añadir Usuario</a>

    <div class="col-md-12">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Usuario</th>
                    <th>Correo</th>
                    <th>Editar</th>
                    <th>Eliminar</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($datos as $user){?>

                <tr>
                    <td><?php echo $user["id_usuario"];?></td>
                    <td><?php echo $user["nombre"];?></td>
                    <td><?php echo $user["apellido"];?></td>
                    <td><?php echo $user["usuario"];?></td>
                    <td><?php echo $user["correo"];?></td>
                    <td>
                        <a href="index.php?edit_usuario&id_usuario=<?php echo $user['id_usuario'];?>" class="btn btn-success"><i class="fa fa-pencil"></i> Editar</a>
                    </td>
                    <td><a onClick="javascript:return confirm('¿Estas seguro que lo quieres eliminar?');" href="index.php?usuarios&eliminar=<?php echo $user["id_usuario"];?>" class="btn btn-danger"><i class="fa fa-trash"></i> Eliminar</a></td>
                </tr>

                <?php }?>
            </tbody>
        </table> <!--End of Table-->
    </div>  
</div>