<?php
session_start();
include_once '../../../../clases/autoload.php';
$idCgTipoAspecto       = (!empty($_POST["idCgTipoAspecto"])) ? strip_tags($_POST["idCgTipoAspecto"]) : 0;
$RegistroAspectoAppCg = new RegistroAspectoAppCg;
$rs               = $RegistroAspectoAppCg->getTipoAspecto($idCgTipoAspecto);
$options          = '<option value="">SELECCIONE...</option>';
foreach ($rs as $key => $value) {
    $options .= '<option value="' . $value['idCgTipoAspecto'] . '">' . $value['descripcion'] . '</option>';
}
echo $options;
