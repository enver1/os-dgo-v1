<?php
session_start();
header("content-type: application/json; charset=utf-8");
include_once '../../../clases/autoload.php';

$TipoResumen = new TipoResumen();
$respuesta    = $TipoResumen->registrarTipoResumen($_POST);
echo json_encode($respuesta);
