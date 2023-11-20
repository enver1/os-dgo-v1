<?php
/**
 * verificar la sessi�n
 */
if (!isset($_SESSION)) { session_start(); }

/**
 * obtener librerias necesarias para la ejecuci�n
 */
include_once('../../../../clases/autoload.php');
include_once("../../../../fpdf/fpdf.php");
include_once('../../../../funciones/clasePDF.php');
$nombreReporte='HOJA DE RUTA';

$title='www.policiaecuador.gob.ec/siipne3';

$pdf=new PDF();

$pdf->imagen='../../../../imagenes/sellopolicia.jpg';

/**
 * pagina horizontal
 */
$pdf->AddPage('L');
$pdf->SetFont('Arial','',14);
$pdf->Ln();
$pdf->titulo('SISTEMA INFORMATICO INTEGRADO SIIPNE 3w',14,255,255,255);
$pdf->titulo($nombreReporte,12,200,220,255,'C');

/**
 * datos para la cabecera
 */
$sql="SELECT 
    a.*,
    c.descGestionAdmin nomenclatura
  FROM
    hdrRuta a 
    INNER JOIN genActividadGA b 
      ON a.idGenActividadGA = b.idGenActividadGA 
    INNER JOIN genGestionAdmin c 
      ON b.idGenGestionAdmin = c.idGenGestionAdmin 
  WHERE SHA1(idHdrRuta) = '".$_REQUEST['recno']."'";
$rs=$conn->query($sql);
$rowt=$rs->fetch();

/**
 * Arreglo de dias de la semana
 * @var array
 */
$arrayDias =array ("Lunes", "Martes", "Mi�rcoles", "Jueves", "Viernes", "S�bado","Domingo");

/**
 * arreglo que contedra la fecha de inicio particionada del phva
 * [0] = a;o
 * [1] = mes
 * [2] = dia
 * @var array
 */
$diaIni = explode('-', $rowt['fechaHdrRutaInicio']);

/**
 * arreglo que contedra la fecha de fin particionada del phva
 * [0] = a;o
 * [1] = mes
 * [2] = dia
 * @var array
*/
$diaFin = explode('-', $rowt['fechaHdrRutaFin']);

/**
 * Numero del d�a de la semana de la fecha inicial
 * La opcion date('N') me devuelve 1 - 7
 * por eso deberia ser -1 para que coincida con mi arreglo
 * @var number
 */
$numInicio = date('N',mktime(0, 0, 0, $diaIni[1]  , $diaIni[2], $diaIni[0])) - 1;

/**
 * Numero del d�a de la semana de la fecha final
 * La opcion date('N') me devuelve 1 - 7
 * por eso deberia ser -1 para que coincida con mi arreglo
 * @var number
 */
$numFin = date('N',mktime(0, 0, 0, $diaFin[1]  , $diaFin[2], $diaFin[0])) - 1;

$pdf->SetFont('Arial','',12);
// $pdf->Ln();
$pdf->Text(10,50,"UNIDAD");
$pdf->SetFont('Arial','',10);
$pdf->Text(45,50,$rowt['nomenclatura']);
$pdf->SetFont('Arial','',12);
$pdf->Ln();
$pdf->Text(10,55,"FECHA INICIO");
$pdf->SetFont('Arial','',10);
$pdf->Text(45,55,$arrayDias[$numInicio].' '.$diaIni[2].' de '.mes($diaIni[1],1).' de '.$diaIni[0].' a las '.$rowt['horarioInicio']);
$pdf->SetFont('Arial','',12);
$pdf->Ln();
$pdf->Text(130,55,"FECHA FIN");
$pdf->SetFont('Arial','',10);
$pdf->Text(160,55,$arrayDias[$numFin].' '.$diaFin[2].' de '.mes($diaFin[1],1).' de '.$diaFin[0].' a las '.$rowt['horarioFin']);
$pdf->SetFont('Arial','',12);

$pdf->SetFont('Arial','',10);

/**
 * sentencia de recursos
 */
$sql = "SELECT 
  a.idHdrRecurso AS 'cero',
  a.nominativo AS 'uno',
  d.placa AS 'dos',
  a.telefonoRecurso AS 'tres',
  a.radioRecurso AS 'cuatro',
  a.obsHdrRecurso AS 'cinco',
  b.descripcion AS 'seis' 
FROM
  hdrRecurso a,
  hdrEstadoRecurso b,
  hdrVehiculo c,
  genVehiculo d
WHERE a.idHdrEstadoRecurso = b.idHdrEstadoRecurso 
  AND c.idGenVehiculo = d.idGenVehiculo
  AND a.idHdrVehiculo = c.idHdrVehiculo 
  AND sha1(a.idHdrRuta)='{$_REQUEST['recno']}' 
UNION
SELECT a.idHdrRecurso AS 'cero', a.nominativo AS 'uno', '-' AS 'dos', a.telefonoRecurso AS 'tres', a.radioRecurso AS 'cuatro', a.obsHdrRecurso AS 'cinco', b.descripcion AS 'seis' 
FROM hdrRecurso a, hdrEstadoRecurso b 
WHERE a.idHdrEstadoRecurso = b.idHdrEstadoRecurso AND sha1(a.idHdrRuta)='{$_REQUEST['recno']}' AND ISNULL(a.idHdrVehiculo)";

/**
 * datos obtenidos de la consulta
 */
$rs=$conn->query($sql);
$arrSql = $rs->fetchAll();

$data = array();

foreach ($arrSql as $row){
	$rowData = array();
	
	$rowData['cero']=$row['cero'];
	$rowData['uno']=$row['uno'];
	$rowData['dos']=$row['dos'];
	$rowData['tres']=$row['tres'];
	$rowData['cuatro']=$row['cuatro'];
	
	/**
	 * datos de la columna cinco
	 */
	$sqlPersonal="SELECT CONCAT(p.siglas,' ', p.apenom,' - ', f.descripcion)AS'personal'
	FROM v_persona p, hdrIntegrante i, hdrFuncion f
	WHERE i.idHdrFuncion=f.idHdrFuncion AND i.idGenPersona=p.idGenPersona AND i.idHdrRecurso='{$row['cero']}'";
		
	$rsPersonal=$conn->query($sqlPersonal);
	$arrSqlPersonal = $rsPersonal->fetchAll();
		
	/**
	 * string
	 */
	$html = "";
	
	foreach($arrSqlPersonal as $rowPersonal){
		$html .= $rowPersonal['personal'].', ';
	}
	
	$rowData['cinco']=$html;
	/**
	 * datos de la columna 6
	 */
	$sqlSector="SELECT GROUP_CONCAT(genGeoSenplades.descripcion)AS'sectorPatrulla' FROM genGeoSenplades
	INNER JOIN hdrSectorPatrulla ON genGeoSenplades.idGenGeoSenplades = hdrSectorPatrulla.idGenGeoSenplades
	WHERE hdrSectorPatrulla.idHdrRecurso = '{$row['cero']}'";
	$rsSector = $conn->query($sqlSector);
		
	/**
	 * string
	 */
	$html = "";
	
	while($rowSector = $rsSector->fetch(PDO::FETCH_ASSOC)){
		$html .= $rowSector['sectorPatrulla'];
	}
	
	$rowData['seis']=$html;
	$rowData['siete']=$row['cinco'];
	$rowData['ocho']=$row['seis'];
	
	$data[] = $rowData;
}

$header = array('CODIGO','NOMINATIVO','PLACA','TELEFONO','RADIO','RECURSOS','SECTOR','OBSERVACION','ESTADO');

$pdf->FancyTable($header,$data,200,220,255,0,9,15,40,20,25,15,67,40,30,25);

/**
 * obtener pdf
 */
$pdf->Output();

/**
 * obtiene el mes en palabras
 * @param unknown $meses
 * @param unknown $tipo
 * @return Ambigous <string>
 */
function mes($meses, $tipo)
{
	//1 = Meses con escritura completa
	//2 = Meses en abreviatura
	switch ($tipo){
		case 1:
			$array_meses1 =array ("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre",
			"Noviembre", "Diciembre");
			break;
		case 2:
			$array_meses1 =array ("Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic");
			break;
	}
	return $array_meses1[$meses-1];
}
