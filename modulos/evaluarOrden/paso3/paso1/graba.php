<?php
session_start();
header("content-type: application/json; charset=utf-8");
if (isset($_SESSION['usuarioAuditar'])) {
    include_once '../../../../../clases/autoload.php';
    $dgoFuerzasPropias = new DgoFuerzasPropias;
    $respuesta        = $dgoFuerzasPropias->registrarDgoFuerzasPropias($_POST);
    echo json_encode($respuesta);
} else {
    header('Location: indexSiipne.php');
}
