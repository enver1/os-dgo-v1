<?php
session_start();
header("content-type: application/json; charset=utf-8");
include_once '../../../funciones/db_connect.inc.php';
include_once '../../../clases/autoload.php';
$GrupoResumen   = new GrupoResumen;
$encriptar      = new Encriptar;
$idHdrGrupResum = strip_tags($encriptar->getDesencriptar($_POST['id'], $_SESSION['usuarioAuditar']));

$totalReg = $GrupoResumen->getSumaTotalRegistrosRelacionados($GrupoResumen->getTablaGrupoResumen(), $idHdrGrupResum);
if ($totalReg['total'] == 0) {
    $respuesta = $GrupoResumen->eliminarGrupoResumen($idHdrGrupResum);
    echo json_encode($respuesta);
} else {
    echo json_encode(array(
        false,
        'EXISTEN DATOS RELACIONADOS. NO SE PUEDE ELIMINAR.',
        0,
    ));
}
