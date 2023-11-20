<?php
session_start();
header("content-type: application/json; charset=utf-8");
include_once '../../../../clases/autoload.php';
$crearOrdenServicio  = new CrearOrdenServicio;
$encriptar    = new Encriptar;
$idDgoOrdenServicio     = strip_tags($encriptar->getDesencriptar($_POST['id'], $_SESSION['usuarioAuditar']));
$totalReg     = $crearOrdenServicio->getSumaTotalRegistrosRelacionados($crearOrdenServicio->getTablaCrearOrdenServicio(), $idDgoOrdenServicio);
if ($totalReg['total'] == 0) {
    $respuesta        = $crearOrdenServicio->eliminarCrearOrdenServicio($idDgoOrdenServicio);
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
