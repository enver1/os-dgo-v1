<?php
session_start();
header("content-type: application/json; charset=utf-8");
include_once '../../../clases/autoload.php';

$NovedadesElect = new NovedadesElect;
$encriptar       = new Encriptar;
$idDgoNovedadesElec    = strip_tags($encriptar->getDesencriptar($_POST['id'], $_SESSION['usuarioAuditar']));

$totalReg = $NovedadesElect->getSumaTotalRegistrosRelacionados($NovedadesElect->getTablaNovedadesElect(), $idDgoNovedadesElec);
if ($totalReg['total'] == 0) {
    $respuesta = $NovedadesElect->eliminarNovedadesElect($conn, $idDgoNovedadesElec);
    echo json_encode($respuesta);
} else {
    echo json_encode(array(
        false,
        'EXISTEN DATOS RELACIONADOS. NO SE PUEDE ELIMINAR.',
        0,
    ));
}
