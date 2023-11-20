<?php
session_start();
header("content-type: application/json; charset=utf-8");
include_once '../../../../../clases/autoload.php';

$DgoFuerzasPropias = new DgoFuerzasPropias;
$encriptar        = new Encriptar;
$idDgoFuerzasPropias = strip_tags($encriptar->getDesencriptar($_POST['id'], $_SESSION['usuarioAuditar']));
$totalReg     = $DgoFuerzasPropias->getSumaTotalRegistrosRelacionados($DgoFuerzasPropias->getTablaDgoFuerzasPropias(), $idDgoFuerzasPropias);
if ($totalReg['total'] == 0) {
    $respuesta        = $DgoFuerzasPropias->eliminarDgoFuerzasPropias($idDgoFuerzasPropias);
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
