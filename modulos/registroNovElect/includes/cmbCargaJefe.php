<?php
session_start();
include_once '../../../../clases/autoload.php';

$idDgoReciElect = (!empty($_POST["idDgoReciElect"])) ? strip_tags($_POST["idDgoReciElect"]) : 0;

$RegistroNovElec = new RegistroNovElec;
$rs              = $RegistroNovElec->getDetalleJefe($idDgoReciElect);
if (!empty($rs)) {
    $options = $rs['jefe_operativo'] . '|' . $rs['idDgoCreaOpReci'] . '|' . $rs['idDgoPerAsigOpe'];
} else {
    $options = "RECINTO CERRADO O NO SE ENCUENTRA ASIGNADO JEFE" . '|' . "" . '|' . "";
}

echo $options;
