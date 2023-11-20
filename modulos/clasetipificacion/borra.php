<?php
session_start();
header("content-type: application/json; charset=utf-8");
include_once '../../../clases/autoload.php';

$TipoTipificacion = new TipoTipificacion();
$encriptar = new Encriptar();

$id = strip_tags($encriptar->getDesencriptar($_POST['id'], $_SESSION['usuarioAuditar']));

$totalReg = $TipoTipificacion->getSumaTotalRegistrosRelacionados($TipoTipificacion->getNombreTabla(), $id);

if($totalReg['total'] == 0){

	$respuesta = $TipoTipificacion->eliminar($id);
	echo json_encode($respuesta);
} else{
	echo json_encode(array(
			false,
			'EXISTEN DATOS RELACIONADOS. NO SE PUEDE ELIMINAR.',
			0
	));
}

