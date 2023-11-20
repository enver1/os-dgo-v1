<?php
session_start();
header("content-type: application/json; charset=utf-8");
include_once '../../../../clases/autoload.php';

$DgoEjemplarInforme = new DgoEjemplarInforme;
$encriptar        = new Encriptar;
$idDgoEjemplarInforme = strip_tags($encriptar->getDesencriptar($_POST['id'], $_SESSION['usuarioAuditar']));
$totalReg     = $DgoEjemplarInforme->getSumaTotalRegistrosRelacionados($DgoEjemplarInforme->getTablaDgoEjemplarInforme(), $idDgoEjemplarInforme);
if ($totalReg['total'] == 0) {
    $respuesta        = $DgoEjemplarInforme->eliminarDgoEjemplarInforme($idDgoEjemplarInforme);
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
