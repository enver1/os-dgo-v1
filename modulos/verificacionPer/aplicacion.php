<script type="text/javascript" src="js/sweetalert2/sweetalert2.all.min.js"></script>
<link href='js/sweetalert2/sweetalert2.min.css' rel="stylesheet" type="text/css">
<link href='./css/registroOrden.css' rel="stylesheet" type="text/css">
<link href='./css/estilosbs.css' rel="stylesheet" type="text/css">
<script type="text/javascript" src="js/app.js"></script>
<?php
if (isset($_SESSION['usuarioAuditar'])) {
    include_once '../clases/autoload.php';
    $formPestanas = new FormPestanas;
    $encriptar    = new Encriptar;
    $pestana      = array(
        1 => array(
            'pestaN' => '1',
            'pestaD' => '1. Registrar Jefe de Recinto Electoral',
        ),
        2 => array(
            'pestaN' => '2',
            'pestaD' => '2. Registrar Integrantes',
        ),
    );
    $nPes = count($pestana);
    echo '<link href="../css/stylePesta.css" rel="stylesheet" type="text/css" />';
    $camposOcultos = array(
        'idJefe'     => 0,
        'est'        => 'A',
        'idDgoProcE' => 0,
        'lat'        => 0,
        'long'       => 0,
        'idRElec'  => 0,
    );
    $unidad = "";

    echo $formPestanas->mostrarFormPestanas($pestana, $camposOcultos, $unidad);

    include_once 'js/ajaxP.php';
} else {
    header('Location: indexSiipne.php');
}
?>