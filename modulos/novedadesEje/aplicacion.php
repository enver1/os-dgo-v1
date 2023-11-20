<?php

if (isset($_SESSION['usuarioAuditar'])) {
    include_once '../clases/autoload.php';
    include_once 'config.php';
    $NovedadesEje = new NovedadesEje;
    $encriptar    = new Encriptar;
    $tgrid        = $directorio . '/grid.php'; // php para mostrar la grid
    $tforma       = $directorio . '/formulario.php'; // php para mostrar el formulario en la parte superior
    $tborra       = $directorio . '/borra.php'; // php para borrar un registro
    $tgraba       = $directorio . '/graba.php'; // php para grabar un registro
    $tprint       = $directorio . '/imprime.php'; // nombre del php que imprime los registros

    $sqltable = $encriptar->getEncriptar($NovedadesEje->getSqlNovedadesEje(), $_SESSION['usuarioAuditar']);
?>
    <script type="text/javascript">
    </script>
    <div id='formulario'>
        <img src="../../../funciones/paginacion/images/ajax-loader.gif" />
    </div>
    <div id='retrieved-data'>
        <img src="../../../funciones/paginacion/images/ajax-loader.gif" />
    </div>
<?php
    include_once '../js/ajaxuidGenerico.php';
} else {
    header('Location: imprime.php');
}

?>
<script type="text/javascript" src="<?php echo '../' . $directorio ?>/validacionA.js"></script>