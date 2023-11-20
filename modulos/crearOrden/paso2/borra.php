<?php
session_start();
header("content-type: application/json; charset=utf-8");
include_once '../../../../clases/autoload.php';

$DgoAntecedentesOrden = new DgoAntecedentesOrden;
$encriptar        = new Encriptar;
$idUcpPpl = strip_tags($encriptar->getDesencriptar($_POST['id'], $_SESSION['usuarioAuditar']));
$totalReg     = $DgoAntecedentesOrden->getSumaTotalRegistrosRelacionados($DgoAntecedentesOrden->getTablaDgoAntecedentesOrden(), $idUcpPpl);
if ($totalReg['total'] == 0) {
    $respuesta        = $DgoAntecedentesOrden->eliminarDgoAntecedentesOrden($idUcpPpl);
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
