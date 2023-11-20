<?php
session_start();
include_once '../../../../clases/autoload.php';

$idTipoEje1       = (!empty($_POST["idTipoEje1"])) ? strip_tags($_POST["idTipoEje1"]) : 0;
$RecintoElectoral = new RecintoElectoral;
$rs               = $RecintoElectoral->getEjes1($idTipoEje1);
if (!empty($rs)) {
    $options = '<option value="">..SELECCIONE</option>';
    foreach ($rs as $key => $value) {
        $options .= '<option value="' . $value['idDgoTipoEje'] . '">' . $value['descripcion'] . '</option>';
    }
} else {
    $options = 0;
}
echo $options;
