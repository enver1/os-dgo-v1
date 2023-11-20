<?php
session_start();
header("content-type: application/json; charset=utf-8");
include_once '../../../clases/autoload.php';

$AmbitoGestionOrden = new AmbitoGestionOrden;
$encriptar        = new Encriptar;
$idDgoAmbitoGestionOrden = strip_tags($encriptar->getDesencriptar($_POST['id'], $_SESSION['usuarioAuditar']));
$totalReg     = $AmbitoGestionOrden->getSumaTotalRegistrosRelacionados($AmbitoGestionOrden->getTablaAmbitoGestionOrden(), $idDgoAmbitoGestionOrden);
if ($totalReg['total'] == 0) {
	$respuesta        = $AmbitoGestionOrden->eliminarAmbitoGestionOrden($idDgoAmbitoGestionOrden);
	ob_clean();
	echo json_encode($respuesta);
} else {
	ob_clean();
	echo json_encode(array(
		false,
		'EXISTEN DATOS RELACIONADOS. NO SE PUEDE ELIMINAR.',
		0,
	));
}
