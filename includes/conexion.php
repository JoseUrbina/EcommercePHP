<?php

class Conectar
{
	/* Conexion a la base de datos */
	public static function conexion()
	{
		try
		{
			$conectar = new PDO("mysql:host=localhost;dbname=ecommerce","root","");
			$conectar->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$conectar->exec("SET CHARACTER SET utf8");

			return $conectar;
		}
		catch(Exception $e)
		{
			die("Error: {$e->getMessage()}");
		}
	}
}

// Try the class Conectar
 
/* if(Conectar::conexion())
	echo "Conectado";
else
	echo "Error en la conexion"; */

?>