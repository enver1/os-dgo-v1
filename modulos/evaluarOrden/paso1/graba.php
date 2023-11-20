<?php
session_start();
header("content-type: application/json; charset=utf-8");
if (isset($_SESSION['usuarioAuditar'])) {
    include_once '../../../../clases/autoload.php';
    $DgoInfOrdenServicio = new DgoInfOrdenServicio;
    $horaInforme = explode(':', $_POST['horaInforme']);
    if ($horaInforme[0] > 23  || $horaInforme[1] > 59) {
        echo json_encode(array(false, 'FORMATO DE HORA NO VÁLIDO', 0));
    } else {
        $respuesta        = $DgoInfOrdenServicio->registrarDgoInfOrdenServicio($_POST);
        echo json_encode($respuesta);
    }
} else {
    header('Location: indexSiipne.php');
}
