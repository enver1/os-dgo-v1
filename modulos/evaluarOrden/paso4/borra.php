<?php
session_start();
header("content-type: application/json; charset=utf-8");
include_once '../../../../clases/autoload.php';

$DgoEvaluacionInf  = new DgoEvaluacionInf;
$encriptar        = new Encriptar;
$idDgoEvaluacionInf  = strip_tags($encriptar->getDesencriptar($_POST['id'], $_SESSION['usuarioAuditar']));
$totalReg     = $DgoEvaluacionInf->getSumaTotalRegistrosRelacionados($DgoEvaluacionInf->getTablaDgoEvaluacionInf(), $idDgoEvaluacionInf);
if ($totalReg['total'] == 0) {
    $respuesta        = $DgoEvaluacionInf->eliminarDgoEvaluacionInf($idDgoEvaluacionInf);
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
