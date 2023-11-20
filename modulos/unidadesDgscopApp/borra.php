<?php
session_start();
header("content-type: application/json; charset=utf-8");
include_once '../../../clases/autoload.php';
$UnidadesDgscopApp = new UnidadesDgscopApp;
$encriptar    = new Encriptar;
$idDnaUnidadApp  = strip_tags($encriptar->getDesencriptar($_POST['id'], $_SESSION['usuarioAuditar']));
$totalReg     = $UnidadesDgscopApp->getSumaTotalRegistrosRelacionados($UnidadesDgscopApp->getTablaDgscopUnidadApp(), $idDnaUnidadApp);
if ($totalReg['total'] == 0) {
    $respuesta = $UnidadesDgscopApp->eliminarUnidadesDgscopApp($idDnaUnidadApp);
    echo json_encode($respuesta);
} else {
    echo json_encode(array(
        false,
        'EXISTEN DATOS RELACIONADOS. NO SE PUEDE ELIMINAR.',
        0,
    ));
}
