<?php
session_start();
header("content-type: application/json; charset=utf-8");
include_once '../../../clases/autoload.php';

$TipoTipificacion = new TipoTipificacion();
$respuesta    = $TipoTipificacion->registrarTipoTipificacion($_POST);
echo json_encode($respuesta);
