<?php
session_start();
header("content-type: application/json; charset=utf-8");
include_once '../../../../clases/autoload.php';
$dgoInfOrdenServicio  = new DgoInfOrdenServicio;
$encriptar    = new Encriptar;
$idDgoInfOrdenServicio     = strip_tags($encriptar->getDesencriptar($_POST['id'], $_SESSION['usuarioAuditar']));
$totalReg     = $dgoInfOrdenServicio->getSumaTotalRegistrosRelacionados($dgoInfOrdenServicio->getTablaDgoInfOrdenServicio(), $idDgoInfOrdenServicio);
if ($totalReg['total'] == 0) {
    $respuesta        = $dgoInfOrdenServicio->eliminarDgoInfOrdenServicio($idDgoInfOrdenServicio);
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
