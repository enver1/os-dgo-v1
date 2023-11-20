<?php
if (isset($_SESSION['usuarioAuditar'])) {
    include_once '../clases/autoload.php';
    $formPestanas = new FormPestanas;
    $encriptar    = new Encriptar;
    $pestana = array(
        1 => array(
            'pestaN' => '1',
            'pestaD' => '1. Registro de Procesos',
        ),
        2 => array(
            'pestaN' => '2',
            'pestaD' => '2. Asignación de Unidades al Proceso',
        ),
    );
    $nPes = count($pestana);
    echo '<link href="../css/stylePesta.css" rel="stylesheet" type="text/css" />';
    $camposOcultos = array(
        'idProceso' => 0,
    );
    $unidad = "";

    echo $formPestanas->mostrarFormPestanas($pestana, $camposOcultos, $unidad);

    include_once 'js/ajaxP.php';
} else {
    header('Location: indexSiipne.php');
}
