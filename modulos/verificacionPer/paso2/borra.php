<?php
session_start();
header("content-type: application/json; charset=utf-8");
include_once '../../../../clases/autoload.php';
$AsignaPersonalElec = new AsignaPersonalElec;
$encriptar          = new Encriptar;
$idDgoPerAsigOpe    = strip_tags($encriptar->getDesencriptar($_POST['id'], $_SESSION['usuarioAuditar']));

$respuesta = $AsignaPersonalElec->eliminarAsignaPersonalElec($idDgoPerAsigOpe);
echo json_encode($respuesta);
