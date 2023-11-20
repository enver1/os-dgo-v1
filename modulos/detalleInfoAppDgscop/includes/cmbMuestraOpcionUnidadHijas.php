<?php
session_start();
include_once '../../../../clases/autoload.php';


//$idDnaUnidadApp       = (!empty($_POST["idDnaUnidadApp"])) ? strip_tags($_POST["idDnaUnidadApp"]) : 0;
$dna_IdDnaInfoApp       = (!empty($_POST["dna_IdDnaInfoApp"])) ? strip_tags($_POST["dna_IdDnaInfoApp"]) : 0;
$DetalleInfoApp = new DetalleInfoAppDgscop;
$rs               = $DetalleInfoApp->getOpcionesUnidadesHijas($dna_IdDnaInfoApp);
$options          = '<option value="">..SELECCIONE</option>';
foreach ($rs as $key => $value) {
    $options .= '<option value="' . $value['idDnaInfoApp'] . '">' . $value['nombreBoton'] . '</option>';
}
echo $options;