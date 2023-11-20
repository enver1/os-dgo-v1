<?php 
/*  Framework Siipne 3w Version 3.0 Generacion Automatica*/
/*	Todos los Derechos Reservados Alberto Arias M. Direccion Nacional de Comunicaciones de la Policia Nacional*/
/*	Configuracion de variables */
$tabla			='dgoCargo'; 			// ** Nombre de la Tabla
$directorio		='tcargo'; 				// ** Nombre del directorio donde se encuentra la aplicacion **
/* =====================================================================================================*/
$tgraba			=$directorio.'/graba.php'; 	// ** nombre del php para insertar o actualizar un registro
$directorioC	='modulos/'.$directorio; 	// ** Path del directorio ***

/*	FORMULARIO formulario.php
	Aqui se colocan los campos que van en el formulario de edicion de datos
	para cada campo se creara un arreglo por cada tipo de campo que contiene una serie de elementos
	los tipo de campo que se pueden usar son : text, combo, date, comboSQL, textArea, ComboArreglo

*/
$formulario=array(
1=>array(
	'tipo'=>'text',
	'etiqueta'=>'Descripcion',
	'campoTabla'=>'descDgoCargo',
	'ancho'=>'300',
	'maxChar'=>'70',
	'align'=>'left',
	'soloLectura'=>'false'),
	);

/*	GRABAR REGISTRO 
	En esta parte se configuran los campos que van as ser insertados o actualizados en la tabla con la siguiente
	estructura, se debe tomar en cuenta los campos que se actualizaran en el formulario 
	Nombre del campo  | 	Nombre del campo en 
	en la tabla     	|	el Formulario HTML  */
	
$tStructure=array(
'idDgoCargo'=>'idDgoCargo',
'descDgoCargo'=>'descDgoCargo',
	);
/* Campo de la tabla que permite evitar registros duplicados al momento de grabar
	Si no desea controlar duolicados deje en blanco el campo*/
$descripcion='';

/*	GRID 
	en esta seccion se define como va a estar compuesta la grilla del formulario 
	$sqltable	sql	Contiene la instruccion que genera una grilla paginada */
$sqltable=urlencode("select idDgoCargo, descDgoCargo from dgoCargo"); 

/*	La grilla es una tabla con filas y columnas, en la primera fila van lis titulos de los campos, luego van los registros
	Nombre del campo  | 	Nombre del campo en 
	en el grid     	|	en la tabla  */
$gridS=array('Código'=>'idDgoCargo',
'Descripcion'=>'descDgoCargo',
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
$sqlP="select idDgoCargo cero, descDgoCargo uno from dgoCargo";
$columnas				=2;
$anchoColumnas		='30,160';
$tituloColumnas		=array('Código','Descripcion');
$nombreReporte		='CATALOGOS TIPO DE CARGO'; 
$orientacion			='';

/*==================================================================================================*/
/****** Constantes SE MANTIENEN PARA TODOS **************/
$Ntabla				=$tabla;$sNtabla=$tabla; 	/* sinonimos para la tabla */
$idcampo				='id'.ucfirst($sNtabla); 	/* contruye el id de la tabla con el estandar del SIIPNE 3w*/

?>