<?php
session_start();
header("content-type: application/json; charset=utf-8");
if (isset($_SESSION['usuarioAuditar'])) {
    include_once '../../../../clases/autoload.php';
    $DgoOportunidadesInforme  = new DgoOportunidadesInforme;
    $respuesta        = $DgoOportunidadesInforme->registrarDgoOportunidadesInforme($_POST);
    echo json_encode($respuesta);
} else {
    header('Location: indexSiipne.php');
}
