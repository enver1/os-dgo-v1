<?php
session_start();
include_once '../../../clases/autoload.php';
include_once 'config.php';

$obj = new GenMarca();
$clsEncriptar       = new Encriptar;

$respuesta    = $obj->grabaRegistros($_POST);
echo json_encode($respuesta);