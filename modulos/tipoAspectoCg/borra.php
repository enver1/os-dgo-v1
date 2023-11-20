<?php
session_start();
header("content-type: application/json; charset=utf-8");
include_once '../../../clases/autoload.php';
$TipoAspectoCg = new TipoAspectoCg;
$encriptar              = new Encriptar;
$idCgTipoAspecto    = strip_tags($encriptar->getDesencriptar($_POST['id'], $_SESSION['usuarioAuditar']));
$totalReg     = $TipoAspectoCg->getSumaTotalRegistrosRelacionados($TipoAspectoCg->getTabla(), $idCgTipoAspecto);
if ($totalReg['total'] == 0) {
    $respuesta              = $TipoAspectoCg->eliminarTipoAspectoCg($idCgTipoAspecto);
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
