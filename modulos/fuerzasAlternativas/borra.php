<?php
session_start();
header("content-type: application/json; charset=utf-8");
include_once '../../../clases/autoload.php';

$fuerzasAlternativas      = new FuerzasAlternativas;
$encriptar       = new Encriptar;
$idDgoTipoFuerzasAlternativas = strip_tags($encriptar->getDesencriptar($_POST['id'], $_SESSION['usuarioAuditar']));

$totalReg     = $fuerzasAlternativas->getSumaTotalRegistrosRelacionados($fuerzasAlternativas->getTablaMatriz(), $idDgoTipoFuerzasAlternativas);
if ($totalReg['total'] == 0) {
    $respuesta       = $fuerzasAlternativas->eliminarFuerzasAlternativas($idDgoTipoFuerzasAlternativas);
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
