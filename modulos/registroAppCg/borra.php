<?php
session_start();
header("content-type: application/json; charset=utf-8");
include_once '../../../clases/autoload.php';

$RegistroAspectoAppCg      = new RegistroAspectoAppCg;
$encriptar       = new Encriptar;
$idDgoTipoCalificacion = strip_tags($encriptar->getDesencriptar($_POST['id'], $_SESSION['usuarioAuditar']));

$totalReg     = $RegistroAspectoAppCg->getSumaTotalRegistrosRelacionados($RegistroAspectoAppCg->getTablaRegistroAspectoAppCg(), $idDgoTipoCalificacion);
if ($totalReg['total'] == 0) {
    $respuesta       = $RegistroAspectoAppCg->eliminarRegistroAspectoAppCg($idDgoTipoCalificacion);
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
