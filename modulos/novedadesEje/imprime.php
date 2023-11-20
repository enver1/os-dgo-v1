<?php
session_start();
include_once('../../../clases/autoload.php');
include_once('../../../fpdf/fpdf.php');
include_once('../../../funciones/clasePDF.php');
$nombreReporte = 'CATÁLOGO DE APLICACIONES DEL USUARIO';
/* Contiene la instruccion select que trae los datos de la tabla */
$conn = DB::getConexionDB();
$sql = "select 
	d.descripcion cero,
	b.descripcion uno,
	c.descripcion dos,
	concat('[',case insercion when 1 then 'Upd' else '   ' end,'] [',case modificacion when 1 then 'Ins' else '   ' end,'] [',
	case eliminacion when 1 then 'Del' else '   ' end,'] [',case consulta when 1 then 'Con' else '   ' end,']') tres,
	concat(apellido1,' ',apellido2,' ',nombre1,' ',nombre2) nombres
	from genUsuarioAplicacion a,genAplicacion b,genEstado c,genModulo d,v_usuario e
	where a.idGenAplicacion=b.idGenAplicacion and a.idGenEstado=c.idGenEstado and b.idGenModulo=d.idGenModulo 
	and a.idGenUsuario=e.idGenUsuario and a.idGenUsuario=" . (isset($_GET['usuario']) ? $_GET['usuario'] : 0) . "
	order by 1,2 ";

$rs = $conn->query($sql);
$row = $rs->fetchAll();
$rs = $conn->query($sql);
$rowt = $rs->fetch();

$title = 'www.policiaecuador.gob.ec/siipne3';

$pdf = new PDF();
//$pdf->AddPage('L'); //si Queremos tipo landscape horizontal
$pdf->AddPage();
$pdf->SetFont('Arial', '', 14);
$pdf->Ln();
//$pdf->WriteHTML('');
$pdf->titulo('SISTEMA INFORMÁTICO INTEGRADO SIIPNE 3w', 14, 255, 255, 255);
$pdf->titulo($nombreReporte, 12, 200, 220, 255, 'C');
$pdf->SetFont('Arial', '', 10);
$st = array('Usuario:' => $rowt['nombres']);
$pdf->BasicTable($st, 15, 200, 9);
$header = array('Módulo', 'Aplicación', 'Estado', 'Permisos');
$pdf->FancyTable($header, $row, 200, 220, 255, 0, 4, 60, 60, 20, 40);



$pdf->Output();
