<?php
session_start();
header("content-type: application/json; charset=utf-8");
if (isset($_SESSION['usuarioAuditar'])) {
    include_once '../../../../clases/autoload.php';
    $dgoInstruccionesOrden  = new DgoInstruccionesOrden;
    $respuesta        = $dgoInstruccionesOrden->registrarDgoInstruccionesOrden($_POST, 'P');
    echo json_encode($respuesta);
} else {
    header('Location: indexSiipne.php');
}
