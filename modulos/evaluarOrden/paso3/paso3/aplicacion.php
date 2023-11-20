<?php
session_start();
if (isset($_SESSION['usuarioAuditar'])) {
    include_once 'config.php';
    include_once '../../../../../clases/autoload.php';
    $DgoOperacionesInforme      = new DgoOperacionesInforme;
    $encriptar       = new Encriptar;
    $sqltable        = $encriptar->getEncriptar($DgoOperacionesInforme->getSqlDgoOperacionesInforme($_GET['id']), $_SESSION['usuarioAuditar']);
    $tgrid           = $directorio . '/grid.php'; // php para mostrar la grid
    $tforma          = $directorio . '/formulario.php'; // php para mostrar el formulario en la parte superior
    $tborra          = $directorio . '/borra.php'; // php para borrar un registro
    $tgraba          = $directorio . '/graba.php'; // php para grabar un registro
    $tprint          = $directorio . '/imprime.php'; // nombre del php que imprime los registros
?>
    <div id='formTituloFA'>
        <img src="../../funciones/paginacion/images/ajax-loader.gif" />
    </div>
    <div id='formAyuda'>
        <img src="../../funciones/paginacion/images/ajax-loader.gif" />
    </div>
    <div id='formulario'>
        <img src="../../funciones/paginacion/images/ajax-loader.gif" />
    </div>
    <div id='retrieved-data'>
        <img src="../../funciones/paginacion/images/ajax-loader.gif" />
    </div>
<?php
    include_once '../../../../../js/ajaxuidGenerico.php';
    include_once 'validacion.php';
} else {
    header('Location: indexSiipne.php');
}
?>
<script>
    $(function() {
        $('#formTituloFA').load('modulos/evaluarOrden/paso3/includes/formTituloFuerzasA.php');
        $('#formAyuda').load('modulos/evaluarOrden/includes/formularioAyuda.php?bn=<?php echo $_GET['opc'] ?>&id=<?php echo (isset($_GET['id']) ? $_GET['id'] : 0) ?>');
    });
</script>