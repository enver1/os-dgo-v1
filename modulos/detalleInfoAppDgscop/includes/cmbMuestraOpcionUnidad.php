<?php
session_start();
include_once '../../../../clases/autoload.php';
$idDnaUnidadApp       = (!empty($_POST["idDnaUnidadApp"])) ? strip_tags($_POST["idDnaUnidadApp"]) : 0;
$DetalleInfoApp = new DetalleInfoAppDgscop;
$rs               = $DetalleInfoApp->getOpcionesUnidades($idDnaUnidadApp);
$options          = '<option value="">..SELECCIONE</option>';
foreach ($rs as $key => $value) {
    $options .= '<option value="' . $value['idDnaInfoApp'] . '">' . $value['nombreBoton'] . '</option>';
}

echo $options;