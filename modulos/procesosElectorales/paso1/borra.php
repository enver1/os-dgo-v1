<?php
session_start();
header("content-type: application/json; charset=utf-8");
include_once '../../../../clases/autoload.php';
$ProcesosElectorales = new ProcesosElectorales;
$encriptar           = new Encriptar;
$idDgoProcElec       = strip_tags($encriptar->getDesencriptar($_POST['id'], $_SESSION['usuarioAuditar']));

$totalReg = $ProcesosElectorales->getSumaTotalRegistrosRelacionados($ProcesosElectorales->getTablaProcesosElectorales(), $idDgoProcElec);
if ($totalReg['total'] == 0) {
    $respuesta = $ProcesosElectorales->eliminarProcesosElectorales($idDgoProcElec);
    echo json_encode($respuesta);
} else {
    echo json_encode(array(
        false,
        'EXISTEN DATOS RELACIONADOS. NO SE PUEDE ELIMINAR.',
        0,
    ));
}
