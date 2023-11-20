<?php
include_once '../../../funciones/db_connect.inc.php';
include_once '../../../clases/autoload.php';

$formTipoServicioOp = new FormTipoServicioOp;
$TipoServicioOp     = new TipoServicioOp;
$encriptar          = new Encriptar;
$dt                 = new DateTime('now', new DateTimeZone('America/Guayaquil'));
$fechaHoy           = $dt->format('Y-m-d');
$opc                = strip_tags($_GET['opc']);
$idHdrTipoServicio  = strip_tags($encriptar->getDesencriptar($_GET['c'], $_SESSION['usuarioAuditar']));
$rowt               = array();

if ($idHdrTipoServicio > 0) {
    $rowt = $TipoServicioOp->getEditTipoServicioOp($idHdrTipoServicio);
}
$formTipoServicioOp->getFormularioTipoServicioOp($rowt, $TipoServicioOp->getIdCampoTipoServicioOp(), $opc);
