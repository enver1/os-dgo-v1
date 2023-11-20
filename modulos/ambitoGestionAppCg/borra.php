<?php
session_start();
header("content-type: application/json; charset=utf-8");
include_once '../../../clases/autoload.php';

$AmbitoGestionAppCg = new AmbitoGestionAppCg;
$encriptar        = new Encriptar;
$idDgoAmbitoGestionAppCg = strip_tags($encriptar->getDesencriptar($_POST['id'], $_SESSION['usuarioAuditar']));
$totalReg     = $AmbitoGestionAppCg->getSumaTotalRegistrosRelacionados($AmbitoGestionAppCg->getTablaAmbitoGestionAppCg(), $idDgoAmbitoGestionAppCg);
if ($totalReg['total'] == 0) {
	$respuesta        = $AmbitoGestionAppCg->eliminarAmbitoGestionAppCg($idDgoAmbitoGestionAppCg);
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
