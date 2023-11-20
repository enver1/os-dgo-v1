<?php
session_start();
include_once '../../../clases/autoload.php';

$formClasificacionOrden  = new FormClasificacionOrden;
$clasificacionOrden      = new ClasificacionOrden;
$encriptar       = new Encriptar;
$opc             = strip_tags($_GET['opc']);
$idDgiClasificacionOrden = strip_tags($encriptar->getDesencriptar($_GET['c'], $_SESSION['usuarioAuditar']));
$rowt            = array();

if ($idDgiClasificacionOrden > 0) {
    $rowt = $clasificacionOrden->getEditClasificacionOrden($idDgiClasificacionOrden);
}
$formClasificacionOrden->getFormularioClasificacionOrden($rowt, $clasificacionOrden->getIdCampo(), $opc);
