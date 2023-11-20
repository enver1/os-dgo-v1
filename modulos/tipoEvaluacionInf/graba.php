<?php
session_start();
header("content-type: application/json; charset=utf-8");
if (isset($_SESSION['usuarioAuditar'])) {
    include_once '../../../clases/autoload.php';
    include_once 'config.php';
    $dgoTipoEvaluacionInf     = new DgoTipoEvaluacionInf;
    $respuesta    = $dgoTipoEvaluacionInf->registrarDgoTipoEvaluacionInf($_POST);
    echo json_encode($respuesta);
} else {
    header('Location: indexSiipne.php');
}
