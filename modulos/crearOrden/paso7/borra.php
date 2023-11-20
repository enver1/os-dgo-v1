<?php
session_start();
header("content-type: application/json; charset=utf-8");
include_once '../../../../clases/autoload.php';

$DgoEjemplarOrden = new DgoEjemplarOrden;
$encriptar        = new Encriptar;
$idDgoEjemplarOrden = strip_tags($encriptar->getDesencriptar($_POST['id'], $_SESSION['usuarioAuditar']));
$totalReg     = $DgoEjemplarOrden->getSumaTotalRegistrosRelacionados($DgoEjemplarOrden->getTablaDgoEjemplarOrden(), $idDgoEjemplarOrden);
if ($totalReg['total'] == 0) {
    $respuesta        = $DgoEjemplarOrden->eliminarDgoEjemplarOrden($idDgoEjemplarOrden);
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
