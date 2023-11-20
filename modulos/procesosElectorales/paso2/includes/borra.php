<?php

if (file_exists(dirname(dirname(dirname(dirname(__DIR__))))."/clases/controlador/claseDB.php")) {
    include_once dirname(dirname(dirname(dirname(__DIR__)))).'/clases/autoload.php';
    include_once dirname(dirname(dirname(dirname(__DIR__)))).'/funciones/db_connect.inc.php';
    $obj=true;	
}
else {
    include_once dirname(dirname(dirname(dirname(__DIR__)))).'/funciones/db_connect.inc.php';
    include_once dirname(dirname(dirname(dirname(__DIR__)))).'/clases/autoload.php';
    $obj=false;
}


$tabla='genUsuarioAplicacion';
$idcampo=ucfirst($tabla);

if($obj) $encriptar = new Encriptar;

	foreach ($_POST as $campo=>$valor)
	{
		if($obj) $campo = strip_tags($encriptar->getDesencriptar($campo, $_SESSION['usuarioAuditar']));
		delete($conn,$campo,$tabla);
	}
?>