<?php
session_start();
header("content-type: application/json; charset=utf-8");
if (isset($_SESSION['usuarioAuditar'])) {
    include_once '../../../clases/autoload.php';
    $RegistroNovElec = new RegistroNovElec;

    $respuesta = $RegistroNovElec->registrarRegistroNovElec($_POST, $_FILES);

    echo json_encode($respuesta);

} else {
    header('Location: indexSiipne.php');
}
