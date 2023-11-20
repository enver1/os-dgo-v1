<?php
session_start();
header("content-type: application/json; charset=utf-8");
include_once '../../../clases/autoload.php';

$dgoTipoEvaluacionInf      = new DgoTipoEvaluacionInf;
$encriptar       = new Encriptar;
$idDgoTipoEvaluacionInf = strip_tags($encriptar->getDesencriptar($_POST['id'], $_SESSION['usuarioAuditar']));

$totalReg     = $dgoTipoEvaluacionInf->getSumaTotalRegistrosRelacionados($dgoTipoEvaluacionInf->getTablaDgoTipoEvaluacionInf(), $idDgoTipoEvaluacionInf);
if ($totalReg['total'] == 0) {
    $respuesta       = $dgoTipoEvaluacionInf->eliminarDgoTipoEvaluacionInf($idDgoTipoEvaluacionInf);
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
