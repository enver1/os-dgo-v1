<?php
session_start();
header("content-type: application/json; charset=utf-8");
include_once '../../../clases/autoload.php';
$NovedadesEje      = new NovedadesEje;
$encriptar         = new Encriptar;
$idDgoNovedadesEje = strip_tags($encriptar->getDesencriptar($_POST['id'], $_SESSION['usuarioAuditar']));

$totalReg = $NovedadesEje->getSumaTotalRegistrosRelacionados($NovedadesEje->getTablaNovedadesEje(), $idDgoNovedadesEje);
if ($totalReg['total'] == 0) {
    $respuesta = $NovedadesEje->eliminarNovedadesEje($idDgoNovedadesEje);
    echo json_encode($respuesta);
} else {
    echo json_encode(array(
        false,
        'EXISTEN DATOS RELACIONADOS. NO SE PUEDE ELIMINAR.',
        0,
    ));
}
