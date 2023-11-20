<?php
session_start();
include_once '../../../clases/autoload.php';
$formMediosLogisticosOrden  = new FormMediosLogisticosOrden;
$mediosLogisticosOrden      = new MediosLogisticosOrden;
$encriptar       = new Encriptar;
$opc             = strip_tags($_GET['opc']);
$idDgoMediosLogisticos = strip_tags($encriptar->getDesencriptar($_GET['c'], $_SESSION['usuarioAuditar']));
$rowt            = array();

if ($idDgoMediosLogisticos > 0) {
    $rowt = $mediosLogisticosOrden->getEditMediosLogisticosOrden($idDgoMediosLogisticos);
}
$formMediosLogisticosOrden->getFormularioMediosLogisticosOrden($rowt, $mediosLogisticosOrden->getIdCampo(), $opc);
