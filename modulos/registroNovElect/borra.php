<?php
session_start();
header("content-type: application/json; charset=utf-8");
include_once '../../../clases/autoload.php';
$RegistroNovElec  = new RegistroNovElec;
$encriptar        = new Encriptar;
$idDgoNovReciElec = strip_tags($encriptar->getDesencriptar($_POST['id'], $_SESSION['usuarioAuditar']));
$respuesta = $RegistroNovElec->eliminarRegistroNovElec($idDgoNovReciElec);
echo json_encode($respuesta);
