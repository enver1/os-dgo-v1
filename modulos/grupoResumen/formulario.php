<?php
include_once '../../../funciones/db_connect.inc.php';
include_once '../../../clases/autoload.php';

$formGrupoResumen = new FormGrupoResumen;
$GrupoResumen     = new GrupoResumen;
$encriptar        = new Encriptar;
$dt               = new DateTime('now', new DateTimeZone('America/Guayaquil'));
$fechaHoy         = $dt->format('Y-m-d');
$opc              = strip_tags($_GET['opc']);
$idHdrGrupResum   = strip_tags($encriptar->getDesencriptar($_GET['c'], $_SESSION['usuarioAuditar']));
$rowt             = array();

if ($idHdrGrupResum > 0) {
    $rowt = $GrupoResumen->getEditGrupoResumen($idHdrGrupResum);
}
$formGrupoResumen->getFormularioGrupoResumen($rowt, $GrupoResumen->getIdCampoGrupoResumen(), $opc);
