<?php
session_start();
header("content-type: application/json; charset=utf-8");
include_once '../../../../clases/autoload.php';

$DgoInstruccionesOrden  = new DgoInstruccionesOrden;
$encriptar        = new Encriptar;
$idDgoInstruccionesOrden  = strip_tags($encriptar->getDesencriptar($_POST['id'], $_SESSION['usuarioAuditar']));
$totalReg     = $DgoInstruccionesOrden->getSumaTotalRegistrosRelacionados($DgoInstruccionesOrden->getTablaDgoInstruccionesOrden(), $idDgoInstruccionesOrden);
if ($totalReg['total'] == 0) {
    $respuesta        = $DgoInstruccionesOrden->eliminarDgoInstruccionesOrden($idDgoInstruccionesOrden);
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
