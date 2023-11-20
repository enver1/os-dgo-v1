<?php
session_start();
header("content-type: application/json; charset=utf-8");
include_once '../../../clases/autoload.php';
$InfoAppDgscop = new InfoAppDgscop;
$encriptar    = new Encriptar;
$idGenAcceso  = strip_tags($encriptar->getDesencriptar($_POST['id'], $_SESSION['usuarioAuditar']));
$totalReg     = $InfoAppDgscop->getSumaTotalRegistrosRelacionados($InfoAppDgscop->getTablaInfoAppDgscop(), $idGenAcceso);
if ($totalReg['total'] == 0) {
    $respuesta = $InfoAppDgscop->eliminarInfoAppDgscop($idGenAcceso);
    echo json_encode($respuesta);
} else {
    echo json_encode(array(
        false,
        'EXISTEN DATOS RELACIONADOS. NO SE PUEDE ELIMINAR.',
        0,
    ));
}
