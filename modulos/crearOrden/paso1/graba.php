<?php
session_start();
header("content-type: application/json; charset=utf-8");
if (isset($_SESSION['usuarioAuditar'])) {
    include_once '../../../../clases/autoload.php';
    $crearOrdenServicio = new CrearOrdenServicio;
    $horaOrden = explode(':', $_POST['horaOrden']);
    $horaFinOrden = explode(':', $_POST['horaFormacion']);
    if ($horaOrden[0] > 23 || $horaFinOrden[0] > 23 || $horaOrden[1] > 59 || $horaFinOrden[1] > 59) {
        echo json_encode(array(false, 'FORMATO DE HORA NO VÁLIDO', 0));
    } else {
        if ($horaFinOrden[0] < $horaOrden[0]) {
            echo json_encode(array(false, 'Hora Formación No puede ser Menor a la Hora de Orden', 0));
        } else {
            if ($horaFinOrden[0] == $horaOrden[0] && $horaFinOrden[1] < $horaOrden[1]) {
                echo json_encode(array(false, 'Hora Formación No puede ser Menor a la Hora de Orden', 0));
            } else {
                $respuesta        = $crearOrdenServicio->registrarCrearOrdenServicio($_POST);
                echo json_encode($respuesta);
            }
        }
    }
} else {
    header('Location: indexSiipne.php');
}
