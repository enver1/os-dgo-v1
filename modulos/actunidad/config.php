<?php 
/*  Framework Siipne 3w Version 3.0 Generacion Automatica*/
/*	Todos los Derechos Reservados Alberto Arias M. Direccion Nacional de Comunicaciones de la Policia Nacional*/
/*	Configuracion de variables */
$tabla			='dgoActUnidad'; 			// ** Nombre de la Tabla
$directorio		='actunidad'; 				// ** Nombre del directorio donde se encuentra la aplicacion **
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
	'tipo'=>'comboSQL',
	'etiqueta'=>'Proceso Supervision',
	'tabla'=>'dgoProcSuper',
	'campoTabla'=>'idDgoProcSuper',
	'ancho'=>'300',
	'sql'=>'select idDgoProcSuper,descripcion from dgoProcSuper where idGenEstado=1',
	'soloLectura'=>'false',
	'onclick'=>''),
2=>array(
	'tipo'=>'arbol',
	'etiqueta'=>'Unidad',
	'campoTabla'=>'idDgpUnidad',
	'campoValor'=>'descUnidad',
	'tabla'=>'dgpUnidad'),
3=>array(
	'tipo'=>'text',
	'etiqueta'=>'Descripcion',
	'campoTabla'=>'descDgoActUnidad',
	'ancho'=>'300',
	'maxChar'=>'50',
	'align'=>'left',
	'soloLectura'=>'false'),
4=>array(
	'tipo'=>'text',
	'etiqueta'=>'Recurso Humano',
	'campoTabla'=>'recursoHumano',
	'ancho'=>'300',
	'maxChar'=>'70',
	'align'=>'left',
	'soloLectura'=>'false'),
5=>array(
	'tipo'=>'text',
	'etiqueta'=>'Recurso Material',
	'campoTabla'=>'recursoMaterial',
	'ancho'=>'300',
	'maxChar'=>'70',
	'align'=>'left',
	'soloLectura'=>'false'),
6=>array(
	'tipo'=>'text',
	'etiqueta'=>'Recurso Financiero',
	'campoTabla'=>'recursoFinanciero',
	'ancho'=>'300',
	'maxChar'=>'70',
	'align'=>'left',
	'soloLectura'=>'false'),
7=>array(
	'tipo'=>'date',
	'etiqueta'=>'Fecha Plazo Inicial',
	'campoTabla'=>'fechaInicio',
	'ancho'=>'100',
	'maxChar'=>'',
	'soloLectura'=>'true'),
8=>array(
	'tipo'=>'date',
	'etiqueta'=>'Fecha Plazo Final',
	'campoTabla'=>'fechaFin',
	'ancho'=>'100',
	'maxChar'=>'',
	'soloLectura'=>'true'),
	);

/*	GRABAR REGISTRO 
	En esta parte se configuran los campos que van as ser insertados o actualizados en la tabla con la siguiente
	estructura, se debe tomar en cuenta los campos que se actualizaran en el formulario 
	Nombre del campo  | 	Nombre del campo en 
	en la tabla     	|	el Formulario HTML  */
	
$tStructure=array(
'idDgoActUnidad'=>'idDgoActUnidad',
'idDgoProcSuper'=>'idDgoProcSuper',
'idDgpUnidad'=>'idDgpUnidad',
'descDgoActUnidad'=>'descDgoActUnidad',
'recursoHumano'=>'recursoHumano',
'recursoMaterial'=>'recursoMaterial',
'recursoFinanciero'=>'recursoFinanciero',
'fechaInicio'=>'fechaInicio',
'fechaFin'=>'fechaFin',
	);
/* Campo de la tabla que permite evitar registros duplicados al momento de grabar
	Si no desea controlar duolicados deje en blanco el campo*/
$descripcion='idDgoProcSuper,idDgpUnidad';

/*	GRID 
	en esta seccion se define como va a estar compuesta la grilla del formulario 
	$sqltable	sql	Contiene la instruccion que genera una grilla paginada */
$sqltable=urlencode("select idDgoActUnidad, b.descripcion proceso, nomenclatura unidad, descDgoActUnidad, recursoHumano, recursoMaterial, recursoFinanciero, a.fechaInicio, a.fechaFin from dgoActUnidad a,dgoProcSuper b,dgpUnidad c where a.idDgoProcSuper=b.idDgoProcSuper and a.idDgpUnidad=c.idDgpUnidad "); 

/*	La grilla es una tabla con filas y columnas, en la primera fila van lis titulos de los campos, luego van los registros
	Nombre del campo  | 	Nombre del campo en 
	en el grid     	|	en la tabla  */
$gridS=array('Código'=>'idDgoActUnidad',
'Proceso Supervision'=>'proceso',
'Unidad'=>'unidad',
'Descripcion'=>'descDgoActUnidad',
'Recurso Humano'=>'recursoHumano',
'Recurso Material'=>'recursoMaterial',
'Fecha Inicio'=>'fechaInicio',
'Fecha Fin'=>'fechaFin',
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
$sqlP="select idDgoActUnidad cero, idDgoProcSuper uno, idDgpUnidad dos, descDgoActUnidad tres, recursoHumano cuatro, recursoMaterial cinco, recursoFinanciero seis, fechaInicio siete, fechaFin ocho from dgoActUnidad";
$columnas				=8;
$anchoColumnas		=',,,,,,,';
$tituloColumnas		=array('Código','Proceso Supervision','Unidad','Descripcion','Recurso Humano','Recurso Material','Recurso Financiero','Fecha Inicio');
$nombreReporte		=''; 
$orientacion			='';

/*==================================================================================================*/
/****** Constantes SE MANTIENEN PARA TODOS **************/
$Ntabla				=$tabla;$sNtabla=$tabla; 	/* sinonimos para la tabla */
$idcampo				='id'.ucfirst($sNtabla); 	/* contruye el id de la tabla con el estandar del SIIPNE 3w*/

?>