<?php
/* MUESTRA LA GRILLA EN LA PARTE INFERIOR DEL FORMULARIO */
include_once '../clases/autoload.php';
include_once 'config.php';
$obj = new GenModelo();
$gridS = $obj->getCampos();
$idcampo = $obj->getIdcampo();

include_once '../includes/datatablePaginado.php';