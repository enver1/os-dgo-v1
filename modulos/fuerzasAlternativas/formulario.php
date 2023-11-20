<?php
session_start();
include_once '../../../clases/autoload.php';

$formFuerzasAlternativas  = new FormFuerzasAlternativas;
$fuerzasAlternativas      = new FuerzasAlternativas;
$encriptar       = new Encriptar;
$opc             = strip_tags($_GET['opc']);
$idDgoTipoFuerzasAlternativas = strip_tags($encriptar->getDesencriptar($_GET['c'], $_SESSION['usuarioAuditar']));
$rowt            = array();

if ($idDgoTipoFuerzasAlternativas > 0) {
    $rowt = $fuerzasAlternativas->getEditFuerzasAlternativas($idDgoTipoFuerzasAlternativas);
}
$formFuerzasAlternativas->getFormularioFuerzasAlternativas($rowt, $fuerzasAlternativas->getIdCampo(), $opc);
