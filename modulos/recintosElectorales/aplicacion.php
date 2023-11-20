<?php
if (isset($_SESSION['usuarioAuditar'])) {
    include_once '../clases/autoload.php';
    $formPestanas = new FormPestanas;
    $encriptar    = new Encriptar;
    $pestana      = array(
        1 => array(
            'pestaN' => '1',
            'pestaD' => '1. Recintos Electorales/Unidades Policiales',
        ),
        2 => array(
            'pestaN' => '2',
            'pestaD' => '2. Detalle Recintos',
        ),
    );
    $nPes = count($pestana);
    echo '<link href="../css/stylePesta.css" rel="stylesheet" type="text/css" />';
    $camposOcultos = array(
        'idRecinto' => 0,
        'idDgoT'    => 1,
    );
    $unidad = "";

    echo $formPestanas->mostrarFormPestanas($pestana, $camposOcultos, $unidad);

    include_once 'js/ajaxP.php';
} else {
    header('Location: indexSiipne.php');
}
