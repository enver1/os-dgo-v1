<?php
session_start();
if (isset($_SESSION['usuarioAuditar'])) {
    include_once '../../../../clases/autoload.php';
    include_once 'config.php';
    $AsignaPersonalElec = new AsignaPersonalElec;
    $encriptar          = new Encriptar;
    $tgrid              = $directorio . '/grid.php'; // php para mostrar la grid
    $tforma             = $directorio . '/formulario.php'; // php para mostrar el formulario en la parte superior
    $tborra             = $directorio . '/borra.php'; // php para borrar un registro
    $tgraba             = $directorio . '/graba.php'; // php para grabar un registro
    $tprint             = $directorio . '/imprime.php'; // nombre del php que imprime los registros

    $idDgoPerAsigOpe = strip_tags($_GET['idR']);
    $sqltable        = $encriptar->getEncriptar($AsignaPersonalElec->getSqlAsignaPersonalElec($idDgoPerAsigOpe), $_SESSION['usuarioAuditar']);
?>
    <script type="text/javascript">
    </script>
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
    include 'validacion.php';
} else {
    header('Location: imprime.php');
}

?>
<script>
    $(function() {
        $('#formAyuda').load('modulos/verificacionPer/includes/formularioAyuda.php?bn=<?php echo $_GET['opc'] ?>&id=<?php echo (isset($_GET['idR']) ? $_GET['idR'] : 0) ?>');
    });
</script>