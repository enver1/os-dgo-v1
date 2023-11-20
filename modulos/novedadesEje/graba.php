<?php
session_start();
include_once '../../../clases/autoload.php';
$seleccionados = $_GET['sele'];
$NovedadesEje  = new NovedadesEje;
if ($_POST['idDgoNovedadesEje'] > 0) {
    $respuesta = $NovedadesEje->registrarNovedadesEjeEditar($_POST);
    echo json_encode($respuesta);
    exit;
}
if (!empty($seleccionados)) {
    $respuesta = $NovedadesEje->registrarNovedadesEje($_POST, $seleccionados);
    echo json_encode($respuesta);
} else {
    $resp = array(false, 'NO EXISTEN NOVEDADES SELECCIONADAS', 0,);
    echo json_encode($resp);
}
