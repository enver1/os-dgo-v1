<?php
session_start();
header("content-type: application/json; charset=utf-8");
include_once '../../../../../clases/autoload.php';
$DgoMediosLogisticosInf = new DgoMediosLogisticosInf;
$encriptar        = new Encriptar;
$idDgoMediosLogisticosInf = strip_tags($encriptar->getDesencriptar($_POST['id'], $_SESSION['usuarioAuditar']));
$totalReg     = $DgoMediosLogisticosInf->getSumaTotalRegistrosRelacionados($DgoMediosLogisticosInf->getTablaDgoMediosLogisticosInf(), $idDgoMediosLogisticosInf);
if ($totalReg['total'] == 0) {
    $respuesta        = $DgoMediosLogisticosInf->eliminarDgoMediosLogisticosInf($idDgoMediosLogisticosInf);
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
