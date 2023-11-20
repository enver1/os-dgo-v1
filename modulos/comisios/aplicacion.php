<?php
if (isset($_SESSION['usuarioAuditar'])) {
    include_once '../clases/autoload.php';
    include_once 'config.php';
    $tgrid      = $directorio . '/grid.php'; // php para mostrar la grid
    $tforma     = $directorio . '/formulario.php'; // php para mostrar el formulario en la parte superior
    $tborra     = $directorio . '/borra.php'; // php para borrar un registro
    $tgraba     = $directorio . '/graba.php'; // php para grabar un registro
    $tprint     = $directorio . '/imprime.php'; // nombre del php que imprime los registros
    $sqltable="";
    ?>
<div id='formulario'>
    <img src="../funciones/paginacion/images/ajax-loader.gif" />
</div>

<?php include_once '../js/ajaxuidG.php'; // Este archivo contiene las funciones de ajax para update, insert, delete, y edit
} else {
    header('Location: indexSiipne.php');
}

?>
<script type="text/javascript" src="<?php echo '../' . $directorio ?>/validacionA.js"></script>