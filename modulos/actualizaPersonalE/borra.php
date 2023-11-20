<?php
session_start();
header("content-type: application/json; charset=utf-8");
include_once '../../../clases/autoload.php';

$clasificacionOrden      = new ClasificacionOrden;
$encriptar       = new Encriptar;
$idDgoTipoCalificacion = strip_tags($encriptar->getDesencriptar($_POST['id'], $_SESSION['usuarioAuditar']));

$totalReg     = $clasificacionOrden->getSumaTotalRegistrosRelacionados($clasificacionOrden->getTablaClasificacionOrden(), $idDgoTipoCalificacion);
if ($totalReg['total'] == 0) {
    $respuesta       = $clasificacionOrden->eliminarClasificacionOrden($idDgoTipoCalificacion);
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
