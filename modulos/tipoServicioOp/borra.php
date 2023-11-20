<?php
session_start();
header("content-type: application/json; charset=utf-8");
include_once '../../../funciones/db_connect.inc.php';
include_once '../../../clases/autoload.php';
$TipoServicioOp    = new TipoServicioOp;
$encriptar         = new Encriptar;
$idHdrTipoServicio = strip_tags($encriptar->getDesencriptar($_POST['id'], $_SESSION['usuarioAuditar']));

$totalReg = $TipoServicioOp->getSumaTotalRegistrosRelacionados($TipoServicioOp->getTablaTipoServicioOp(), $idHdrTipoServicio);
if ($totalReg['total'] == 0) {

    $respuesta = $TipoServicioOp->eliminarTipoServicioOp($idHdrTipoServicio);

    echo json_encode($respuesta);
} else {
    echo json_encode(array(
        false,
        'EXISTEN DATOS RELACIONADOS. NO SE PUEDE ELIMINAR.',
        0,
    ));
}