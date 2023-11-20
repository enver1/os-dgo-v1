<?php
session_start();

include_once '../../../../clases/autoload.php';

$idGenPersona = (!empty($_POST["idGenPersona"])) ? strip_tags($_POST["idGenPersona"]) : 0;

$RegistroNovElec = new RegistroNovElec;
$rs              = $RegistroNovElec->getDetalleDatosJefe($idGenPersona);
if (!empty($rs)) {
    $options = $rs['idDgoTipoEje'] . '|' . $rs['idDgoTipoEje1'] . '|' . $rs['idDgoTipoEje2'] . '|' . $rs['descProcElecc'] . '|' . $rs['jefe_operativo'] . '|' . $rs['nomt'] . '|' . $rs['nomt1'] . '|' . $rs['nomt2'] . '|' . $rs['idDgoCreaOpReci'] . '|' . $rs['nomRecintoElec'] . '|' . $rs['idDgoPerAsigOpe'] . '|' . $rs['latitud'] . '|' . $rs['longitud'];
} else {
    $options =  '|' . '|' . '|' . '|' . '|' .  '|' . '|' . '|' . '|' .  '|' . '|' . '|';
}

echo $options;
