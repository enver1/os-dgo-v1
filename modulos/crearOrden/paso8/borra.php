<?php
session_start();
header("content-type: application/json; charset=utf-8");
include_once '../../../../clases/autoload.php';

$DgoAnexosOrden = new DgoAnexosOrden;
$encriptar        = new Encriptar;
$idUcpPpl = strip_tags($encriptar->getDesencriptar($_POST['id'], $_SESSION['usuarioAuditar']));
$totalReg     = $DgoAnexosOrden->getSumaTotalRegistrosRelacionados($DgoAnexosOrden->getTablaDgoAnexosOrden(), $idUcpPpl);
if ($totalReg['total'] == 0) {
    $respuesta        = $DgoAnexosOrden->eliminarDgoAnexosOrden($idUcpPpl);
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
