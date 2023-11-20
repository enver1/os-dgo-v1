<?php
session_start();
include_once('../../../clases/autoload.php');
$conn = DB::getConexionDB();
include_once("../../../fpdf/fpdf.php");
include_once('../../../funciones/clasePDF.php');
$usuario = $_SESSION['usuarioAuditar'];
/* Redefinicion de algunas funciones de la clase pdf */
$firsTime = true;
class pdfM extends PDF
{

	// Margins
	var $left = 10;
	var $right = 10;
	var $top = 10;
	var $bottom = 10;

	// Create Table
	function WriteTable($tcolums)
	{
		// go through all colums
		for ($i = 0; $i < sizeof($tcolums); $i++) {
			$current_col = $tcolums[$i];
			$height = 0;

			// get max height of current col
			$nb = 0;
			for ($b = 0; $b < sizeof($current_col); $b++) {
				// set style
				$this->SetFont($current_col[$b]['font_name'], $current_col[$b]['font_style'], $current_col[$b]['font_size']);
				$color = explode(",", $current_col[$b]['fillcolor']);
				$this->SetFillColor($color[0], $color[1], $color[2]);
				$color = explode(",", $current_col[$b]['textcolor']);
				//	$this->SetTextColor($color[0], $color[1], $color[2]);
				$color = explode(",", $current_col[$b]['drawcolor']);
				$this->SetDrawColor($color[0], $color[1], $color[2]);
				$this->SetLineWidth($current_col[$b]['linewidth']);

				$nb = max($nb, $this->NbLines($current_col[$b]['width'], $current_col[$b]['text']));
				$height = $current_col[$b]['height'];
			}
			$h = $height * $nb;


			// Issue a page break first if needed
			$this->CheckPageBreak($h);

			// Draw the cells of the row
			for ($b = 0; $b < sizeof($current_col); $b++) {
				$w = $current_col[$b]['width'];
				$a = $current_col[$b]['align'];

				// Save the current position
				$x = $this->GetX();
				$y = $this->GetY();

				// set style
				$this->SetFont($current_col[$b]['font_name'], $current_col[$b]['font_style'], $current_col[$b]['font_size']);
				$color = explode(",", $current_col[$b]['fillcolor']);
				$this->SetFillColor($color[0], $color[1], $color[2]);
				$color = explode(",", $current_col[$b]['textcolor']);
				//	$this->SetTextColor($color[0], $color[1], $color[2]);
				$color = explode(",", $current_col[$b]['drawcolor']);
				$this->SetDrawColor($color[0], $color[1], $color[2]);
				$this->SetLineWidth($current_col[$b]['linewidth']);

				$color = explode(",", $current_col[$b]['fillcolor']);
				$this->SetDrawColor($color[0], $color[1], $color[2]);


				// Draw Cell Background
				$this->Rect($x, $y, $w, $h, 'FD');

				$color = explode(",", $current_col[$b]['drawcolor']);
				$this->SetDrawColor($color[0], $color[1], $color[2]);

				// Draw Cell Border
				if (substr_count($current_col[$b]['linearea'], "T") > 0) {
					$this->Line($x, $y, $x + $w, $y);
				}

				if (substr_count($current_col[$b]['linearea'], "B") > 0) {
					$this->Line($x, $y + $h, $x + $w, $y + $h);
				}

				if (substr_count($current_col[$b]['linearea'], "L") > 0) {
					$this->Line($x, $y, $x, $y + $h);
				}

				if (substr_count($current_col[$b]['linearea'], "R") > 0) {
					$this->Line($x + $w, $y, $x + $w, $y + $h);
				}


				// Print the text
				$this->MultiCell($w, $current_col[$b]['height'], $current_col[$b]['text'], 0, $a, 0);

				// Put the position to the right of the cell
				$this->SetXY($x + $w, $y);
			}

			// Go to the next line
			$this->Ln($h);
		}
	}


	// If the height h would cause an overflow, add a new page immediately
	function CheckPageBreak($h)
	{
		if ($this->GetY() + $h > $this->PageBreakTrigger)
			$this->AddPage($this->CurOrientation);
	}


	// Computes the number of lines a MultiCell of width w will take
	function NbLines($w, $txt)
	{
		$cw = &$this->CurrentFont['cw'];
		if ($w == 0)
			$w = $this->w - $this->rMargin - $this->x;
		$wmax = ($w - 2 * $this->cMargin) * 1000 / $this->FontSize;
		$s = str_replace("\r", '', $txt);
		$nb = strlen($s);
		if ($nb > 0 and $s[$nb - 1] == "\n")
			$nb--;
		$sep = -1;
		$i = 0;
		$j = 0;
		$l = 0;
		$nl = 1;
		while ($i < $nb) {
			$c = $s[$i];
			if ($c == "\n") {
				$i++;
				$sep = -1;
				$j = $i;
				$l = 0;
				$nl++;
				continue;
			}
			if ($c == ' ')
				$sep = $i;
			$l += $cw[$c];
			if ($l > $wmax) {
				if ($sep == -1) {
					if ($i == $j)
						$i++;
				} else
					$i = $sep + 1;
				$sep = -1;
				$j = $i;
				$l = 0;
				$nl++;
			} else
				$i++;
		}
		return $nl;
	}
	/* Clase para dibujar celdas personalizadas*/
	function FTableCols($data, $hr = 0, $hg = 20, $hb = 0, $tx = 255, $ncols = 4, $col1 = 20, $col2 = 40, $col3 = 90, $col4 = 20, $col5 = 0, $col6 = 0, $align = 'L,L,L,L,L,L', $f = 'Arial', $t = '', $sz = '12', $num = false, $red = false, $cols = 0, $bor = 'T', $alinea = 'C,C,C,C,C,C,C,C', $alto = 3.8)
	{
		$this->SetFillColor($hr, $hg, $hb);
		$this->SetTextColor($tx);
		$this->SetDrawColor($hr, $hg, $hb);
		$this->SetLineWidth(.2);

		$this->SetWidths(array($col1, $col2, $col3, $col4, $col5, $col6));
		$w = array($col1, $col2, $col3, $col4, $col5, $col6);
		$this->RowTCols($data, $align, $num, $red, $cols, $alinea, $alto, $t, $sz);
		$this->Cell(array_sum($w), 0, '', $bor);
	}
	function RowTCols($data, $align = 'C', $num = false, $fill = false, $cols = 4, $alinea, $alto, $fontStyle = '', $fontSize = '')
	{ //Calcula el alto de la fila
		$Aaline = explode(',', $align);
		$aFontSt = explode(',', $fontStyle);
		$aFontSz = explode(',', $fontSize);
		$nb = 0;
		for ($i = 0; $i < count($data); $i++) {
			//		 echo $i;
			$nb = max($nb, $this->NbLines($this->widths[$i], $data[$i]));
		}
		$h = $alto * $nb;
		//Si necesita antes un salto de pagina
		$this->CheckPageBreak($h);
		//Dibuja la celda de la fila
		for ($i = 0; $i < count($data); $i++) {
			$w = $this->widths[$i];
			$a = isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
			$x = $this->GetX();
			$y = $this->GetY();
			$this->Rect($x, $y, $w, $h);
			//Dibuja el borde
			$this->SetFont('Arial', $aFontSt[$i], $aFontSz[$i]);
			$this->MultiCell($w, 4, $data[$i], 0, $Aaline[$i]);
			//Pone el cursor a la derecha de la celda
			$this->SetXY($x + $w, $y);
		}
		//Va a la siguiente linea
		$this->Ln($h);
	}
	function imprimeCabecera($nomProceso, $nomenclatura, $descDgoEje)
	{
		$this->Image("../../../imagenes/logoPN.jpg", 50, 5, 205, 21, '', '');
		$this->SetFont('Arial', '', 14);
		$this->Ln();
		$this->titulo('SISTEMA INFORMÁTICO INTEGRADO SIIPNE 3w', 12, 255, 255, 255, 'C', 4, 2);
		$this->titulo('DIRECCION GENERAL DE OPERACIONES', 12, 255, 255, 255, 'C', 4, 2);
		$this->titulo($nomProceso, 11, 255, 255, 255, 'C', 4, 2);
		$linea = array('UNIDAD: ', $nomenclatura, 'EJE: ', $descDgoEje);
		$this->FTableCols($linea, 255, 255, 255, 0, 2, 50, 90, 50, 90, 0, 0, 'R,L,R,L,C,C', 'Arial', 'B,,B,,,', '12,10,12,10,9,9,9');
		$this->Ln(1);

		$this->SetDrawColor(0, 0, 0);
		$this->SetLineWidth(0.3);
		$xax = ($this->GetY());
		$this->Line(10, $xax, 285, $xax);
		$this->Ln(2);
	}
	function imprimeObjetivos($objEspecifico, $estrategia, $objOperativo)
	{
		$linea = array('OBJETIVO ESPECIFICO:', $objEspecifico);
		$this->FTableCols($linea, 255, 255, 255, 0, 2, 80, 195, 0, 0, 0, 0, 'R,J,C,C,C,C', 'Arial', 'B,,,,,', '8,8,9,9,9,9,9');
		$this->Ln(1);
		$linea = array('ESTRATEGIA AL OBJETIVO ESPECIFICO:', $estrategia);
		$this->FTableCols($linea, 255, 255, 255, 0, 2, 80, 195, 0, 0, 0, 0, 'R,L,C,C,C,C', 'Arial', 'B,,,,,', '8,8,9,9,9,9,9');
		$this->Ln(1);
		$linea = array('OBJETIVO OPERATIVO:', $objOperativo);
		$this->FTableCols($linea, 255, 255, 255, 0, 2, 80, 195, 0, 0, 0, 0, 'R,L,C,C,C,C', 'Arial', 'B,,,,,', '8,8,9,9,9,9,9');
		$this->Ln();
		$this->SetDrawColor(0, 0, 0);
		$this->SetLineWidth(0.2);
		$xax = ($this->GetY());
		$this->Line(10, $xax, 285, $xax);
		$this->Ln(2);
	}
	function imprimeResponsable($responsable)
	{
		$this->Ln(20);
		$this->SetDrawColor(0, 0, 0);
		$this->SetLineWidth(0.3);
		$xax = ($this->GetY());
		$this->Line(100, $xax, 195, $xax);
		$this->MultiCell(277, 4, $responsable, 0, 'C', false);
		$this->SetFont('Arial', 'B', 7);
		$this->MultiCell(277, 3, 'RESPONSABLE(S) DE LA SUPERVISIÓN', 0, 'C', false);
	}
}
/* FIN DE LA REDEFINICION DE LA CLASE PDF */
$visita = 0;
/* Arreglo con los valores DESDE Y HASTA,  para determinar cual grafico muestra dependiendo del puntaje obtenido sobre 100 puntos */
$cmi = array(
	0 => array('desde' => 0, 'hasta' => 12,),
	1 => array('desde' => 12, 'hasta' => 20,),
	2 => array('desde' => 20, 'hasta' => 30,),
	3 => array('desde' => 30, 'hasta' => 38,),
	4 => array('desde' => 38, 'hasta' => 45,),
	5 => array('desde' => 45, 'hasta' => 55,),
	6 => array('desde' => 55, 'hasta' => 65,),
	7 => array('desde' => 65, 'hasta' => 72,),
	8 => array('desde' => 72, 'hasta' => 80,),
	9 => array('desde' => 80, 'hasta' => 88,),
	10 => array('desde' => 88, 'hasta' => 95,),
	11 => array('desde' => 95, 'hasta' => 101,),
);

/*UNIDAD*/
$sqlU = "SELECT b.nomenclatura FROM dgoActUnidad a, dgpUnidad b 
WHERE a.idDgpUnidad=b.idDgpUnidad AND sha1(a.idDgoActUnidad)='" . $_GET['un'] . "'";
$rsU = $conn->query($sqlU);
$rowU = $rsU->fetch();

/*RESPONSABLE DE LA UNIDAD*/
$sqlS = "SELECT b.siglas, b.apenom, a.idDgoVisita 
FROM dgoVisita a, v_personal_simple b 
WHERE sha1(a.idDgoActUnidad)='" . $_GET['un'] . "' AND a.idGenPersona=b.idGenPersona";
$rsS = $conn->query($sqlS);

while ($rowS = $rsS->fetch()) {
	$visita = $rowS['idDgoVisita'];
	$responsable = $rowS['siglas'] . ' ' . $rowS['apenom'];
}

$firmarResponsable = $responsable . "\nRESPONSABLE(S) DE LA SUPERVISIÓN";

$tituloColumnas = array('', 'Responsables', 'Fecha Inicio', 'Fecha Final', 'Fecha Cumplimiento', 'Peso', 'Dias Transcurridos', '% Obtenido', 'Evaluacion Cumplimiento');
$columnas       = 9;
$anchoColumnas  = '77,60,20,20,20,10,20,15,35';
$orientacion    = 'L';
//$title='www.policiaecuador.gob.ec/siipne3';
$header = $tituloColumnas;
$head = array('NRO.', 'NIVEL', 'DESCRIPCIÓN');

//$pdf=new PDF();
$pdf = new pdfM();
$pdf->imagen = "";
if (isset($_GET['un']) && $_GET['ep'] == '') {

	$sqlE = "SELECT b.idDgoEjeProcSu, a.descDgoEje descripcion
	FROM dgoEje a
	INNER JOIN dgoEjeProcSu b ON a.idDgoEje=b.idDgoEje
	INNER JOIN dgoActividad c ON b.idDgoEjeProcSu=c.idDgoEjeProcSu
	INNER JOIN dgoInstrucci d ON c.idDgoActividad=d.idDgoActividad
	INNER JOIN dgoActUniIns e ON d.idDgoInstrucci=e.idDgoInstrucci
	INNER JOIN dgoActUnidad f ON e.idDgoActUnidad=f.idDgoActUnidad
	WHERE sha1(f.idDgoActUnidad)='" . $_GET['un'] . "' GROUP BY b.idDgoEjeProcSu ORDER BY 2";

	$rsE = $conn->query($sqlE);

	while ($rowE = $rsE->fetch(PDO::FETCH_ASSOC)) {
		/*MUESTRA OBJETIVOS*/
		$sql = "SELECT b.descDgoEje, a.objEspecifico, a.estrategia, a.objOperativo, c.descripcion, 
		CONCAT(c.descripcion,'/',b.descDgoEje) AS proceje 
		FROM dgoEjeProcSu a, dgoEje b, dgoProcSuper c 
		WHERE a.idDgoEje=b.idDgoEje AND a.idDgoProcSuper=c.idDgoProcSuper 
		AND a.idDgoEjeProcSu='" . $rowE['idDgoEjeProcSu'] . "'";

		$rs = $conn->query($sql);
		$row = $rs->fetch();

		$nomProceso =  strtoupper($row['descripcion']);
		$nomUnidad  = 'UNIDAD: ' . $rowU['nomenclatura'];
		$nomEje     = 'EJE: ' . $row['descDgoEje'];

		$pdf->AddPage($orientacion);

		$pdf->imprimeCabecera($nomProceso, $rowU['nomenclatura'], $row['descDgoEje']);
		$pdf->SetFont('Arial', '', 11);
		$pdf->Ln();
		$pdf->imprimeObjetivos($row['objEspecifico'], $row['estrategia'], $row['objOperativo']);

		$header = $tituloColumnas;



		$objEjes = array();
		$filas = array();
		for ($i = 0; $i < count($detaEje); $i++) {
			for ($j = 0; $j < count($detaEje[$i]); $j++) {
				$objEjes[$j] = array(
					'text' => $detaEje[$i][$j], 'width' => $whithCell[$j], 'height' => '5', 'align' => 'L', 'font_name' => 'Arial',
					'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $colorCell, 'textcolor' => $textcolor,
					'drawcolor' => '0,0,0', 'linewidth' => $linewidth, 'linearea' => 'LTBR'
				);
			}
			$filas[] = $objEjes;
		}

		// Draw Table   
		$pdf->WriteTable($filas);
		$pdf->Ln(5);



		/*RESPONSABLES POR UNIDAD*/
		$imaY = $pdf->GetY(); //captura la coordena Y en el pdf para la posicion de la fotografia

		$ax = $pdf->GetX();
		$ay = $pdf->GetY();
		$pdf->Rect($ax + 170, $ay, 100, 25);



		if ($firsTime) {
			$firsTime = false;
			$pdf->SetDrawColor(224, 224, 224);
			$pdf->SetFillColor(224, 224, 224);
			$pdf->SetFont('Arial', 'B', 7);
			$pdf->Cell(165, 5, 'RESPONSABLES Y PARTICIPANTES DE LA UNIDAD', 0, 1, 'C', true);
			/*MUESTRA RESPONSABLES Y PARTICIPANTES DE LA UNIDAD*/
			$sqlR = "select case when a.tipoParticipacion='A' then 'RESPONSABLE DE APROBACION'
			when a.tipoParticipacion='E' then 'RESPONSABLE DE EJECUCION'
			when a.tipoParticipacion='P' then 'PARTICIPANTE' else 'ASISTENTE' end as tipoP,
			group_CONCAT(siglas,' ',apenom) responsable 
			from dgoParticipa a 
			join dgoVisita b on  a.idDgoVisita=b.idDgoVisita
			join v_personal_simple c on a.idGenPersona=c.idGenPersona
			where a.idDgoVisita=" . $visita . "  group by a.tipoParticipacion order by 
			a.tipoParticipacion,c.idDgpGrado,c.apenom";

			//		$sqlR="select case when a.tipoParticipacion='A' then 'RESPONSABLE DE APROBACION'
			//		when a.tipoParticipacion='E' then 'RESPONSABLE DE EJECUCION'
			//		when a.tipoParticipacion='P' then 'PARTICIPANTE' else 'ASISTENTE' end as tipoP,
			//		CONCAT_WS(' ',siglas,apenom) responsable 
			//		from dgoParticipa a 
			//		join dgoVisita b on  a.idDgoVisita=b.idDgoVisita
			//		join dgoEjeProcSu ep on a.idDgoEjeProcSu=ep.idDgoEjeProcSu
			//		join v_personal_simple c on a.idGenPersona=c.idGenPersona
			//		where a.idDgoVisita=".$visita." and ep.idDgoEjeProcSu='".$rowE['idDgoEjeProcSu']."' order by 
			//		a.tipoParticipacion,c.idDgpGrado,c.apenom";

			$rsR = $conn->query($sqlR);
			$tip = '';
			while ($rowR = $rsR->fetch(PDO::FETCH_ASSOC)) {
				if ($tip != $rowR['tipoP']) {
					$tip = $rowR['tipoP'];
				} else
					$rowR['tipoP'] = '';
				$linea = array($rowR['tipoP'], $rowR['responsable']);
				$pdf->FTableCols($linea, 255, 255, 255, 0, 2, 45, 120, 0, 0, 0, 0, 'R,L,C,C,C,C', 'Arial', 'B,,,,,', '7,7,9,9,9,9,9');
				$pdf->Ln();
			}

			$pdf->Ln();
		}

		$ax = 20;
		$ay = 80;

		/*BLOQUE DE CODIGO PARA CALCULAR EL PORCENTAJE DE AVANZE DEL EJE*/
		$pdf->SetFont('Arial', '', 7);

		/*OBTIENE AVANCES TOTALES*/
		$sqlAT = "select ac.idDgoActividad, ac.peso, a.idDgoInstrucci, max(puntaje) puntos from dgoActUniIns a
		join dgoEncuesta en on a.idDgoInstrucci=en.idDgoInstrucci
		join dgoInstrucci i on a.idDgoInstrucci=i.idDgoInstrucci
		join dgoActividad ac on i.idDgoActividad=ac.idDgoActividad
		where sha1(a.idDgoActUnidad)='" . $_GET['un'] . "' and ac.idDgoEjeProcSu='" . $rowE['idDgoEjeProcSu'] . "'
		group by a.idDgoInstrucci";


		$rsAT = $conn->query($sqlAT);
		$pTotal = 0;
		$k = 0;
		$p = 0;
		$aTotal = array();
		$uno = true;

		while ($rowAT = $rsAT->fetch()) {
			if ($uno) {
				$aTotal[$k][0] = $rowAT['idDgoActividad'];
				$aTotal[$k][1] = $rowAT['peso'];
				$uno = false;
				$p = $rowAT['idDgoActividad'];
			}
			if ($p != $rowAT['idDgoActividad']) {
				$p = $rowAT['idDgoActividad'];
				$aTotal[$k][2] = $pTotal;
				$pTotal = $rowAT['puntos'];
				$k++;
				$aTotal[$k][0] = $rowAT['idDgoActividad'];
				$aTotal[$k][1] = $rowAT['peso'];
			} else {
				$pTotal += $rowAT['puntos'];
			}
		}

		$aTotal[$k][2] = $pTotal;
		$elem = count($aTotal[0]);



		/*Muestra AVANCES OBTENIDOS vs AVANCES TOTALES*/
		$sqlOT = "select i.idDgoActividad,sum(puntaje) puntos from dgoEncVisita a
		join dgoEncuesta en on a.idDgoEncuesta=en.idDgoEncuesta
		join dgoVisita vi on a.idDgoVisita=vi.idDgoVisita
		join dgoActUnidad au on vi.idDgoActUnidad=au.idDgoActUnidad
		join dgoEjeProcSu ps on au.idDgoProcSuper=au.idDgoProcSuper
		join dgoInstrucci i on en.idDgoInstrucci=i.idDgoInstrucci 
		where sha1(vi.idDgoActUnidad)='" . $_GET['un'] . "' 
		and ps.idDgoEjeProcSu='" . $rowE['idDgoEjeProcSu'] . "' group by i.idDgoActividad";

		//print_r( $aTotal);
		//echo $sqlOT;

		$rsOT = $conn->query($sqlOT);
		$pObtiene = 0;
		while ($rowOT = $rsOT->fetch()) {
			for ($j = 0; $j < $elem; $j++) {
				if ($aTotal[$j][0] == $rowOT['idDgoActividad']) {
					$aTotal[$j][3] = $rowOT['puntos'];
				}
			}
		}

		$sumCoef = 0;
		$sumPuntos = 0;
		foreach ($aTotal as $activ) {
			$sumCoef += $activ[1];
			$sumPuntos += ($activ[1] * ($activ[3] * 100 / $activ[2]));
		}

		$porce = round($sumPuntos / $sumCoef, 2);



		$h = 0;
		foreach ($cmi as $imc) {
			if ($porce >= $imc['desde'] and $porce < $imc['hasta']) {
				$cmi_colors = '../../imagenes/cmi_colors/cmi' . $h . '.jpg';
			}
			$h++;
		}


		/*DIBUJA EL CUADRO DEL % MAS LA IMAGEN*/
		$imaX = $pdf->GetX() + 175;

		$pdf->SetXY($imaX, $imaY);
		$pdf->SetFont('Arial', 'B', 10);
		$pdf->SetFillColor(224, 224, 224);
		$pdf->SetDrawColor(224, 224, 224);

		$pdf->Cell(60, 9, 'Porcentaje Obtenido en el Eje:' . $porce . '%', 0, 0, '', false);
		//$pdf->Image($cmi_colors,$pdf->GetX()+5,$pdf->GetY()+5,200,160);
		$pdf->Cell(5, 5, $pdf->Image($cmi_colors, $pdf->GetX() + 5, $pdf->GetY() + 5, 25, 18, 'JPG'), 0, 0, 'L', false);
		$pdf->SetXY($imaX, $imaY + 9);
		$pdf->SetFont('Arial', '', 7);
		$pdf->SetTextColor(254, 000, 000);
		$pdf->Cell(5, 9, 'De acuerdo al peso de cada Actividad', 0, 1, '', false);

		$pdf->Ln();

		$pdf->SetTextColor(000, 000, 000);
		$pdf->Ln(1);

		//$pdf->SetXY($ax,$ay+10);

		/*Muestra ACTIVIDADES*/
		$sqlA = "select distinct vi.idDgoVisita,ac.idDgoActividad, descDgoActividad cero,'' uno,  a.fechaInicioPlazo dos, a.fechaFinPlazo tres,
		a.fechaCumplimiento cuatro, ac.peso cinco,
		case when fechaCumplimiento is null then DATEDIFF(date(now()),a.fechaInicioPlazo) 
		else datediff(fechaCumplimiento,fechaInicioPlazo) end as seis,0 siete,
		case when fechaCumplimiento is null and date(now())>fechaFinPlazo then 'NO CUMPLIDA'
		when fechaCumplimiento>fechaFinPlazo then 'CUMPLIDA A DESTIEMPO'
		when fechaCumplimiento<=fechaFinPlazo then 'CUMPLIDA A TIEMPO' end as ocho
		from dgoVisita vi
		join dgoActUniIns  a on vi.idDgoActUnidad=a.idDgoActUnidad
		join dgoInstrucci i on a.idDgoInstrucci=i.idDgoInstrucci
		join dgoActividad ac on i.idDgoActividad=ac.idDgoActividad
		join dgoEjeProcSu ep on ac.idDgoEjeProcSu=ep.idDgoEjeProcSu
		where sha1(vi.idDgoActUnidad)='" . $_GET['un'] . "'  and ep.idDgoEjeProcSu='" . $rowE['idDgoEjeProcSu'] . "'";

		$rsA = $conn->query($sqlA);
		$rowA = $rsA->fetchall();

		/*HEAD DE LA CABEZERA DE ACTIVIDADES*/
		$whithColumns = explode(',', $anchoColumnas);
		$colorHead = '224,224,224';
		$colorCell = '255,255,255';
		$headerActividades = array();
		for ($i = 0; $i < count($header); $i++) {

			$cabActividades[$i] = array(
				'text' => $header[$i], 'width' => $whithColumns[$i], 'height' => '3.5',
				'align' => 'C', 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => 'B',
				'fillcolor' => $colorHead, 'textcolor' => $textcolor, 'drawcolor' => '0,0,0',
				'linewidth' => $linewidth, 'linearea' => 'LTBR'
			);
		}
		$headerActividades[] = $cabActividades;

		$pdf->SetFont('Arial', 'B', 10);
		$pdf->WriteHTML('ACTIVIDADES');
		$pdf->Ln();
		$pdf->SetFont('Arial', '', 7);
		$pdf->WriteTable($headerActividades);

		/*TABLA DE LAS ACTIVIDADES*/
		$dataActividades = array();
		/* Asigna puntaje de avance por actividad al campo siete del recordset */
		for ($i = 0; $i < count($rowA); $i++) {
			$rowA[$i]['siete'] = (number_format(round($aTotal[$i][3] * 100 / $aTotal[$i][2], 2), 2)) . '%';
		}

		for ($i = 0; $i < count($rowA); $i++) {
			unset($rowA[$i][0]);
			//print_r($rowA[$i]);
			$j = 0;
			$sql = "select b.descDgoCargo from dgoResAct a,dgoCargo b
				where a.idDgoCargo=b.idDgoCargo
				and a.idDgoVisita=" . $rowA[$i]['idDgoVisita'] . " and a.idDgoActividad=" . $rowA[$i]['idDgoActividad'] . "";
			$rsX = $conn->query($sql);
			$respo = '';
			while ($rowX = $rsX->fetch()) {
				$respo .= $rowX['descDgoCargo'] . ', ';
			}
			$rowA[$i]['uno'] = $respo;
			foreach ($rowA[$i] as $key => $value) {
				if ($key == "cero" or $key == 'uno' or $key == 'dos' or $key == 'tres' or $key == 'cuatro' or $key == 'cinco' or $key == 'seis' or $key == 'siete' or $key == 'ocho' or $key == 'nueve' or $key == 'diez') {
					switch ($value) {
						case 'NO CUMPLIDA':
							$colorCell = '254,000,000';
							break;
						case 'CUMPLIDA A DESTIEMPO':
							$colorCell = '242, 248, 0';
							break;
						case 'CUMPLIDA A TIEMPO':
							$colorCell = '125, 226, 60';
							break;
						default:
							$colorCell = '255,255,255';
							break;
					}
					$dActivities[$j] = array(
						'text' => $value, 'width' => $whithColumns[$j], 'height' => '3.5',
						'align' => 'L', 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '',
						'fillcolor' => $colorCell, 'textcolor' => $textcolor, 'drawcolor' => '0,0,0',
						'linewidth' => $linewidth, 'linearea' => 'LTBR'
					);
					$j++;
				}
			}
			$dataActividades[$i] = $dActivities;
		}

		$pdf->WriteTable($dataActividades);

		$pdf->Ln(5);
	}
	$pdf->imprimeResponsable($responsable);
} else {
	/* Cuando Selecciona Un solo EJE en particular */
	/*MUESTRA OBJETIVOS*/
	$sql = "SELECT b.descDgoEje, a.objEspecifico, a.estrategia, a.objOperativo, c.descripcion, 
	CONCAT(c.descripcion,'/',b.descDgoEje) AS proceje 
	FROM dgoEjeProcSu a, dgoEje b, dgoProcSuper c 
	WHERE a.idDgoEje=b.idDgoEje AND a.idDgoProcSuper=c.idDgoProcSuper AND sha1(a.idDgoEjeProcSu)='" . $_GET['ep'] . "'";

	$rs = $conn->query($sql);
	$row = $rs->fetch();

	//$nombreReporte=strtoupper($row['descripcion'])."\n\nUNIDAD: ".$rowU['nomenclatura']."\n\n\nEJE: ".$row['descDgoEje'];

	$nomProceso =  strtoupper($row['descripcion']);
	$nomUnidad  = 'UNIDAD: ' . $rowU['nomenclatura'];
	$nomEje     = 'EJE: ' . $row['descDgoEje'];

	$pdf->AddPage($orientacion);
	$pdf->SetFont('Arial', '', 14);
	$pdf->SetMargins(10, 28);
	$pdf->Ln();

	$pdf->imprimeCabecera($nomProceso, $rowU['nomenclatura'], $row['descDgoEje']);

	$pdf->SetFont('Arial', '', 11);

	$pdf->Ln();
	$pdf->imprimeObjetivos($row['objEspecifico'], $row['estrategia'], $row['objOperativo']);

	/*RESPONSABLES POR UNIDAD*/
	$imaY = $pdf->GetY(); //captura la coordena Y en el pdf para la posicion de la fotografia
	$ax = $pdf->GetX();
	$ay = $pdf->GetY();
	$pdf->Rect($ax + 170, $ay, 100, 25);

	$pdf->SetDrawColor(224, 224, 224);
	$pdf->SetFillColor(224, 224, 224);
	$pdf->SetFont('Arial', 'B', 7);
	$pdf->Cell(110, 5, 'RESPONSABLES Y PARTICIPANTES DE LA UNIDAD', 0, 1, 'C', true);


	/*MUESTRA RESPONSABLES Y PARTICIPANTES DE LA UNIDAD*/
	$sqlR = "select case when a.tipoParticipacion='A' then 'RESPONSABLE DE APROBACION'
	when a.tipoParticipacion='E' then 'RESPONSABLE DE EJECUCION'
	when a.tipoParticipacion='P' then 'PARTICIPANTE' else 'ASISTENTE' end as tipoP,
	CONCAT_WS(' ',siglas,apenom) responsable 
	from dgoParticipa a 
	join dgoVisita b on  a.idDgoVisita=b.idDgoVisita
	join dgoEjeProcSu ep on a.idDgoEjeProcSu=ep.idDgoEjeProcSu
	join v_personal_simple c on a.idGenPersona=c.idGenPersona
	where a.idDgoVisita=" . $visita . " and sha1(ep.idDgoEjeProcSu)='" . $_GET['ep'] . "' order by 
	a.tipoParticipacion,c.idDgpGrado,c.apenom";

	$rsR = $conn->query($sqlR);
	$rsR = $conn->query($sqlR);
	$tip = '';
	while ($rowR = $rsR->fetch(PDO::FETCH_ASSOC)) {
		if ($tip != $rowR['tipoP']) {
			$tip = $rowR['tipoP'];
		} else
			$rowR['tipoP'] = '';
		$linea = array($rowR['tipoP'], $rowR['responsable']);
		$pdf->FTableCols($linea, 255, 255, 255, 0, 2, 45, 65, 0, 0, 0, 0, 'R,L,C,C,C,C', 'Arial', 'B,,,,,', '7,7,9,9,9,9,9');
		$pdf->Ln();
	}

	$pdf->Ln();

	$ax = $pdf->GetX();
	$ay = $pdf->GetY();

	$pdf->Ln(5);

	/*BLOQUE DE CODIGO PARA CALCULAR EL PORCENTAJE DE AVANZE DEL EJE*/
	$pdf->SetFont('Arial', '', 7);

	/*OBTIENE AVANCES TOTALES*/
	$sqlAT = "select ac.idDgoActividad,ac.peso,a.idDgoInstrucci,max(puntaje) puntos from dgoActUniIns a
	join dgoEncuesta en on a.idDgoInstrucci=en.idDgoInstrucci
	join dgoInstrucci i on a.idDgoInstrucci=i.idDgoInstrucci
	join dgoActividad ac on i.idDgoActividad=ac.idDgoActividad
	where sha1(a.idDgoActUnidad)='" . $_GET['un'] . "' and sha1(ac.idDgoEjeProcSu)='" . $_GET['ep'] . "'
	group by a.idDgoInstrucci";

	$rsAT = $conn->query($sqlAT);
	$pTotal = 0;
	$k = 0;
	$p = 0;
	$aTotal = array();
	$uno = true;

	while ($rowAT = $rsAT->fetch()) {
		if ($uno) {
			$aTotal[$k][0] = $rowAT['idDgoActividad'];
			$aTotal[$k][1] = $rowAT['peso'];
			$uno = false;
			$p = $rowAT['idDgoActividad'];
		}
		if ($p != $rowAT['idDgoActividad']) {
			$p = $rowAT['idDgoActividad'];
			$aTotal[$k][2] = $pTotal;
			$pTotal = $rowAT['puntos'];
			$k++;
			$aTotal[$k][0] = $rowAT['idDgoActividad'];
			$aTotal[$k][1] = $rowAT['peso'];
		} else {
			$pTotal += $rowAT['puntos'];
		}
	}

	$aTotal[$k][2] = $pTotal;
	$elem = count($aTotal[0]);

	/*Muestra AVANCES OBTENIDOS vs AVANCES TOTALES*/
	$sqlOT = "select i.idDgoActividad,sum(puntaje) puntos from dgoEncVisita a
	join dgoEncuesta en on a.idDgoEncuesta=en.idDgoEncuesta
	join dgoVisita vi on a.idDgoVisita=vi.idDgoVisita
	join dgoActUnidad au on vi.idDgoActUnidad=au.idDgoActUnidad
	join dgoEjeProcSu ps on au.idDgoProcSuper=au.idDgoProcSuper
	join dgoInstrucci i on en.idDgoInstrucci=i.idDgoInstrucci 
	where sha1(vi.idDgoActUnidad)='" . $_GET['un'] . "' 
	and sha1(ps.idDgoEjeProcSu)='" . $_GET['ep'] . "' group by i.idDgoActividad";

	$rsOT = $conn->query($sqlOT);
	$pObtiene = 0;
	while ($rowOT = $rsOT->fetch()) {
		for ($j = 0; $j < $elem; $j++) {
			if ($aTotal[$j][0] == $rowOT['idDgoActividad']) {
				$aTotal[$j][3] = $rowOT['puntos'];
			}
		}
	}

	$sumCoef = 0;
	$sumPuntos = 0;

	foreach ($aTotal as $activ) {
		if (!empty($activ[3])) {
			$sumCoef += $activ[1];
			if (($activ[2] > 0)) {
				$sumPuntos += ($activ[1] * ($activ[3] * 100 / $activ[2]));
			}
		}
		//echo $activ[0].' '.$activ[1].' '.$activ[2].' '.$activ[3].' ** '.$sumPuntos.' '.$sumCoef.'<br>';
	}
	if ($sumCoef > 0) {
		$porce = round($sumPuntos / $sumCoef, 2);
	} else {
		$porce = 0;
	}

	//echo $porce.'<br>';
	$h = 0;
	foreach ($cmi as $imc) {
		if ($porce >= $imc['desde'] and $porce < $imc['hasta']) {
			$cmi_colors = '../../imagenes/cmi_colors/cmi' . $h . '.jpg';
		}
		$h++;
	}

	/*DIBUJA EL CUADRO DEL % MAS LA IMAGEN*/
	$imaX = $pdf->GetX() + 175;

	$pdf->SetXY($imaX, $imaY);
	$pdf->SetFont('Arial', 'B', 10);
	$pdf->SetFillColor(224, 224, 224);
	$pdf->SetDrawColor(224, 224, 224);

	$pdf->Cell(60, 9, 'Porcentaje Obtenido en el Eje:' . $porce . '%', 0, 0, '', false);
	//	$pdf->Cell(20,18,$pdf->Image($cmi_colors,$pdf->GetX(),$pdf->GetY(),200,160,'JPG'),0,1,'',false);
	$pdf->Cell(5, 5, $pdf->Image($cmi_colors, $pdf->GetX() + 5, $pdf->GetY() + 5, 25, 18, 'JPG'), 0, 0, 'L', false);
	$pdf->SetXY($imaX, $imaY + 9);
	$pdf->SetFont('Arial', '', 7);
	$pdf->SetTextColor(254, 000, 000);
	$pdf->Cell(50, 9, 'De acuerdo al peso de cada Actividad', 0, 1, '', false);

	//$pdf->Ln(5);

	$pdf->Ln();

	$pdf->SetTextColor(000, 000, 000);
	$pdf->Ln(1);

	//$pdf->SetXY($ax,$ay+10);

	/*MUESTRA ACTIVIDADES*/
	$sqlA = "select distinct vi.idDgoVisita,ac.idDgoActividad, trim(descDgoActividad) cero,'' uno,  a.fechaInicioPlazo dos, a.fechaFinPlazo tres,
	a.fechaCumplimiento cuatro, ac.peso cinco,
	case when fechaCumplimiento is null then DATEDIFF(date(now()),a.fechaInicioPlazo) 
	else datediff(fechaCumplimiento,fechaInicioPlazo) end as seis,0.00 siete,
	case when fechaCumplimiento is null and date(now())>fechaFinPlazo then 'NO CUMPLIDA'
	when fechaCumplimiento>fechaFinPlazo then 'CUMPLIDA A DESTIEMPO'
	when fechaCumplimiento<=fechaFinPlazo then 'CUMPLIDA A TIEMPO' end as ocho
	from dgoVisita vi
	join dgoActUniIns  a on vi.idDgoActUnidad=a.idDgoActUnidad
	join dgoInstrucci i on a.idDgoInstrucci=i.idDgoInstrucci
	join dgoActividad ac on i.idDgoActividad=ac.idDgoActividad
	join dgoEjeProcSu ep on ac.idDgoEjeProcSu=ep.idDgoEjeProcSu
	where sha1(vi.idDgoActUnidad)='" . $_GET['un'] . "'  and sha1(ep.idDgoEjeProcSu)='" . $_GET['ep'] . "'";

	//echo $sqlA;

	$rsA = $conn->query($sqlA);
	$rowA = $rsA->fetchall();

	/*HEAD DE LA CABEZERA DE ACTIVIDADES*/
	$pdf->SetFont('Arial', 'B', 10);
	$pdf->WriteHTML('ACTIVIDADES');
	$pdf->Ln();
	$pdf->SetFont('Arial', '', 7);

	$whithColumns      = explode(',', $anchoColumnas);
	$colorHead = '224,224,224';
	$colorCell = '255,255,255';
	$cabActividades    = array();
	$headerActividades = array();
	/* Asigna puntaje de avance por actividad al campo siete del recordset */
	for ($i = 0; $i < count($rowA); $i++) {
		if (!empty($aTotal[$i][3]) && ($aTotal[$i][2]) > 0)
			$rowA[$i]['siete'] = (number_format(round($aTotal[$i][3] * 100 / $aTotal[$i][2], 2), 2)) . '%';
	}
	$linewidth = 1;
	$textcolor = '#030303';


	for ($i = 0; $i < count($header); $i++) {
		$cabActividades[] = array(
			'text' => $header[$i], 'width' => $whithColumns[$i], 'height' => '3.5',
			'align' => 'C', 'font_name' => 'Arial', 'font_size' => 8, 'font_style' => 'B',
			'fillcolor' => $colorHead, 'textcolor' => $textcolor, 'drawcolor' => '0,0,0',
			'linewidth' => $linewidth, 'linearea' => 'LTBR'
		);
	}
	$headerActividades[] = $cabActividades;
	// Draw Table   
	$pdf->WriteTable($headerActividades);

	/*TABLA DE LAS ACTIVIDADES*/
	$dataActividades = array();

	for ($i = 0; $i < count($rowA); $i++) {
		unset($rowA[$i][0]);
		//print_r($rowA[$i]);
		$j = 0;
		//print_r($rowA[$i]);echo '<br>';
		$sql = "select b.descDgoCargo from dgoResAct a,dgoCargo b
			where a.idDgoCargo=b.idDgoCargo
			and a.idDgoVisita=" . $rowA[$i]['idDgoVisita'] . " and a.idDgoActividad=" . $rowA[$i]['idDgoActividad'] . "";
		$rsX = $conn->query($sql);
		$respo = '';
		while ($rowX = $rsX->fetch()) {
			$respo .= $rowX['descDgoCargo'] . ', ';
		}
		$rowA[$i]['uno'] = $respo;
		foreach ($rowA[$i] as $key => $value) {
			if ($key == "cero" or $key == 'uno' or $key == 'dos' or $key == 'tres' or $key == 'cuatro' or $key == 'cinco' or $key == 'seis' or $key == 'siete' or $key == 'ocho' or $key == 'nueve' or $key == 'diez') {
				switch ($value) {
					case 'NO CUMPLIDA':
						$colorCell = '254,000,000';
						break;
					case 'CUMPLIDA A DESTIEMPO':
						$colorCell = '242, 248, 0';
						break;
					case 'CUMPLIDA A TIEMPO':
						$colorCell = '125, 226, 60';
						break;
					default:
						$colorCell = '255,255,255';
						break;
				}
				$dActivities[$j] = array(
					'text' => $value, 'width' => $whithColumns[$j], 'height' => '3.5',
					'align' => 'L', 'font_name' => 'Arial', 'font_size' => 7, 'font_style' => '',
					'fillcolor' => $colorCell, 'textcolor' => $textcolor, 'drawcolor' => '0,0,0',
					'linewidth' => $linewidth, 'linearea' => 'LTBR'
				);
				$j++;
			}
		}
		$dataActividades[$i] = $dActivities;
	}

	$pdf->WriteTable($dataActividades);
	/*FIRMA DEL RESPONSABLE DE LA SUPERVISION*/
	$pdf->imprimeResponsable($responsable);
}

$dt = new DateTime('now', new DateTimeZone('America/Guayaquil'));
$hoye = $dt->format('Y-m-d H:i:s');
$pdf->pie = 'Fecha y Hora del Reporte: ' . $hoye . '';
/*-------------------------------------------------------*/
$pdf->Output();
