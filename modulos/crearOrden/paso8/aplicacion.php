<?php
session_start();
if (isset($_SESSION['usuarioAuditar'])) {
    include_once 'config.php';
    include_once '../../../../clases/autoload.php';
    $DgoAnexosOrden      = new DgoAnexosOrden;
    $encriptar       = new Encriptar;
    $sqltable        = $encriptar->getEncriptar($DgoAnexosOrden->getSqlDgoAnexosOrden($_GET['id']), $_SESSION['usuarioAuditar']);
    $tgrid           = $directorio . '/grid.php'; // php para mostrar la grid
    $tforma          = $directorio . '/formulario.php'; // php para mostrar el formulario en la parte superior
    $tborra          = $directorio . '/borra.php'; // php para borrar un registro
    $tgraba          = $directorio . '/graba.php'; // php para grabar un registro
    $tprint          = $directorio . '/imprime.php'; // nombre del php que imprime los registros
?>
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
    include_once '../../../../js/ajaxuidGenerico.php';
    include_once 'validacion.php';
} else {
    header('Location: indexSiipne.php');
}

?>
<script>
    $(function() {
        $('#formAyuda').load('modulos/crearOrden/includes/formularioAyuda.php?bn=<?php echo $_GET['opc'] ?>&id=<?php echo (isset($_GET['id']) ? $_GET['id'] : 0) ?>');
    });
</script>

<script type="text/javascript" src="<?php echo '../' . $directorio ?>/validacion.js"></script>