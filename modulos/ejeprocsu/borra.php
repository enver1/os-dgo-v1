<?php
session_start();
include '../../../clases/autoload.php';
include_once('config.php');
$transaccion = new Transaccion;
$encriptar            = new Encriptar;
$id                   = strip_tags($encriptar->getDesencriptar($_POST['id'], $_SESSION['usuarioAuditar']));

if (!empty($id)) {
	$respuesta = $transaccion->borrar($tabla, $id);
} else {
	$respuesta = array(false, 'NO EXISTE DATOS A ELIMINAR');
	//	echo json_encode($respuesta);
}
echo json_encode($respuesta);
