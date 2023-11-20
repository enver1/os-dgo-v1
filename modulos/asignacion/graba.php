<?php
session_start();
header("content-type: application/json; charset=utf-8");
include_once '../../../clases/autoload.php';
include_once 'config.php';
$asignacion = new Asignacion;

$respuesta = $asignacion->registrarAsignacion($_POST, $_FILES, $formulario);

echo json_encode($respuesta);
