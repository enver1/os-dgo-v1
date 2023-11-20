<?php

session_start();
include_once('../../../clases/autoload.php');
include_once('config.php');

$transaccion = new Transaccion;

if (empty($_POST[$idcampo])) {
	$respuesta = $transaccion->insert($tabla, $tStructure, $_POST, $descripcion);
} else {
	$conDupli  =  " and " . $idcampo . " != " . $_POST[$idcampo];
	$respuesta = $transaccion->update($tabla, $tStructure, $_POST, $descripcion, $conDupli);
}

echo json_encode($respuesta[1]);
