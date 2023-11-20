<?php
session_start();
header("content-type: application/json; charset=utf-8");
include_once '../../../../clases/autoload.php';
$DgoOperacionesInforme = new DgoOperacionesInforme;
$encriptar        = new Encriptar;
$idDgoOperacionesInforme = strip_tags($encriptar->getDesencriptar($_POST['id'], $_SESSION['usuarioAuditar']));
$totalReg     = $DgoOperacionesInforme->getSumaTotalRegistrosRelacionados($DgoOperacionesInforme->getTablaDgoOperacionesInforme(), $idDgoOperacionesInforme);
if ($totalReg['total'] == 0) {
    $respuesta        = $DgoOperacionesInforme->eliminarDgoOperacionesInforme($idDgoOperacionesInforme);
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
