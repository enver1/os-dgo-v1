<?php
session_start();
header("content-type: application/json; charset=utf-8");
include_once '../../../clases/autoload.php';
$UsuariosAppDgscop = new UsuariosAppDgscop;
$encriptar    = new Encriptar;
$idDnaUsuarioUnidadApp  = strip_tags($encriptar->getDesencriptar($_POST['id'], $_SESSION['usuarioAuditar']));
$totalReg     = $UsuariosAppDgscop->getSumaTotalRegistrosRelacionados($UsuariosAppDgscop->getTablaUsuariosAppDgscop(), $idDnaUsuarioUnidadApp);
if ($totalReg == 0) {
    $respuesta = $UsuariosAppDgscop->eliminarUsuariosAppDgscop($idDnaUsuarioUnidadApp);
    echo json_encode($respuesta);
} else {
    echo json_encode(array(
        false,
        'EXISTEN DATOS RELACIONADOS. NO SE PUEDE ELIMINAR.',
        0,
    ));
}
