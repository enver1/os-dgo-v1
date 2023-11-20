<?php
session_start();
header("content-type: application/json; charset=utf-8");
include_once '../../../clases/autoload.php';
include_once 'config.php';

$UnidadesDgscopApp = new UnidadesDgscopApp;
$respuesta    = $UnidadesDgscopApp->registrarUnidadesDgscopApp($_POST, $_FILES);
echo json_encode($respuesta);
