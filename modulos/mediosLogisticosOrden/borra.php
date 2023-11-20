<?php
session_start();
header("content-type: application/json; charset=utf-8");
include_once '../../../clases/autoload.php';

$mediosLogisticosOrden      = new MediosLogisticosOrden;
$encriptar       = new Encriptar;
$idDgoMediosLogisticos = strip_tags($encriptar->getDesencriptar($_POST['id'], $_SESSION['usuarioAuditar']));

$totalReg     = $mediosLogisticosOrden->getSumaTotalRegistrosRelacionados($mediosLogisticosOrden->getTablaMediosLogisticosOrden(), $idDgoMediosLogisticos);
if ($totalReg['total'] == 0) {
    $respuesta       = $mediosLogisticosOrden->eliminarMediosLogisticosOrden($idDgoMediosLogisticos);
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
