<?php
session_start();
header("content-type: application/json; charset=utf-8");
include_once '../../../clases/autoload.php';
$TipoOperativoOrden = new TipoOperativoOrden;
$encriptar              = new Encriptar;
$idGenTipoOperativo    = strip_tags($encriptar->getDesencriptar($_POST['id'], $_SESSION['usuarioAuditar']));
$totalReg     = $TipoOperativoOrden->getSumaTotalRegistrosRelacionados($TipoOperativoOrden->getTabla(), $idGenTipoOperativo);
if ($totalReg['total'] == 0) {
    $respuesta              = $TipoOperativoOrden->eliminarTipoOperativoOrden($idGenTipoOperativo);
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
