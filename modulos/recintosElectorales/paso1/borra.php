<?php
session_start();
header("content-type: application/json; charset=utf-8");
include_once '../../../../clases/autoload.php';
$RecintoElectoral      = new RecintoElectoral;
$encriptar             = new Encriptar;
$idDgoReciElect = strip_tags($encriptar->getDesencriptar($_POST['id'], $_SESSION['usuarioAuditar']));

$totalReg = $RecintoElectoral->getSumaTotalRegistrosRelacionados($RecintoElectoral->getTablaRecintoElectoral(), $idDgoReciElect);
if ($totalReg['total'] == 0) {
    $respuesta = $RecintoElectoral->eliminarRecintoElectoral($idDgoReciElect);
    echo json_encode($respuesta);
} else {
    echo json_encode(array(
        false,
        'EXISTEN DATOS RELACIONADOS. NO SE PUEDE ELIMINAR.',
        0,
    ));
}
