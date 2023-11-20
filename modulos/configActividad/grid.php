<?php
session_start();
//print_r($_GET);
require_once("../../../funciones/funcion_select.php");
require_once('../../../clases/autoload.php');
$conn = DB::getConexionDB();
$estilo = "";
/*=============*/

$htblock = '';
$htblocked = '';

$nuevo = 0;
$imagen = ' <img src="../../../imagenes/accept.png" border="0" alt="Activa">';
//print_r($_POST);
?>
<div style="width:800px; display:block">
</div>
<p style="font-size:15px; color:#900; text-align:left;padding:2px 5px;margin:0; font-weight:bold">ACTIVIDADES</p>
<?php
/*----------------------ACTIVIDADES------------------------------*/
$sql = "select a.idDgoActividad,c.idDgoEje,c.descDgoEje,b.idDgoProcSuper,concat(descDgoActividad,', <span style=\"color:#003C77\">[Peso:',peso,']</span>') descDgoActividad from dgoActividad a,dgoEjeProcSu b,dgoEje c where a.idDgoEjeProcSu=b.idDgoEjeProcSu and b.idDgoEje=c.idDgoEje and  b.idDgoProcSuper='" . $_GET['opc'] . "' order by b.idDgoEje,a.idDgoActividad desc";
$rs = $conn->query($sql);
?>

<table id='my-tbl' width="100%">
	<tr>
		<th class="data-th" width="65%">Descripcion</th>
		<th class="data-th">Seleccionar</th>
		<th class="data-th">Editar</th>
		<th class="data-th">Borrar</th>
		<th class="data-th">Ver</th>
	</tr>
	<?php
	//loop por cada registro
	$i = 1;
	$dEje = '';
	while ($rowB = $rs->fetch()) {
		if ($rowB['descDgoEje'] != $dEje) {
			echo '<tr>
						<td colspan="5" style="background-color:#bbb;padding:10px 20px;font-size:13px">
						<span id="goTo' . $rowB['idDgoEje'] . '" 
							class="texto_gris">' . $rowB['descDgoEje'] . '</span></td></tr>';
			$dEje = $rowB['descDgoEje'];
		}
		echo "<tr class='data-tr' align='center'>";
		$prot = 0;
		$sty = (isset($_GET['c']) and $_GET['c'] == $rowB['idDgoActividad']) ? 'style="font-weight:bold;font-size:13px"' : '';
		echo '<td ' . $sty . ">" .
			$rowB['descDgoActividad'] . ((isset($_GET['c']) and $_GET['c'] == $rowB['idDgoActividad']) ? $imagen : '') . "</td>";
		echo '<td><a href="javascript:void(0)" 
				  		onclick="getdata(' . $rowB['idDgoActividad'] . ',' . $rowB['idDgoEje'] . ')">Seleccionar</a></td>';
		echo '<td><a href="modulos/configActividad/actividad/actividad.php?opc=' . $_GET['opc'] . '&cod=' . $rowB['idDgoActividad'] . '" onclick="return GB_showPage(\'Acrividades\', this.href)">
										Editar</a></td>';
		echo '<td><a href="javascript:void(0)" target="_self" 
									onclick="delPrueba(' . $rowB['idDgoActividad'] . ')">Borrar</a></td>';
		echo '<td><a href="modulos/configActividad/previewTest.php?prueba=' . $rowB['idDgoActividad'] . '" target="_blank" 
									>Preview <img src="../imagenes/ver.png" alt="" border="0"></a></td>';
		echo "</tr>";
		if (isset($_GET['c']) and $_GET['c'] == $rowB['idDgoActividad']) {
			echo '<tr><td colspan="5">
									<table width="100%" border="0">
										<tr><td style="border-right:solid 5px #996">&nbsp;&nbsp;&nbsp;&nbsp; 
										&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;</td>
										<td>';
			/*==================================================================================================================*/

			if (isset($_GET['c'])) {
				echo '<p style="font-size:15px; color:#820; text-align:left;padding:2px 5px;margin:0; font-weight:bold">
					INSTRUCCIONES</p>';
				$sql = "select a.* from dgoInstrucci a where a.idDgoActividad=" .
					$_GET['c'] . " order by a.idDgoInstrucci";
				$rsP = $conn->query($sql);
	?>

				<table id='my-tbl' style="width:820px">
					<tr>
						<th class="data-th">Descripcion</th>
						<th class="data-th">Seleccionar</th>
						<th class="data-th">Editar</th>
						<th class="data-th">Borrar</th>
					</tr>
					<?php
					//loop por cada registro
					$prot = false;
					while ($rowP = $rsP->fetch()) {
						echo "<tr class='data-tr' align='center'>";
						$sty = (isset($_GET['preg']) and $_GET['preg'] == $rowP['idDgoInstrucci']) ? 'style="font-weight:bold;font-size:13px"' : '';
						echo '<td ' . $sty . ">" .
							$rowP['descDgoInstrucci'] . ((isset($_GET['preg']) and $_GET['preg'] == $rowP['idDgoInstrucci']) ? $imagen : '') . "</td>";
						echo '<td><a href="javascript:void(0)" onclick="getPregunta(' . $rowP['idDgoInstrucci'] . ',' . $_GET['c'] . ',' . $rowB['idDgoEje'] . ')">Seleccionar</a></td>';
						echo '<td><a href="modulos/configActividad/instruccion/instruccion.php?cod=' . $rowP['idDgoInstrucci'] . '&prue=' . $_GET['c'] . '" onclick="return GB_showPage(\'Instrucciones\', this.href)">
									Editar</a></td>';
						echo '<td><a href="javascript:void(0)" target="_self" 
									onclick="delPregunta(' . $rowP['idDgoInstrucci'] . ',' . $_GET['c'] . ')">Borrar</a></td>';
						echo "</tr>";
						if (isset($_GET['preg']) and $_GET['preg'] == $rowP['idDgoInstrucci']) {
							echo '<tr><td colspan="4">
									<table width="100%" border="0">
										<tr><td  style="border-right:solid 5px #996">
										&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
										<td>';
							/*==================================================================================================================*/
							/*----------------------R E S P U E S T A S------------------------------*/
							if (isset($_GET['preg'])) {
								echo '<p style="font-size:15px; color:#c30; text-align:left;padding:2px 5px;margin:0; font-weight:bold">
				PREGUNTAS</p>';
								$sql = "select a.* from dgoEncuesta a,dgoInstrucci b 
				where a.idDgoInstrucci=b.idDgoInstrucci and a.idDgoInstrucci=" . $_GET['preg'] . " order by a.idDgoEncuesta";
								//echo $sql;
								$rsR = $conn->query($sql);
					?>

								<table id='my-tbl' style="width:750px">
									<tr>
										<th class="data-th">Descripcion<a name="resp"></a></th>
										<th class="data-th">Puntaje</th>
										<th class="data-th">Editar</th>
										<th class="data-th">Borrar</th>
									</tr>
								<?php
								$prot = false;
								//loop por cada registro
								while ($rowR = $rsR->fetch()) {
									echo "<tr class='data-tr' align='center'>";
									echo "<td>" . $rowR['descEncuesta'] . "</td>";
									echo "<td>" . $rowR['puntaje'] . "</td>";
									$rowR['protegida'] = isset($rowR['protegida']) ? $rowR['protegida'] : '';
									if ($rowR['protegida'] == 'S') {
										$prot = true;
										echo '<td colspan="2"></td>';
									} else {
										echo '<td><a href="modulos/configActividad/respuestas/respuestas.php?cod=' . $rowR['idDgoEncuesta'] . '&c=' . $_GET['c'] . '&prue=' . $_GET['preg'] . '" onclick="return GB_showPage(\'Preguntas\', this.href)">
									Editar</a></td>';
										echo '<td><a href="javascript:void(0)" target="_self" onclick="delRespuesta(' . $rowR['idDgoEncuesta'] . ',' . $_GET['c'] . ',' . $_GET['preg'] . ')">Borrar</a></td>';
									}
									echo "</tr>";
								}
							}
								?>
								<tr>
									<td colspan="3" align="center" style="height:40px">
										<?php
										if (isset($_GET['preg'])) {
											if (!$prot) { ?>
												<a href="modulos/configActividad/respuestas/respuestas.php?cod=0&prue=<?php echo $_GET['preg'] ?>&c=<?php echo $_GET['c'] ?>" onclick="return GB_showPage('Respuestas', this.href)" class="cambio" style="width:60px">Nueva Pregunta</a>
										<?php }
										} ?>
									</td>
								</tr>
								</table>
								<br />
					<?php
							echo '
										</td>
										</tr></table>
									</td></tr>';
						}
					}
				}
					?>
					<tr>
						<td colspan="4" align="left" style="height:40px">
							<?php if (isset($_GET['c'])) {
								if (!$prot) { ?>
									<a href="modulos/configActividad/instruccion/instruccion.php?cod=0&prue=<?php echo $_GET['c'] ?>" onclick="return GB_showPage('Preguntas', this.href)" class="cambio" style="width:60px">Nueva Instrucccion</a>
							<?php }
							} ?>
						</td>
					</tr>
				</table>


		<?php
			/*====================================================================================================================*/
			echo '
										</td>
										</tr></table>
									</td></tr>';
		}
	}
		?>
		<?php if (!empty($_GET['opc'])) { ?>
			<tr>
				<td colspan="4" align="left" style="height:40px">
					<a href="modulos/configActividad/actividad/actividad.php?opc=<?php echo $_GET['opc'] ?>&cod=0" onclick="return GB_showPage('Actividades', this.href)" class="cambio" style="width:150px"><span>
							Nueva Actividad</span></a>
				</td>
			</tr> <?php } ?>
</table>