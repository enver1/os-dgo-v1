<?php

$tabla       = 'goePunLleg'; // ** Nombre de la Tabla
$directorio  = 'puntosLlegada';
$directorioC = 'modulos/' . $directorio; // ** Path del directorio ***

$tgraba         =$directorio.'/graba.php'; 
$tprint     = $directorio . '/imprime.php';
$gridS = array(
    'Código'      => 'idGoePunLleg',
    'Descripción' => 'descGoePunLleg',
    'Latitud'     => 'latGoePunLleg',
    'Longitud'    => 'lonGoePunLleg',
    'Estado'      => 'descripcion',
);

$columnas       = 5;
$anchoColumnas  = '15,73,35,30,30';
$tituloColumnas = array('Código', 'Descripción', 'Latitud', 'Longitud','Estado');
$nombreReporte  = 'CATÁLOGO PUNTOS DE LLEGADA';
$orientacion    = '';
/*==================================================================================================*/
/****** Constantes SE MANTIENEN PARA TODOS **************/
$Ntabla  = $tabla;
$sNtabla = $tabla; /* sinonimos para la tabla */
$idcampo = 'id' . ucfirst($sNtabla); /* contruye el id de la tabla con el estandar del SIIPNE 3w*/
