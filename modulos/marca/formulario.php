<?php
session_start();
include_once 'config.php';
include_once '../../../clases/autoload.php';

$formGenMarca    = new GenMarcaForm();
$obj  = new GenMarca();
$encriptar              = new Encriptar;

$opc  = $_GET['opc'];
$rowt = array();

$id = strip_tags($encriptar->getDesencriptar($_GET['c'], $_SESSION['usuarioAuditar']));

if ($id > 0) {
	$rowt = $obj->getGenMarcaPorId($id);
}
$formGenMarca->getFormGenMarca($rowt, $obj->getIdCampo(), $opc);
?>

<script>

</script>