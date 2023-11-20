<?php
/*  Framework Siipne 3w Version 3.0 Generacion Automatica*/
/*	Todos los Derechos Reservados Alberto Arias M. Direccion Nacional de Comunicaciones de la Policia Nacional*/
/*	Configuracion de variables */
$tabla			= 'dgoEjeProcSu'; 			// ** Nombre de la Tabla
$directorioMantenimiento = __FILE__;
$elementos               = explode('/', $directorioMantenimiento);
$directorioModulo        = $elementos[3] . '/' . $elementos[4] . '/' . $elementos[5];
$directorio              = $directorioModulo; // ** Nombre del directorio donde se encuentra la aplicacion **
$formulario = array(
	2 => array(
		'tipo' => 'combo',
		'etiqueta' => 'Proceso Supervision',
		'tabla' => 'dgoProcSuper',
		'campoTabla' => 'idDgoProcSuper',
		'campoValor' => 'descripcion',
		'soloLectura' => 'false',
		'ancho' => '300'
	),
	1 => array(
		'tipo' => 'combo',
		'etiqueta' => 'Eje',
		'tabla' => 'dgoEje',
		'campoTabla' => 'idDgoEje',
		'campoValor' => 'descDgoEje',
		'soloLectura' => 'false',
		'ancho' => '300'
	),
	3 => array(
		'tipo' => 'textArea',
		'etiqueta' => 'Objetivo Especifico',
		'campoTabla' => 'objEspecifico',
		'maxChar' => '300',
		'ancho' => '300',
		'alto' => '',
		'soloLectura' => 'false'
	),
	4 => array(
		'tipo' => 'textArea',
		'etiqueta' => 'Estrategia',
		'campoTabla' => 'estrategia',
		'maxChar' => '300',
		'ancho' => '300',
		'alto' => '',
		'soloLectura' => 'false'
	),
	5 => array(
		'tipo' => 'textArea',
		'etiqueta' => 'Objetivo Operativo',
		'campoTabla' => 'objOperativo',
		'maxChar' => '300',
		'ancho' => '300',
		'alto' => '',
		'soloLectura' => 'false'
	),
);

/*	GRABAR REGISTRO 
	En esta parte se configuran los campos que van as ser insertados o actualizados en la tabla con la siguiente
	estructura, se debe tomar en cuenta los campos que se actualizaran en el formulario 
	Nombre del campo  | 	Nombre del campo en 
	en la tabla     	|	el Formulario HTML  */

$tStructure = array(
	'idDgoEjeProcSu' => 'idDgoEjeProcSu',
	'idDgoEje' => 'idDgoEje',
	'idDgoProcSuper' => 'idDgoProcSuper',
	'objEspecifico' => 'objEspecifico',
	'estrategia' => 'estrategia',
	'objOperativo' => 'objOperativo',
);
/* Campo de la tabla que permite evitar registros duplicados al momento de grabar
	Si no desea controlar duolicados deje en blanco el campo*/
$descripcion = 'idDgoEje,idDgoProcSuper';

/*	GRID 
	en esta seccion se define como va a estar compuesta la grilla del formulario 
	$sqltable	sql	Contiene la instruccion que genera una grilla paginada */
$sqlT = "SELECT idDgoEjeProcSu, b.descDgoEje idDgoEje, c.descripcion idDgoProcSuper, objEspecifico, estrategia, objOperativo 
from dgoEjeProcSu a,dgoEje b,dgoProcSuper c where a.idDgoEje=b.idDgoEje and a.idDgoProcSuper=c.idDgoProcSuper";

/*	La grilla es una tabla con filas y columnas, en la primera fila van lis titulos de los campos, luego van los registros
	Nombre del campo  | 	Nombre del campo en 
	en el grid     	|	en la tabla  */
$gridS = array(
	'Código' => 'idDgoEjeProcSu',
	'Eje' => 'idDgoEje',
	'Proceso Supervision' => 'idDgoProcSuper',
	'Objetivo Especifico' => 'objEspecifico',
	'Estrategia' => 'estrategia',
	'Objetivo Operativo' => 'objOperativo',
);

/*	IMPRESION DE DATOS
	Cada campo que se incluye en el select debe tener un alias que inicia con cero, uno, dos, tres, .. hasta el nueve
	es decir que la impresion puede tene maximo 10 campos
 	Variables 
	$columnas 			int 		Numero de columnas que se imprimiran coincide con los campos  del select anterior ej: 3  
	$anchoColumnas 	varchar 	Determina el ancho de cada columna a imprimir en el reporte separado por comas 
									ej: 100,30,50 La sumatoria de los anchos de las columnas es maximo 190 para 
									reportes verticales y de 277 para reportes horizontales 
	$tituloColumnas 	array  	Titulode de las columnas en el reporte
	$nombreReporte 	varchar Titulo del reporte
	$orientacion		char 	Orientacion delS reporte para modo vertical deje en blanco y para modo horizontal ponga L
*/
$sqlP = "select idDgoEjeProcSu cero, idDgoEje uno, idDgoProcSuper dos, objEspecifico tres, estrategia cuatro, objOperativo cinco from dgoEjeProcSu";
$columnas				= 5;
$anchoColumnas		= '15,20,40,60,60';
$tituloColumnas		= array('Código', 'Eje', 'Proceso Supervision', 'Objetivo Especifico', 'Objetivo Operativo');
$nombreReporte		= 'Reporte Eje por proceso';
$orientacion			= '';

/*==================================================================================================*/
/****** Constantes SE MANTIENEN PARA TODOS **************/
$Ntabla				= $tabla;
$sNtabla = $tabla; 	/* sinonimos para la tabla */
$idcampo				= 'id' . ucfirst($sNtabla); 	/* contruye el id de la tabla con el estandar del SIIPNE 3w*/
