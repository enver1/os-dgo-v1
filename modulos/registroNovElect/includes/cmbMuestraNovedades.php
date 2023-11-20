<?php
session_start();
include_once '../../../../clases/autoload.php';

$idDgoNovedadesElect = (!empty($_POST["idDgoNovedadesElect"])) ? strip_tags($_POST["idDgoNovedadesElect"]) : 0;
$id = (!empty($_POST["id"])) ? strip_tags($_POST["id"]) : 0;
$RegistroNovElec = new RegistroNovElec;
$rs              = $RegistroNovElec->getDetalleNovedades($idDgoNovedadesElect, $id);

$options = '<option value="">..Seleccione</option>';
foreach ($rs as $key => $value) {
    $options .= '<option value="' . $value['idDgoNovedadesElect'] . '">' . $value['descripcion'] . '</option>';
}

echo $options;
