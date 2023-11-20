<?php
//print_r($_GET);
include_once('../../../clases/autoload.php');
$conn = DB::getConexionDB();
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
$sql = "select un.nombreComun from dgoActUnidad a
join dgpUnidad un on a.idDgpUnidad=un.idDgpUnidad
WHERE idDgoActUnidad='" . $_GET['id'] . "'";

$unid = '';
$rsS = $conn->query($sql);
if ($rowS = $rsS->fetch()) {
	$unid = $rowS['nombreComun'];
}

$sql = "select ep.idDgoEjeProcSu,ep.idDgoEje,ej.descDgoEje,ep.objEspecifico,ep.estrategia,
ep.objOperativo from dgoActUnidad a
join dgoEjeProcSu ep on a.idDgoProcSuper=ep.idDgoProcSuper
join dgoEje ej on ep.idDgoEje=ej.idDgoEje
WHERE idDgoActUnidad='" . $_GET['id'] . "'";

$rsB = $conn->query($sql);
$i = 1; ?>
<a class="return" href="javascript:void(0)" onClick="entrar(<?php echo $_GET['v'] ?>)"></a>
<table border="0" cellspacing="6" cellpadding="0" style="920px">
	<tr>
		<th colspan="4" class="data-th">VISITA A <?php echo $unid ?></td>
	</tr>
	<tr>
		<?php
		while ($rowB = $rsB->fetch()) {
		?>
			<td class="marcoUni" style="vertical-align:top;width:220px;background:#fff;border:solid 1px #999"><a href="javascript:void(0)" onClick="detalles(<?php echo $rowB['idDgoEjeProcSu'] ?>,<?php echo $_GET['id'] ?>,<?php echo $_GET['v'] ?>)">
					<table width="100%">
						<?php //echo '<tr><td align="center" style="background-color:#000;color:#fff"><strong style="font-size:14px">'.$rowB['idDgoEjeProcSu'].'</strong></td></tr>'.
						echo '<tr><td style="background:#333;color:#fff;text-align:center;padding:10px 3px">' . $rowB['descDgoEje'] . '</td></tr>';

						$sql = "select ac.idDgoActividad,ac.peso,a.idDgoInstrucci,max(puntaje) puntos from dgoActUniIns a
		join dgoEncuesta en on a.idDgoInstrucci=en.idDgoInstrucci
		join dgoInstrucci i on a.idDgoInstrucci=i.idDgoInstrucci
		join dgoActividad ac on i.idDgoActividad=ac.idDgoActividad
		where a.idDgoActUnidad=" . $_GET['id'] . " and ac.idDgoEjeProcSu=" . $rowB['idDgoEjeProcSu'] . "
		group by a.idDgoInstrucci";
						//echo $sql;
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
						$sql = "SELECT i.idDgoActividad,sum(puntaje) puntos from dgoEncVisita a
								join dgoEncuesta en on a.idDgoEncuesta=en.idDgoEncuesta
								join dgoVisita vi on a.idDgoVisita=vi.idDgoVisita
								join dgoActUnidad au on vi.idDgoActUnidad=au.idDgoActUnidad
								join dgoEjeProcSu ps on au.idDgoProcSuper=au.idDgoProcSuper
								join dgoInstrucci i on en.idDgoInstrucci=i.idDgoInstrucci 
								where vi.idDgoActUnidad=" . $_GET['id'] . " 
								and ps.idDgoEjeProcSu=" . $rowB['idDgoEjeProcSu'] . ' group by i.idDgoActividad';
						//echo $sql;
						$rsS = $conn->query($sql);
						//	echo '<br><p class="texto_gris">EVALUACION DEL EJE</p><div class="col3" style="width:450px;color:#333"><table width="100%"><tr><td>';
						$pObtiene = 0;
						while ($rowS = $rsS->fetch()) {
							if (!empty($rowS)) {
								for ($j = 0; $j < $elem; $j++) {
									if (!empty($aTotal[$j])) {
										if ($aTotal[$j][0] == $rowS['idDgoActividad']) {
											$aTotal[$j][3] = $rowS['puntos'];
										}
									}
								}
							}
						}
						//echo '<pre>';print_r($aTotal);echo '</pre>';
						$sumCoef = 0;
						$sumPuntos = 0;
						foreach ($aTotal as $activ) {
							$act1 = !empty($activ[1]) ? $activ[1] : 1;
							$act2 = !empty($activ[2]) ? $activ[2] : 1;
							$act3 = !empty($activ[3]) ? $activ[3] : 1;
							$sumCoef += $act1;
							$sumPuntos += ($act1 * ($act3 * 100 / $act2));
						}

						$porce = round($sumPuntos / $sumCoef, 2);
						echo '<tr><td>Porcentaje Obtenido:' . $porce . '%<br><span style="font-size:10px;color:#c30"></span></td></tr>';
						$h = 0;
						foreach ($cmi as $imc) {
							if ($porce >= $imc['desde'] and $porce < $imc['hasta']) {
								//echo $porce.' <br>';
								echo '<tr><td align="center" style="background:#fff"><div 
										style="background:url(../../../imagenes/cmi_colors.jpg);
										;background-position:-' . (100 * $h) . 'px  0px;width:100px;height:82px"></div></td></tr>';
							}
							$h++;
						}
						echo '<tr><td style="font-weight:bold;border-top:solid 1px #3f3f3f">Objetivo Espec&iacute;fico:</td></tr>';
						echo '<tr><td style="">' . $rowB['objEspecifico'] . '</td></tr>';
						echo '<tr><td style="font-weight:bold">Estrategia:</td></tr>';
						echo '<tr><td style="">' . $rowB['estrategia'] . '</td></tr>';
						echo '<tr><td style="font-weight:bold">Objetivo Operativo:</td></tr>';
						echo '<tr><td style="">' . $rowB['objOperativo'] . '</td></tr>';

						?>
					</table>
				</a>
			</td>
		<?php
			if ($i > 3) {
				$i = 0;
				echo '</tr><tr><td colspan="4" style="height:30px"></td></tr><tr>';
			}
			$i++;
		}
		echo '</tr>';
		?>
</table>