<?php
session_start();
include_once '../../../clases/autoload.php';

$FormCrearOperativoReci  = new FormCrearOperativoReci;
$CrearOperativoReci      = new CrearOperativoReci;
$encriptar       = new Encriptar;
$opc             = strip_tags($_GET['opc']);
$idDgiCrearOperativoReci = strip_tags($encriptar->getDesencriptar($_GET['c'], $_SESSION['usuarioAuditar']));
$rowt            = array();

if ($idDgiCrearOperativoReci > 0) {
    $rowt = $CrearOperativoReci->getEditCrearOperativoReci($idDgiCrearOperativoReci);
}
$FormCrearOperativoReci->getFormularioCerrarOperativoReci($rowt, $CrearOperativoReci->getIdCampoCrearOperativoReci(), $opc);
