<?php
session_start();
include_once '../../../../clases/autoload.php';
$idSenplades        = (!empty($_POST["idGenGeoSenplaades"])) ? strip_tags($_POST["idGenGeoSenplaades"]) : 0;
$idDgoProcElec      = (!empty($_POST["idDgoProcElec"])) ? strip_tags($_POST["idDgoProcElec"]) : 0;
$CrearOperativoReci = new CrearOperativoReci;
$rs                 = $CrearOperativoReci->getDetalleRecintos($idSenplades, $idDgoProcElec);
$options            = '<option value="">..SELECCIONE</option>';
foreach ($rs as $key => $value) {
    $options .= '<option value="' . $value['idDgoReciElect'] . '">' . $value['descripcion'] . '</option>';
}

echo $options;
