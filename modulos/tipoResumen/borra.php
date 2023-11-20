<?php
session_start();
header("content-type: application/json; charset=utf-8");
include_once '../../../clases/autoload.php';

$TipoResumen = new TipoResumen();
$encriptar   = new Encriptar();

$id = strip_tags($encriptar->getDesencriptar($_POST['id'], $_SESSION['usuarioAuditar']));

$totalReg = $TipoResumen->getSumaTotalRegistrosRelacionados($TipoResumen->getTablaTipoResumen(), $id);

if ($totalReg['total'] == 0) {

    $respuesta = $TipoResumen->eliminar($id);
    echo json_encode($respuesta);
} else {
    echo json_encode(array(
        false,
        'EXISTEN DATOS RELACIONADOS. NO SE PUEDE ELIMINAR.',
        0,
    ));
}
