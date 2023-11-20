<?php
if (isset($_SESSION['usuarioAuditar'])) {
    include_once '../clases/autoload.php';
    include_once 'config.php';
    include_once '../funciones/funciones_generales.php';

    $puntosLlegada     = new PuntosLlegada;


    $directorio1 = '../../operaciones/modulos/puntosLlegada';
    $tgrid      = $directorio . '/grid.php'; // php para mostrar la grid
    $tforma     = $directorio . '/formulario.php'; // php para mostrar el formulario en la parte superior
    $tborra     = $directorio . '/borra.php'; // php para borrar un registro
    $tgraba     = $directorio . '/graba.php'; // php para grabar un registro
    $tprint     = $directorio1 . '/imprime.php'; // nombre del php que imprime los registros
    $tverimagen = $directorio . '/verimagen.php'; // nombre del php que imprime los registros

    $sqltable   = urlencode($puntosLlegada->getSqlPuntosLlegada());

?>
    <div id='formulario'>
        <img src="../funciones/paginacion/images/ajax-loader.gif" />
    </div>
    <div id='retrieved-data'>
        <img src="../funciones/paginacion/images/ajax-loader.gif" />
    </div>
<?php include_once 'js/ajaxuidAlertaSenderoSeguro.php'; // Este archivo contiene las funciones de ajax para update, insert, delete, y edit
} else {
    header('Location: indexSiipne.php');
}

?>
<script type="text/javascript" src="<?php echo $directorioC ?>/validacion.js"></script>