<?php
session_start();
include_once '../../../../../clases/autoload.php';
$idGenTipoOperativo       = (!empty($_POST["idGenTipoOperativo"])) ? strip_tags($_POST["idGenTipoOperativo"]) : 0;
$crearOrdenServicio = new CrearOrdenServicio;
$rs               = $crearOrdenServicio->getTipoOperativo($idGenTipoOperativo);
$options          = '<option value="">SELECCIONE...</option>';
foreach ($rs as $key => $value) {
    $options .= '<option value="' . $value['idGenTipoOperativo'] . '">' . $value['descripcion'] . '</option>';
}
echo $options;
