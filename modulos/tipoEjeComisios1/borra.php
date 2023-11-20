<?php
session_start();
header("content-type: application/json; charset=utf-8");
include_once '../../../funciones/db_connect.inc.php';
include_once '../../../clases/autoload.php';

$TipoEjeComisios = new TipoEjeComisios;
$encriptar       = new Encriptar;
$idDgoTipoEje    = strip_tags($encriptar->getDesencriptar($_POST['id'], $_SESSION['usuarioAuditar']));

$totalReg = $TipoEjeComisios->getSumaTotalRegistrosRelacionados($TipoEjeComisios->getTablaTipoEjeComisios(), $idDgoTipoEje);
if ($totalReg['total'] == 0) {
    $respuesta = $TipoEjeComisios->eliminarTipoEjeComisios($conn, $idDgoTipoEje);
    echo json_encode($respuesta);
} else {
    echo json_encode(array(
        false,
        'EXISTEN DATOS RELACIONADOS. NO SE PUEDE ELIMINAR.',
        0,
    ));
}
