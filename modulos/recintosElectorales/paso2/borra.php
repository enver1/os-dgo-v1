<?php
session_start();
header("content-type: application/json; charset=utf-8");
include_once '../../../../clases/autoload.php';
$Comisios       = new Comisios;
$encriptar      = new Encriptar;
$idDgoReciElect = strip_tags($encriptar->getDesencriptar($_POST['id'], $_SESSION['usuarioAuditar']));

$totalReg = $Comisios->getSumaTotalRegistrosRelacionados($Comisios->getTablaComisios(), $idDgoReciElect);
if ($totalReg['total'] == 0) {
    $respuesta = $Comisios->eliminarComisios($idDgoReciElect);
    echo json_encode($respuesta);
} else {
    echo json_encode(array(
        false,
        'EXISTEN DATOS RELACIONADOS. NO SE PUEDE ELIMINAR.',
        0,
    ));
}
