<?php
session_start();
include_once '../../../../../clases/autoload.php';
$idDgoTipoEje       = (!empty($_POST["idDgoTipoEje"])) ? strip_tags($_POST["idDgoTipoEje"]) : 0;
$idDgoProcElec      = (!empty($_POST["idDgoProcElec"])) ? strip_tags($_POST["idDgoProcElec"]) : 0;
$CrearOperativoReci = new CrearOperativoReci;
$rs                 = $CrearOperativoReci->getDetalleRecintosPorEje($idDgoTipoEje, $idDgoProcElec);
$options            = '<option value="">..SELECCIONE</option>';
foreach ($rs as $key => $value) {
    $options .= '<option value="' . $value['idDgoReciElect'] . '">' . $value['descripcion'] . '</option>';
}

echo $options;
