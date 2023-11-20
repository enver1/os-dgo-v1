<?php
session_start();
include '../../../clases/autoload.php';
include_once('config.php');
$transaccion = new Transaccion;

$id                   = strip_tags($_POST['id']);

if (!empty($id)) {
	$respuesta = $transaccion->borrar($tabla, $id);
} else {
	$respuesta = array(false, 'NO EXISTE DATOS A ELIMINAR');
}
echo json_encode($respuesta);
