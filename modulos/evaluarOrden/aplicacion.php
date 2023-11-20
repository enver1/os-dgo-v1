<?php
if (isset($_SESSION['usuarioAuditar'])) {
    include_once '../clases/autoload.php';
    $formPestanas = new FormPestanas;
    $ambitoGestionOrden      = new AmbitoGestionOrden;
    $encriptar       = new Encriptar;
    $datosUsuario =    $ambitoGestionOrden->getDatosUsuariosSenplades($_SESSION['usuarioAuditar']);
    $idDgoAmbitoGestionOrden = isset($datosUsuario['idDgoAmbitoGestionOrden']) ? $datosUsuario['idDgoAmbitoGestionOrden'] : 0;
    $distrito = isset($datosUsuario['Distrito']) ? $datosUsuario['Distrito'] : 0;

    $pestana      = array(
        1 => array(
            'pestaN' => '1',
            'pestaD' => '1. Registro Informe',
        ),
        2 => array(
            'pestaN' => '2',
            'pestaD' => '2. Antecedentes',
        ),
        3 => array(
            'pestaN' => '3',
            'pestaD' => '3. Operaciones',
        ),

        4 => array(
            'pestaN' => '4',
            'pestaD' => '4. Evaluación',
        ),
        5 => array(
            'pestaN' => '5',
            'pestaD' => '5. Oportunidades',
        ),

        6 => array(
            'pestaN' => '6',
            'pestaD' => '6. Ejemplares',
        ),
        7 => array(
            'pestaN' => '7',
            'pestaD' => '7. Anexos',
        ),
        8 => array(
            'pestaN' => '8',
            'pestaD' => '8. Validación e Impresión',
        ),
    );
    $nPes = count($pestana);
    echo '<link href="../../../../css/stylePesta.css" rel="stylesheet" type="text/css" />';

    $nombre = 'INFORMES DE EVALUACIÓN DE LAS ÓRDENES DE SERVICIO DEL ' . $distrito;

    $camposOcultos = array(
        'idOrden' => 0,
    );
    include_once 'js/ajaxuidPesta.php';
} else {
    header('Location: indexSiipne.php');
}
if ($idDgoAmbitoGestionOrden  > 0) {
?>
    <script type="text/javascript" src="js/sweetalert2/sweetalert2.all.min.js"></script>
    <link href='js/sweetalert2/sweetalert2.min.css' rel="stylesheet" type="text/css">
    <link href='./css/registroOrden.css' rel="stylesheet" type="text/css">
    <link href='./css/estilosbs.css' rel="stylesheet" type="text/css">
    <script type="text/javascript" src="js/app.js"></script>
    <div class="contenedor" style="width:99%">
        <div class="dheader2">

        </div>
        <div class="dbody">
            <table width="100%" border="0">
                <tr>
                    <td style="vertical-align:top;">
                        <?php
                        echo $formPestanas->mostrarFormPestanas($pestana, $camposOcultos, $nombre);
                        ?>
                    </td>
                </tr>

            </table>
        </div>
        <div class="dfoot">
        </div>
    </div>
<?php

} else {
    die('<p class="col3" style="width:90%;margin:5px auto;"><span class="texto_azul" style="font-size:12px">El Usuario NO tiene asignado un Distrito para Crear el Informe de la Orden de Servicio. Favor Tome Contacto con el Subadministrador DGSCOP</span></p>');
}
