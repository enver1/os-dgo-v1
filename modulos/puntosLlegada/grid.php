<?php
/* MUESTRA LA GRILLA EN LA PARTE INFERIOR DEL FORMULARIO */
include_once 'config.php';
include '../clases/claseGridDgoAlertaSenderoSeguro.php';
$grid = new GridDgoAlertaSenderoSeguro;
$grid->idcampo = $idcampo;
if (!empty($rs)) {
    echo $grid->showGridTareas( $gridS, $rs, true, true,true,true);
}