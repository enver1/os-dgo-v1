<?php
session_start();
include_once 'config.php';
include_once '../../../clases/autoload.php';

$formGenModelo    = new GenModeloForm();
$obj  = new GenModelo();
$encriptar              = new Encriptar;

$opc  = $_GET['opc'];
$rowt = array();

$id = strip_tags($encriptar->getDesencriptar($_GET['c'], $_SESSION['usuarioAuditar']));

if ($id > 0) {
	$rowt = $obj->getGenModeloPorId($id);
}
$formGenModelo->getFormGenModelo($rowt, $obj->getIdCampo(), $opc);
?>

<script>

</script>