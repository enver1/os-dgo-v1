<?php
//print_r($_GET);
include_once('../../../clases/autoload.php');
$conn = DB::getConexionDB();
$sql = "select * from dgoEjeProcSu where idDgoEjeProcSu=" . $_GET['eje'];
$rsS = $conn->query($sql);
$visita = 0;
$cmi = array(
	0 => array(
		'desde' => 0,
		'hasta' => 12,
	),
	1 => array(
		'desde' => 12,
		'hasta' => 20,
	),
	2 => array(
		'desde' => 20,
		'hasta' => 30,
	),
	3 => array(
		'desde' => 30,
		'hasta' => 38,
	),
	4 => array(
		'desde' => 38,
		'hasta' => 45,
	),
	5 => array(
		'desde' => 45,
		'hasta' => 55,
	),
	6 => array(
		'desde' => 55,
		'hasta' => 65,
	),
	7 => array(
		'desde' => 65,
		'hasta' => 72,
	),
	8 => array(
		'desde' => 72,
		'hasta' => 80,
	),
	9 => array(
		'desde' => 80,
		'hasta' => 88,
	),
	10 => array(
		'desde' => 88,
		'hasta' => 95,
	),
	11 => array(
		'desde' => 95,
		'hasta' => 101,
	),
);
if ($rowB = $rsS->fetch()) {
	/*Muestra OBJETIVOS*/
	include_once('../procsupervision/tablaObj.php');

	/*Muestra RESPONSABLES*/
	$sql = "select siglas,apenom,a.idDgoVisita from dgoVisita a,v_personal_simple b where a.idDgoActUnidad=" . $_GET['id'] . " and a.idGenPersona=b.idGenPersona";
	$rsS = $conn->query($sql);
	echo '<br><p class="texto_gris">RESPONSABLE(S) DE LA SUPERVISI&Oacute;N</p><div class="col3" style="width:875px">';
	while ($rowS = $rsS->fetch()) {
		$visita = $rowS['idDgoVisita'];
		echo $rowS['siglas'] . ' ' . $rowS['apenom'] . '<br>';
	}

	echo '</div><hr>';

	/*Muestra PARTICIPANTES*/
	$sql = "select case when a.tipoParticipacion='A' then 'RESPONSABLE DE APROBACION'
	when a.tipoParticipacion='E' then 'RESPONSABLE DE EJECUCION'
	when a.tipoParticipacion='P' then 'PARTICIPANTE' else 'ASISTENTE' end as tipoP,
	siglas,apenom 
	from dgoParticipa a 
	join dgoVisita b on  a.idDgoVisita=b.idDgoVisita
	join v_personal_simple c on a.idGenPersona=c.idGenPersona
	where a.idDgoVisita=" . $visita . " order by a.tipoParticipacion,c.idDgpGrado,c.apenom";
	$rsS = $conn->query($sql);
	echo '<br><p class="texto_gris">RESPONSABLES Y PARTICIPANTES DE LA UNIDAD</p><div class="col3" style="width:875px;color:#333"><table>';
	while ($rowS = $rsS->fetch()) {
		echo '<tr><td class="etiqueta">' . $rowS['tipoP'] . ': </td><td>' . $rowS['siglas'] . '</td><td> ' . $rowS['apenom'] . '</td></tr>';
	}

	echo '</table></div><hr>';


	/*OBTIENE AVANCES TOTALES*/
	$sql = "select ac.idDgoActividad,ac.peso,a.idDgoInstrucci,max(puntaje) puntos from dgoActUniIns a
		join dgoEncuesta en on a.idDgoInstrucci=en.idDgoInstrucci
		join dgoInstrucci i on a.idDgoInstrucci=i.idDgoInstrucci
		join dgoActividad ac on i.idDgoActividad=ac.idDgoActividad
		where a.idDgoActUnidad=" . $_GET['id'] . " and ac.idDgoEjeProcSu=" . $_GET['eje'] . "
		group by a.idDgoInstrucci";
	$rsS = $conn->query($sql);
	$pTotal = 0;
	$k = 0;
	$p = 0;
	$aTotal = array();
	$uno = true;
	while ($rowS = $rsS->fetch()) {
		if ($uno) {
			$aTotal[$k][0] = $rowS['idDgoActividad'];
			$aTotal[$k][1] = $rowS['peso'];
			$uno = false;
			$p = $rowS['idDgoActividad'];
		}
		if ($p != $rowS['idDgoActividad']) {
			$p = $rowS['idDgoActividad'];
			$aTotal[$k][2] = $pTotal;
			$pTotal = $rowS['puntos'];
			$k++;
			$aTotal[$k][0] = $rowS['idDgoActividad'];
			$aTotal[$k][1] = $rowS['peso'];
		} else {
			$pTotal += $rowS['puntos'];
		}
	}
	$aTotal[$k][2] = $pTotal;
	$elem = count($aTotal[0]);
	//print_r($aTotal);
	/*Muestra AVANCES OBTENIDOS vs AVANCES TOTALES*/
	$sql = "select i.idDgoActividad,sum(puntaje) puntos from dgoEncVisita a
		join dgoEncuesta en on a.idDgoEncuesta=en.idDgoEncuesta
		join dgoVisita vi on a.idDgoVisita=vi.idDgoVisita
		join dgoActUnidad au on vi.idDgoActUnidad=au.idDgoActUnidad
		join dgoEjeProcSu ps on au.idDgoProcSuper=au.idDgoProcSuper
		join dgoInstrucci i on en.idDgoInstrucci=i.idDgoInstrucci 
		where vi.idDgoActUnidad=" . $_GET['id'] . " 
		and ps.idDgoEjeProcSu=" . $_GET['eje'] . ' group by i.idDgoActividad';
	//echo $sql;
	$rsS = $conn->query($sql);
	echo '<br><p class="texto_gris">EVALUACION DEL EJE</p><div class="col3" style="width:450px;color:#333"><table width="100%"><tr><td>';
	$pObtiene = 0;
	while ($rowS = $rsS->fetch()) {
		for ($j = 0; $j < $elem; $j++) {
			if ($aTotal[$j][0] == $rowS['idDgoActividad'])
				$aTotal[$j][3] = $rowS['puntos'];
		}
	}
	//echo '<pre>';print_r($aTotal);echo '</pre>';
	$sumCoef = 0;
	$sumPuntos = 0;



	foreach ($aTotal as $activ) {
		if (!empty($activ[1])) {
			$sumCoef += $activ[1];
			if (!isset($activ[3])) {
				$activ[3] = 1;
			}

			$sumPuntos += ($activ[1] * ($activ[3] * 100 / $activ[2]));
		}
	}
	if ($sumCoef > 0) {
		$porce = round($sumPuntos / $sumCoef, 2);
		echo 'Porcentaje Obtenido:' . $porce . '%<br><span style="font-size:10px;color:#c30">De acuerdo al peso de cada Actividad</span>';
		$h = 0;
		foreach ($cmi as $imc) {
			if ($porce >= $imc['desde'] and $porce < $imc['hasta']) {
				//echo $porce.' <br>';
				echo '</td><td align="center"><div 
				style="background:url(../../../imagenes/cmi_colors.jpg);
				;background-position:-' . (100 * $h) . 'px  0px;width:100px;height:82px"></div></td></tr></table></div>';
			}
			$h++;
		}
	} else {
		echo 'Porcentaje Obtenido:No tiene Porcentaje<br><span style="font-size:10px;color:#c30">De acuerdo al peso de cada Actividad</span>';
	}

	echo '<hr>';


	/*Muestra ACTIVIDADES*/
	$sql = "select distinct ac.idDgoActividad,descDgoActividad,a.fechaInicioPlazo,a.fechaFinPlazo,
		a.fechaCumplimiento,ac.peso,
		case when fechaCumplimiento is null then DATEDIFF(date(now()),a.fechaInicioPlazo) 
		else datediff(fechaCumplimiento,fechaInicioPlazo) end as tiempoTr,
		case when fechaCumplimiento is null and date(now())>fechaFinPlazo then '<p style=\"background-color:#f30;padding:3px;border:solid 1px #555\">NO CUMPLIDA</p>'
		when fechaCumplimiento>fechaFinPlazo then '<p style=\"background-color:#ffff00;padding:3px;border:solid 1px #555\">CUMPLIDA A DESTIEMPO</p>'
		when fechaCumplimiento<=fechaFinPlazo then '<p style=\"background-color:#0c3;padding:3px;border:solid 1px #555\">CUMPLIDA A TIEMPO</p>' end as cumplido
		from dgoVisita vi
		join dgoActUniIns  a on vi.idDgoActUnidad=a.idDgoActUnidad
		join dgoInstrucci i on a.idDgoInstrucci=i.idDgoInstrucci
		join dgoActividad ac on i.idDgoActividad=ac.idDgoActividad
		join dgoEjeProcSu ep on ac.idDgoEjeProcSu=ep.idDgoEjeProcSu
		where vi.idDgoActUnidad=" . $_GET['id'] . " and ep.idDgoEjeProcSu=" . $_GET['eje'];

	//	select distinct b.idDgoActividad,descDgoActividad,a.fechaInicioPlazo,a.fechaFinPlazo,
	//		a.fechaCumplimiento from dgoActUniIns a
	//		join dgoInstrucci b on a.idDgoInstrucci=b.idDgoInstrucci
	//		join dgoActividad c on b.idDgoActividad=c.idDgoActividad
	//		where a.idDgoActUnidad=".$_GET['id'];
	//echo $sql;
	$rsS = $conn->query($sql);
	echo '<table border="0" id="my-tbl" style="font-size:10px">
		<th class="data-th"></th>
		<th class="data-th">ACTIVIDAD</th>
		<th class="data-th">Fecha Inicio</th>
		<th class="data-th">Fecha Final</th>
		<th class="data-th">Fecha Cumplimiento</th>
		<th class="data-th">Peso</th>
		<th class="data-th">Dias Transcurridos</th>
		<th class="data-th">Evaluacion Cumplimiento</th>
		<th class="data-th">Detalles</th>
		</tr>';
	while ($rowA = $rsS->fetch()) {
		echo '<tr>
		<td><dic id="d' . $rowA['idDgoActividad'] . '"></dic></td>
		<td>' . $rowA['descDgoActividad'] . '</td>
		<td>' . $rowA['fechaInicioPlazo'] . '</td>
		<td>' . $rowA['fechaFinPlazo'] . '</td>
		<td>' . $rowA['fechaCumplimiento'] . '</td>
		<td>' . $rowA['peso'] . '</td>
		<td>' . $rowA['tiempoTr'] . '</td>
		<td style="text-align:center;">' . $rowA['cumplido'] . '</td>
		<td><a href="javascript:void(0)" onclick="muestraDetalles(' . $rowA['idDgoActividad'] . ')">Detalles</a></td>
		</tr>';
	}
	echo '</table>';
}
