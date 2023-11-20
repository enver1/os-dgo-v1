<?php
session_start();
if (isset($_SESSION['usuarioAuditar'])) {
    // Motrar todos los errores de PHP
    error_reporting(-1);
    // No mostrar los errores de PHP
    error_reporting(0);
    // Motrar todos los errores de PHP
    error_reporting(E_ALL);
    // Motrar todos los errores de PHP
    ini_set('error_reporting', E_ALL);
    include_once '../../../../clases/autoload.php';
    include_once 'config.php';
    $CrearOperativoReci = new CrearOperativoReci;
    $encriptar          = new Encriptar;
    $sqltable           = $encriptar->getEncriptar($CrearOperativoReci->getSqlCrearOperativoReci(), $_SESSION['usuarioAuditar']);
    $tgrid              = $directorio . '/grid.php'; // php para mostrar la grid
    $tforma             = $directorio . '/formulario.php'; // php para mostrar el formulario en la parte superior
    $tborra             = $directorio . '/borra.php'; // php para borrar un registro
    $tgraba             = $directorio . '/graba.php'; // php para grabar un registro
    $tprint             = $directorio . '/imprime.php'; // nombre del php que imprime los registros
?>
    <div id='formulario'>
        <img src="../../funciones/paginacion/images/ajax-loader.gif" />
    </div>
    <div id='retrieved-data'>
        <img src="../../funciones/paginacion/images/ajax-loader.gif" />
    </div>
<?php
    include_once '../../../../js/ajaxuidGenerico.php';
    include 'validacion.php';
} else {
    header('Location: imprime.php');
}

?>