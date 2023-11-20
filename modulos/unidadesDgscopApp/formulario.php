<?php
session_start();
include_once '../../../clases/autoload.php';

$formUnidadesDgscopApp = new FormUnidadesDgscopApp;
$UnidadesDgscopApp     = new UnidadesDgscopApp;
$encriptar = new Encriptar;
$opc       = strip_tags($_GET['opc']);
$idDgiUnidadesDgscopApp  = strip_tags($encriptar->getDesencriptar($_GET['c'], $_SESSION['usuarioAuditar']));
$rowt      = array();

if ($idDgiUnidadesDgscopApp > 0) {
    $rowt = $UnidadesDgscopApp->getEditUnidadesDgscopApp($idDgiUnidadesDgscopApp);
}
$formUnidadesDgscopApp->getFormularioUnidadesDgscopApp($rowt, $UnidadesDgscopApp->getIdCampo(), $opc);
