<?php
session_start();
header("content-type: application/json; charset=utf-8");
include_once '../../../clases/autoload.php';
include_once 'config.php';

$objT = new GenMarca();
$encriptar              = new Encriptar;
$id = strip_tags($encriptar->getDesencriptar($_GET['id'], $_SESSION['usuarioAuditar']));
$respuesta      = $objT->eliminar($id);
echo json_encode($respuesta);
/* if ($id > 0) {
    $resp = $objT->getSumaTotalRegistrosRelacionados($conn, $tabla, $id);
    $cantidadIdRelacionado = $resp['total'];
    if ($cantidadIdRelacionado == 0) {
        $respuesta      = $objT->delete($conn, $tabla, $id);
        echo json_encode($respuesta);
    } else {
        $respuesta      = array(false, "NO SE PUEDE ELIMINAR, TIENE ANEXADO " . $cantidadIdRelacionado . " REGISTRO/S", 0);
        echo json_encode($respuesta);
    }
} */