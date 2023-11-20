<?php
session_start();
include_once '../../../clases/autoload.php';
include_once 'config.php';
$encriptar            = new Encriptar;
$formCerrarOperativo = new FormCerrarOperativos;
$hdrEvento           = new HdrEvento;
$opc         = strip_tags($_GET['opc']);
$idHdrEvento = strip_tags($encriptar->getDesencriptar($_GET['c'], $_SESSION['usuarioAuditar']));
$rowt        = array();
if ($idHdrEvento > 0) {
    $rowt = $hdrEvento->editCerrarOperativos($idHdrEvento);
}
$formCerrarOperativo->getFormCerrarOperativos($rowt, $hdrEvento->getIdCampo(), $opc);
