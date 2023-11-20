<?php
session_start();
header("content-type: application/json; charset=utf-8");
include_once '../../../../clases/autoload.php';

$DgoOportunidadesInforme  = new DgoOportunidadesInforme;
$encriptar        = new Encriptar;
$idDgoOportunidadesInforme  = strip_tags($encriptar->getDesencriptar($_POST['id'], $_SESSION['usuarioAuditar']));
$totalReg     = $DgoOportunidadesInforme->getSumaTotalRegistrosRelacionados($DgoOportunidadesInforme->getTablaDgoOportunidadesInforme(), $idDgoOportunidadesInforme);
if ($totalReg['total'] == 0) {
    $respuesta        = $DgoOportunidadesInforme->eliminarDgoOportunidadesInforme($idDgoOportunidadesInforme);
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
