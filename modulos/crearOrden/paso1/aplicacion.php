<?php
session_start();
if (isset($_SESSION['usuarioAuditar'])) {
    include_once 'config.php';
    include_once '../../../../clases/autoload.php';
    $crearOrdenServicio      = new CrearOrdenServicio;
    $ambitoGestionOrden      = new AmbitoGestionOrden;
    $encriptar       = new Encriptar;
    $datosUsuario =    $ambitoGestionOrden->getDatosUsuariosSenplades($_SESSION['usuarioAuditar']);
    $sqltable        = $encriptar->getEncriptar($crearOrdenServicio->getSqlCrearOrdenServicio($datosUsuario['idGenGeoSenplades']), $_SESSION['usuarioAuditar']);

    $tgrid           = $directorio . '/grid.php'; // php para mostrar la grid
    $tforma          = $directorio . '/formulario.php'; // php para mostrar el formulario en la parte superior
    $tborra          = $directorio . '/borra.php'; // php para borrar un registro
    $tgraba          = $directorio . '/graba.php'; // php para grabar un registro
    $tprint          = $directorio . '/imprime.php'; // nombre del php que imprime los registros
?>
    <div id='formulario'>
        <img src="../funciones/paginacion/images/ajax-loader.gif" />
    </div>
    <div id="retrieved-data">
        <img src="../funciones/paginacion/images/ajax-loader.gif" />
    </div>

    </div>
    </div>
<?php include_once '../../../../js/ajaxuidGenerico.php';
    include 'validacion.php'; // Este archivo contiene las funciones de ajax para update, insert, delete, y edit
} else {
    header('Location: indexSiipne.php');
}
?>