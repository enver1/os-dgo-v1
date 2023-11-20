<?php
session_start();
header("content-type: application/json; charset=utf-8");
include 'config.php';
include_once '../../../../clases/autoload.php';

$Comisios  = new Comisios;
$respuesta = $Comisios->registrarComisios($_POST);
echo json_encode($respuesta);
