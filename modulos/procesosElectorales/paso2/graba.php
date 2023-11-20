<?php
header("content-type: application/json; charset=utf-8");
session_start();

include_once '../../../../clases/autoload.php';
$seleccionados = $_GET['sele'];
$isRecinto     = $_GET['isRecinto'];

$Comisios      = new Comisios;
$respuesta     = $Comisios->registrarComisiosProceso($_POST, $seleccionados, $isRecinto);
$mensaje = array(false, $respuesta[1], 0);
echo json_encode($mensaje);
