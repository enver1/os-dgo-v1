<?php
session_start();
header("content-type: application/json; charset=utf-8");
include_once '../../../../../clases/autoload.php';

$dgoTalentoHumanoOrden = new DgoTalentoHumanoOrden;
$encriptar        = new Encriptar;
$idDgoTalentoHumanoOrden = strip_tags($encriptar->getDesencriptar($_POST['id'], $_SESSION['usuarioAuditar']));
$totalReg     = $dgoTalentoHumanoOrden->getSumaTotalRegistrosRelacionados($dgoTalentoHumanoOrden->getTablaDgoTalentoHumanoOrden(), $idDgoTalentoHumanoOrden);
if ($totalReg['total'] == 0) {
    $respuesta        = $dgoTalentoHumanoOrden->eliminarDgoTalentoHumanoOrden($idDgoTalentoHumanoOrden);
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
