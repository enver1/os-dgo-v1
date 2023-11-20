<?php
session_start();
header('Content-Type: application/json');
include_once '../../../clases/autoload.php';

$hdrEventoResum = new HdrEventoResum;

$documento    = (isset($_POST['documento'])) ? $_POST['documento'] : null;
$codigoEvento = (isset($_POST['codigoEvento'])) ? $_POST['codigoEvento'] : null;

if (empty($documento) && empty($codigoEvento)) {
    echo json_encode(array('success' => false, 'msg' => 'INGRESO TODOS LOS CAMPOS REQUERIDOS'));
    exit();
}

$evento = $hdrEventoResum->getEventoResumPersona($codigoEvento, $documento);

if (empty($evento)) {
    echo json_encode(array('success' => false, 'msg' => 'NO EXISTE REGISTRO CON LOS DATOS CONSULTADOS'));
    exit();
}

echo json_encode(array('success' => true, 'msg' => '', 'data' => $evento));
exit();
