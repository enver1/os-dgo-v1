<?php
session_start();
include_once '../../../../../clases/autoload.php';
$idDgoReciElect     = (!empty($_POST["idDgoReciElect"])) ? strip_tags($_POST["idDgoReciElect"]) : 0;
$idDgoProcElec      = (!empty($_POST["idDgoProcElec"])) ? strip_tags($_POST["idDgoProcElec"]) : 0;
$CrearOperativoReci = new CrearOperativoReci;
$rs                 = $CrearOperativoReci->getLatLong($idDgoReciElect, $idDgoProcElec);

foreach ($rs as $key => $value) {
    $options = $value['latitud'] . '|' . $value['longitud'] . '|' . $value['idDgoComisios'];
}

echo $options;
