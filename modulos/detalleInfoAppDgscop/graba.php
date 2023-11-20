<?php
session_start();
header("content-type: application/json; charset=utf-8");
include '../../../funciones/db_connect.inc.php';
include_once '../../../clases/autoload.php';
include_once 'config.php';

$DetalleInfoAppDgscop = new DetalleInfoAppDgscop;
//Cuando el usaurio selecciona y existe un  subMenu
//Se realiza la asigancion del idHijo al idPadre para el regsitro
if (isset($_POST['idDnaInfoAppHija'])) {
    $idDnaInfoAppHija = $_POST['idDnaInfoAppHija'];
    if ($idDnaInfoAppHija > 0) {
        $_POST['idDnaInfoApp'] = $idDnaInfoAppHija;
    }
}


$respuesta = $DetalleInfoAppDgscop->registrarDetalleInfoAppDgscop($_POST, $_FILES);

echo json_encode($respuesta);
