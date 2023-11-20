<?php
session_start();
include_once '../../../clases/autoload.php';
$formDgoTipoEvaluacionInf  = new FormDgoTipoEvaluacionInf;
$dgoTipoEvaluacionInf      = new DgoTipoEvaluacionInf;
$encriptar       = new Encriptar;
$opc             = strip_tags($_GET['opc']);
$idDgoTipoEvaluacionInf = strip_tags($encriptar->getDesencriptar($_GET['c'], $_SESSION['usuarioAuditar']));
$rowt            = array();

if ($idDgoTipoEvaluacionInf > 0) {
    $rowt = $dgoTipoEvaluacionInf->getEditDgoTipoEvaluacionInf($idDgoTipoEvaluacionInf);
}
$formDgoTipoEvaluacionInf->getFormularioDgoTipoEvaluacionInf($rowt, $dgoTipoEvaluacionInf->getIdCampo(), $opc);
