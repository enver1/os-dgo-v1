<?php
session_start();
header("content-type: application/json; charset=utf-8");
include_once '../../../../clases/autoload.php';
$dgoFuerzasAlternativas = new DgoFuerzasAlternativas;
$encriptar        = new Encriptar;
$idDgoFuerzasAlternativas = strip_tags($encriptar->getDesencriptar($_POST['id'], $_SESSION['usuarioAuditar']));
$totalReg     = $dgoFuerzasAlternativas->getSumaTotalRegistrosRelacionados($dgoFuerzasAlternativas->getTablaDgoFuerzasAlternativas(), $idDgoFuerzasAlternativas);
if ($totalReg['total'] == 0) {
    $respuesta        = $dgoFuerzasAlternativas->eliminarDgoFuerzasAlternativas($idDgoFuerzasAlternativas);
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
