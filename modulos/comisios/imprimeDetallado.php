<?php
session_start();
include_once '../../../funciones/funcion_select.php';
include '../../../funciones/db_connect.inc.php';
include_once '../../../clases/autoload.php';
$ActualizaRecintos = new ActualizaRecintos;
$respuesta = $ActualizaRecintos->actualizarec($conn);
echo json_encode($respuesta);
