<?php
session_start();
header("content-type: application/json; charset=utf-8");
include_once '../../../funciones/db_connect.inc.php';
include_once '../../../clases/autoload.php';
$DetalleInfoAppDgscop = new DetalleInfoAppDgscop;
$encriptar    = new Encriptar;
$idDnaInfoDetalleApp  = strip_tags($encriptar->getDesencriptar($_POST['id'], $_SESSION['usuarioAuditar']));
$totalReg     = $DetalleInfoAppDgscop->getSumaTotalRegistrosRelacionados($DetalleInfoAppDgscop->getTablaDetalleInfoAppDgscop(), $idDnaInfoDetalleApp);
if ($totalReg['total'] == 0) {
    $respuesta = $DetalleInfoAppDgscop->eliminarDetalleInfoAppDgscop($idDnaInfoDetalleApp);
    echo json_encode($respuesta);
} else {
    echo json_encode(array(
        false,
        'EXISTEN DATOS RELACIONADOS. NO SE PUEDE ELIMINAR.',
        0,
    ));
}
