<?php
/*  Framework Siipne 3w Version 3.0 Generacion Automatica*/
/*	Todos los Derechos Reservados Alberto Arias M. Direccion Nacional de Comunicaciones de la Policia Nacional*/
/*	Configuracion de variables */
$tabla			= 'dgoAsignacion'; 			// ** Nombre de la Tabla
$directorio		= 'asignacion'; 				// ** Nombre del directorio donde se encuentra la aplicacion **
/* =====================================================================================================*/
$tgraba			= $directorio . '/graba.php'; 	// ** nombre del php para insertar o actualizar un registro
$directorioC	= 'modulos/' . $directorio; 	// ** Path del directorio ***

/*	FORMULARIO formulario.php
	Aqui se colocan los campos que van en el formulario de edicion de datos
	para cada campo se creara un arreglo por cada tipo de campo que contiene una serie de elementos
	los tipo de campo que se pueden usar son : text, combo, date, comboSQL, textArea, ComboArreglo

*/

$arrayMeses = array(
	'1' => 'Enero',
	'2' => 'Febrero',
	'3' => 'Marzo',
	'4' => 'Abril',
	'5' => 'Mayo',
	'6' => 'Junio',
	'7' => 'Julio',
	'8' => 'Agosto',
	'9' => 'Septiembre',
	'10' => 'Octubre',
	'11' => 'Noviembre',
	'12' => 'Diciembre',
	'13' => 'Todos',
);

$formulario = array(
	array(
		'tipo' => 'hidden',
		'etiqueta' => 'IdGenPersona',
		'campoTabla' => 'idGenPersona',
		'ancho' => '300',
		'maxChar' => '',
		'align' => 'left',
		'soloLectura' => 'false'
	),

	array(
		'tipo' => 'hidden',
		'etiqueta' => 'Meses:',
		'campoTabla' => 'meses',
		'ancho' => '300',
		'maxChar' => '',
		'align' => 'left',
		'soloLectura' => 'true'
	),

	array(
		'tipo' => 'hidden',
		'etiqueta' => 'nomCursante',
		'campoTabla' => 'nomCursante',
		'ancho' => '300',
		'maxChar' => '',
		'align' => 'left',
		'soloLectura' => 'false'
	),

	array(
		'tipo' => 'hidden',
		'etiqueta' => 'docCursante',
		'campoTabla' => 'docCursante',
		'ancho' => '300',
		'maxChar' => '',
		'align' => 'left',
		'soloLectura' => 'false'
	),

	array(
		'tipo' => 'text',
		'etiqueta' => 'A&ntilde;o:',
		'campoTabla' => 'anio',
		'ancho' => '100',
		'maxChar' => '',
		'align' => 'left',
		'soloLectura' => 'false'
	),


	array(
		'tipo' => 'hidden',
		'etiqueta' => 'senplades',
		'campoTabla' => 'senplades',
		'ancho' => '300',
		'maxChar' => '',
		'align' => 'left',
		'soloLectura' => 'false'
	),

	array(
		'tipo' => 'arbol',
		'etiqueta' => 'Distribucion Senplades:',
		'campoTabla' => 'idGenGeoSenplades',
		'campoValor' => '',
		'tabla' => 'genGeoSenplades',
		'ancho' => '350'
	),

	array(
		'tipo' => 'checkArreglo',
		'etiqueta' => 'Meses:',
		'campoTabla' => 'meses',
		'columnas' => '6',
		'arreglo' => $arrayMeses,
		'onclick' => 'onclick="concatCheck()"'
	),
	array(
		'tipo'         => 'file',
		'etiqueta'     => '(*)Documento (Max 1000 Kbytes)',
		'campoTabla'   => 'documento',
		'pathFile'     => '../../../descargas/operaciones/asignacion/',
		'fileSize'     => '100000000',
		'fileTypes'    => 'pdf',
		'accept'       => 'pdf',
		'obligatorio'  => 'S',
		'campoTablaValida' => '',
		'nombreObjeto' => 'myfile'
	),
);

/*	GRABAR REGISTRO 
	En esta parte se configuran los campos que van as ser insertados o actualizados en la tabla con la siguiente
	estructura, se debe tomar en cuenta los campos que se actualizaran en el formulario 
	Nombre del campo  | 	Nombre del campo en 
	en la tabla     	|	el Formulario HTML  */

$tStructure = array(
	'idDgoAsignacion' => 'idDgoAsignacion',
	'idGenPersona' => 'idGenPersona',
	'idGenGeoSenplades' => 'idGenGeoSenplades',
	'meses' => 'meses',
	'anio' => 'anio',
	'senplades' => 'senplades',
);
/* Campo de la tabla que permite evitar registros duplicados al momento de grabar
	Si no desea controlar duolicados deje en blanco el campo*/
$descripcion = '';

/*	GRID 
	en esta seccion se define como va a estar compuesta la grilla del formulario 
	$sqltable	sql	Contiene la instruccion que genera una grilla paginada */

$sqlA = "select a.idDgoAsignacion,CONCAT_WS(' ', b.siglas, b.apenom) cursante, c.descripcion, c.siglasGeoSenplades, ";
$sqlA .= "CONCAT(IF(a.meses=1,'Enero, ',''),IF(a.meses LIKE '%2,%','Febrero, ',''),IF(a.meses LIKE '%3%','Marzo, ',''),IF(a.meses LIKE '%4%','Abril, ',''),IF(a.meses LIKE '%5%','Mayo, ',''),IF(a.meses LIKE '%6%','Junio, ',''),IF(a.meses LIKE '%7%','Julio, ',''),IF(a.meses LIKE '%8%','Agosto, ',''),IF(a.meses LIKE '%9%','Septiembre, ',''),IF(a.meses LIKE '%10%','Octubre, ',''),IF(a.meses LIKE '%11%','Noviembre, ',''),IF(a.meses LIKE '%12%','Diciembre','')) mesesAsig ";
$sqlA .= " from dgoAsignacion a, v_personal_simple b, genGeoSenplades c where a.idGenPersona = b.idGenPersona ";
$sqlA .= "and a.idGenGeoSenplades = c.idGenGeoSenplades and a.idGenPersona = ";

//echo $sqlA;
$sqltable = urlencode($sqlA);

/*	La grilla es una tabla con filas y columnas, en la primera fila van lis titulos de los campos, luego van los registros
	Nombre del campo  | 	Nombre del campo en 
	en el grid     	|	en la tabla  */
$gridS = array(
	'Código' => 'idDgoAsignacion',
	'Cursante' => 'cursante',
	'Unidad' => 'descripcion',
	'Nomenclatura' => 'siglasGeoSenplades',
	'Meses' => 'mesesAsig',
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
//$sqlP="select idDgoAsignacion cero, idGenPersona uno, idGenGeoSenplades dos, fechaIni tres, fechaFin cuatro, documento cinco from dgoAsignacion";

$sqlP = "select a.idDgoAsignacion cero, CONCAT_WS(' ', b.siglas, b.apenom) uno, c.descripcion dos, c.siglasGeoSenplades tres, ";
$sqlP .= "CONCAT(IF(a.meses LIKE '1%','Enero, ',''),IF(a.meses LIKE '%2,%','Febrero, ',''),IF(a.meses LIKE '%3%','Marzo, ',''),IF(a.meses LIKE '%4%','Abril, ',''),IF(a.meses LIKE '%5%','Mayo, ',''),IF(a.meses LIKE '%6%','Junio, ',''),IF(a.meses LIKE '%7%','Julio, ',''),IF(a.meses LIKE '%8%','Agosto, ',''),IF(a.meses LIKE '%9%','Septiembre, ',''),IF(a.meses LIKE '%10%','Octubre, ',''),IF(a.meses LIKE '%11%','Noviembre, ',''),IF(a.meses LIKE '%12%','Diciembre','')) cuatro ";
$sqlP .= " from dgoAsignacion a, v_personal_simple b, genGeoSenplades c where a.idGenPersona = b.idGenPersona ";
$sqlP .= "and a.idGenGeoSenplades = c.idGenGeoSenplades and a.idGenPersona = ";

$columnas				= 5;
$anchoColumnas		= '15,75,35,35,30';
$tituloColumnas		= array('Código', 'Cursante', 'Unidad', 'Nomenclatura', 'Meses');
$nombreReporte		= 'DETALLE ASIGNACIONES';
$orientacion			= '';

/*==================================================================================================*/
/****** Constantes SE MANTIENEN PARA TODOS **************/
$Ntabla				= $tabla;
$sNtabla = $tabla; 	/* sinonimos para la tabla */
$idcampo				= 'id' . ucfirst($sNtabla); 	/* contruye el id de la tabla con el estandar del SIIPNE 3w*/
