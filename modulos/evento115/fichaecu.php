<?php 
/**
 * verificar la sessión
 */
if (!isset($_SESSION)) {session_start();}

/**
 * archivos que se incluyen en la ejecución del script
 */
include_once('../../../funciones/db_connect.inc.php');
include_once('../../../funciones/paginacion/libs/ps_pagination.php');
include_once('../../../funciones/funciones_generales.php');
include_once 'logica/logica.php';
/**
 * obtener datos desde una clase
 */
$logica = new logica($conn);

/**
 * obtener listado de subtipificación
 */
if(isset($_POST['ClaseTipificacion'])){
	echo json_encode($logica->getSubTipificacion($_POST['ClaseTipificacion']), true);
	exit();
}else{
	if(isset($_POST['SubClaseTipificacion'])){
		echo json_encode($logica->getTipoTipificacion($_POST['SubClaseTipificacion']), true);
		exit();
	}else{
		if(isset($_POST['grupoResumen'])){
			echo json_encode($logica->getTipoResumen($_POST['grupoResumen']), true);
			exit();
		}else{
			if(isset($_POST['GenGeoSemplades'])){
				echo json_encode($logica->getGenGeoSemplades($_POST['GenGeoSemplades']), true);
				exit();
			}
		}
	}
}
/**
 * obtener datos de la ficha seleccionada
 */
$rowt = $logica->obtenerFicha($_POST['Evento']);
?>
<fieldset>
    <legend>Evento # <b><?php echo $rowt['codigoEvento']?></b></legend>
    <fieldset>
    	<legend><a href="javascript:void(0);" onclick="if ($('#Expandir1').is(':visible')){$('#Expandir1').hide();}else{$('#Expandir1').show();}" >Datos Preliminares &#9660;&#9650;</a></legend>
    	<div id="Expandir1">
    	<table width="100%">
	    	<tr>
	    		<td class="etiqueta">Tipo de Incidente:</td>
	    		<td colspan="3"><?php echo $rowt['ct'].' - '.$rowt['st'].' - '.$rowt['t']?></td>
	    	</tr>
	    	<tr>
	    		<td class="etiqueta">Nivel de Alerta</td>
	    		<td colspan="3" style="color: <?php $alertasEcuColores = array('V'=>'#7FFF00', 'A'=>'#FFFF00', 'N'=>'#FFA500', 'R'=>'#FF0000');
	    		echo $alertasEcuColores[$rowt['nivelAlerta']];?>;"><?php 
	    		$alertasEcu = array('V'=>'CLAVE VERDE', 'A'=>'CLAVE AMARILLA', 'N'=>'CLAVE NARANJA', 'R'=>'CLAVE ROJA');
	    		echo $alertasEcu[$rowt['nivelAlerta']];
	    		?></td>
	    	</tr>
	    	<tr>
	    		<td class="etiqueta">Distrito:</td>
	    		<td colspan="3"><?php echo $rowt['d']?></td>
	    	</tr>
	    	<tr>
	    		<td class="etiqueta">Circuito:</td>
	    		<td><?php echo $rowt['c']?></td>
	    		<td class="etiqueta">Subcircuito:</td>
	    		<td><?php echo $rowt['s']?></td>
	    		<td></td>
	    	</tr>
	    	<tr>
	    		<td class="etiqueta">Latitud:</td>
	    		<td><?php echo $rowt['latitud'];?></td>
	    		<td class="etiqueta">Longitud:</td>
	    		<td><?php echo $rowt['longitud']?></td>
	    		<td><button type="button" class="boton_general" onclick="if ($('#iframeMapa').is(':visible')){$('#iframeMapa').hide();}else{$('#iframeMapa').show();}">Mapa</button></td>
	    	</tr>
	    	<tr>
	    		<td class="etiqueta">Descripci&oacute;n:</td>
	    		<td colspan="3"><p><?php echo $rowt['descripcion'];?></p></td>
	    	</tr>
	    	<tr>
	    		<td class="etiqueta">Ejecuci&oacute;n del Hecho:</td>
	    		<td><?php echo $rowt['fechaEvento'] ?></td>
	    		<td class="etiqueta">Notificaci&oacute;n Primera Unidad:</td>
	    		<td><?php echo $rowt['horaReportaje']?></td>
	    		<td></td>
	    	</tr>
	    	<tr>
	    		<td colspan="5" align="center">
	    			<iframe id="iframeMapa" src="modulos/evento115/mapa.php?longitud=<?php echo $rowt['longitud']?>&latitud=<?php echo $rowt['latitud']?>" style="width:610px;height:390px;display: none;"></iframe>
	    		</td>
	    	</tr>
	    </table>
	    </div>
    </fieldset>
    
    	<fieldset>
    		<legend><a href="javascript:void(0);" onclick="if ($('#Expandir2').is(':visible')){$('#Expandir2').hide();}else{$('#Expandir2').show();}" >Registro y Caracterizaci&oacute;n &#9660;&#9650;</a></legend>
    		<div style="display: none;" id="Expandir2">
    		
    		<form action="modulos/evento115/logica/evento115.php" method="post">
    		<input type="hidden" value="1" name="guardarInformacion">
    		<input type="hidden" value="<?php echo $_POST['Evento']?>" name="idHdrEvento">
	    	<table width="100%">
	    		<tr>
	    			<td colspan="2">
	    				<table width="100%">
	    					<tr>
	    						<td class="etiqueta" style="width: 25%;">Ejecuci&oacute;n de Hecho:</td>
	    						<td style="width: 25%;">
				    			<?php $fec = explode(' ', $rowt['fechaEvento'])?>
				    				<input type="text" value="<?php echo $fec[0]?>" id="fechaEjecucionId" name="fechaEjecucion" size="12" readonly="readonly" onchange="fecha_es()"/>
				        			<input type="button" value="" onclick="displayCalendar(document.forms[0].fechaEjecucion,'yyyy-mm-dd',this)" class="calendario"/>
				    			</td>
				    			<td class="etiqueta" style="width: 25%;">Hora del Hecho:</td>
				    			<td style="width: 25%;">
				    				<input type="text" id="horaechoid" value="<?php echo $fec[1]?>" name="horaecho" class="inputSombra" style="width: 60px">
				    			</td>
	    					</tr>
	    				</table>
	    			</td>
	    		</tr>
	    		<tr>
	    			<td colspan="2">
	    				<table width="100%">
	    					<tr>
	    						<td class="etiqueta" style="width: 25%;">Latitud:</td>
					    		<td style="width: 25%;"><input type="text" value="<?php echo $rowt['latitud1'];?>" name="latitud" id="latitud" class="inputSombra" style="width: 120px;"></td>
					    		<td class="etiqueta" style="width: 25%;">Longitud:</td>
					    		<td style="width: 25%;"><input type="text" value="<?php echo $rowt['longitud2']?>" name="longitud" id="longitud" class="inputSombra" style="width: 120px;"></td>
	    					</tr>
	    				</table>
	    			</td>
	    		</tr>
	    		<tr>
	    			<td rowspan="2">
	    				<table width="100%">
	    					<tr>
	    						<td class="etiqueta"> 
	    							<label>Zona</label>
	    						</td>
	    						<td>
	    							<?php 
	    							$array = $logica->getGenGeoSempladesZona();
	    							?>
	    							<select style="width:250px" class="inputSombra" id="zonaId" onchange="getComboGeosemplades('<?php echo $_SERVER['PHP_SELF']?>', {GenGeoSemplades:this.value}, $('#DistritoId'));removerlistas($('#CircuitoId'));removerlistas($('#subCircuitoId'));removerlistas($('#subCircuitoId2'));">
	    								<option value="">Seleccione...</option>
	    								<?php foreach ($array as $row){
	    									?>
	    									<option value="<?php echo $row['codigo']?>"><?php echo $row['descripcion']?></option>
	    									<?php
	    								}?>
	    							</select>
	    						</td>
	    					</tr>
	    					<tr>
	    						<td class="etiqueta">Subzona</td>
	    						<td>
	    							<select style="width:250px" class="inputSombra" id="DistritoId" onchange="getComboGeosemplades('<?php echo $_SERVER['PHP_SELF']?>', {GenGeoSemplades:this.value}, $('#CircuitoId'));removerlistas($('#subCircuitoId'));removerlistas($('#subCircuitoId2'));">
	    								<option value="">Seleccione...</option>
	    							</select>
	    						</td>
	    					</tr>
	    					<tr>
	    						<td class="etiqueta">Distrito</td>
	    						<td>
	    							<select style="width:250px" class="inputSombra" id="CircuitoId" onchange="getComboGeosemplades('<?php echo $_SERVER['PHP_SELF']?>', {GenGeoSemplades:this.value}, $('#subCircuitoId'));removerlistas($('#subCircuitoId2'));">
	    								<option value="">Seleccione...</option>
	    							</select>
	    						</td>
	    					</tr>
	    					<tr>
	    						<td class="etiqueta">
	    							<label>Circuito</label></td>
	    						<td>
	    							<select style="width:250px" class="inputSombra" id="subCircuitoId" onchange="getComboGeosemplades('<?php echo $_SERVER['PHP_SELF']?>', {GenGeoSemplades:this.value}, $('#subCircuitoId2'))">
	    								<option value="">Seleccione...</option>
	    							</select>
	    						</td>
	    					</tr>
	    					<tr>
	    						<td class="etiqueta">
	    							<label>Subcircuito</label></td>
	    						<td>
	    							<select style="width:250px" class="inputSombra" id="subCircuitoId2" name="subCircuito">
	    								<option value="">Seleccione...</option>
	    							</select>
	    						</td>
	    					</tr>
	    				</table>
	    			</td>
	    		</tr>
	    		
	    		<tr>
	    			<td width="50%" valign="top">
	    				<table width="100%">
	    					<tr>
	    						<td width="30%" class="etiqueta">
					    			<label>Clase Tipificaci&oacute;n</label>
					    		</td>
					    		<td>
					    			<?php 
					    			$array = $logica->getClaseTipificacion();
					    			?>
					    			<select id="ClaseId" style="width:250px" onchange="getComboTipificacion('<?php echo $_SERVER['PHP_SELF']?>', {ClaseTipificacion:this.value}, $('#subtipificacionId'));removerlistas($('#tipotipificacionId'))" class="inputSombra">
					    				<option value="">Seleccione...</option>
					    				<?php foreach($array as $row){
					    					?>
					    					<option value="<?php echo $row['idGenClaseTipificacion']?>"><?php echo $row['descripcion']?></option>
					    					<?php
					    				}?>
					    			</select>
					    		</td>
	    					</tr>
	    					<tr>
	    						<td class="etiqueta">
					    			<label>Sub Tipificaci&oacute;n</label>
					    		</td>
					    		<td>
					    			<select style="width:250px" id="subtipificacionId" onchange="getComboTipificacion('<?php echo $_SERVER['PHP_SELF']?>', {SubClaseTipificacion:this.value}, $('#tipotipificacionId'))" class="inputSombra">
					    				<option value="">Seleccione...</option>
					    			</select>
					    		</td>
	    					</tr>
	    					<tr>
	    						<td class="etiqueta">
					    			<label>Tipo Tipificaci&oacute;n</label>
					    		</td>
					    		<td>
					    			<select style="width:250px" id="tipotipificacionId" name="tipotipificacion" class="inputSombra">
					    				<option value="">Seleccione...</option>
					    			</select>
					    		</td>
	    					</tr>
	    				</table>
	    			</td>
	    		</tr>
	    		<tr>
	    			<td colspan="2">
	    				<button type="button" class="boton_save" onclick="guardarRegistro(this.form)">Actualizar</button>
	    			</td>
	    		</tr>
	    	</table>
	    	</form>
	    	</div>
    	</fieldset>
	    	<fieldset>
    			<legend><a href="javascript:void(0);" onclick="if ($('#Expandir3').is(':visible')){$('#Expandir3').hide();}else{$('#Expandir3').show();}" >Detalle y descripci&oacute;n del Evento &#9660;&#9650;</a></legend>
    		<div style="display: none;" id="Expandir3">
    			<?php 
			    	$array = $logica->getGrupoResumen();
			    ?>
    			<table width="100%" cellspacing="0" cellpadding="0" style="height:30px" border="0">
					<tr>
						<?php 
						$codigo = '';
						$count = 0;
						foreach($array as $row){
							if($count == 0){
								$codigo = $row['codigo'];
							}
						?>
							<td width="<?php echo 100/count($array);?>%" class="<?php echo ($count==0)?"fichaSel":"ficha" ?>" align="center" id="<?php echo $row['codigo'];?>tab">
						    	<a href="javascript:void(0)" onclick="getComboResumen('<?php echo $_SERVER['PHP_SELF']?>', {grupoResumen:'<?php echo $row['codigo'];?>'}, $('#SubResumenId'), '<?php echo $row['codigo'];?>tab')" class="pestania"><?php echo $row['descripcion']?></a>
						    </td>
						<?php
							$count ++;
						}
						?>
					  </tr>
				</table>
				<form action="modulos/evento115/logica/evento115.php" method="post">
				<input type="hidden" name="detalleResumen" value="1">
				<input type="hidden" name="idHdrEvento" value="<?php echo $_POST['Evento']?>">
	    			<table width="100%">
	    				<tr>
	    					<td valign="top">
	    						<table width="100%">
				    				<tr>
				    					<td>
				    						<label>Par&aacute;metros</label>
				    					</td>
				    					<td>
				    					<?php 
				    					$array = $logica->getTipoResumen($codigo)
				    					?>
				    						<select style="width:250px" id="SubResumenId" name="SubResumenId" class="inputSombra">
					    						<option value="">Seleccione...</option>
					    						<?php 
					    						foreach($array as $row){
					    						?>
					    							<option value="<?php echo $row['codigo']?>"><?php echo $row['descripcion']?></option>
					    						<?php
					    						}
					    						?>
					    					</select>
				    					</td>
				    				</tr>
				    				<tr>
				    					<td class="etiqueta">Cantidad:</td>
				    					<td><input type="text" name="txtcantidad" class="inputSombra" maxlength="2" style="width: 60px" onkeypress="return justNumbers(event);"></td>
				    				</tr>
				    			</table>
	    					</td>
	    					<td style="display: none;">
	    						<table>
	    							<tr>
	    								<td>
	    									<label>C&eacute;dula</label>
	    									<input type="radio" name="tpBuscar" checked="checked">
	    								</td>
	    								<td>
	    									<label>Placa</label>
	    									<input type="radio" name="tpBuscar">
	    								</td>
	    								<td>
	    									<input type="text" name="txtBuscar">
	    								</td>
	    								<td>
	    									<button type="button" class="boton_general">Buscar</button>
	    								</td>
	    							</tr>
	    						</table>
	    					</td>
	    				</tr>
	    				<tr>
	    					<td colspan="2">
	    						<fieldset>
	    							<legend>Descripci&oacute;n</legend>
	    							<textarea rows="4" name="txtdescripcion" style="width: 100%"></textarea>
	    						</fieldset>
	    					</td>
	    				</tr>
	    				<tr>
	    					<td colspan="2">
		    					<button type="button" class="boton_save" onclick="guardarDetalle(this.form)" style="float:left;">Agregar</button>
		    					<button type="button" class="boton_general" onclick="if ($('#retrieved-data').is(':visible')){$('#retrieved-data').hide();}else{$('#retrieved-data').show();}" style="float: left;">Visualizar</button>
		    				</td>
	    				</tr>
	    			</table>
    			</form>
    			<div id="retrieved-data" style="display: none;"></div>
    			</div>
    		</fieldset>
    			<fieldset>
    			<legend><a href="javascript:void(0);" onclick="if ($('#Expandir4').is(':visible')){$('#Expandir4').hide();}else{$('#Expandir4').show();}" >Despacho de Recursos &#9660;&#9650;</a></legend>
    		<div style="display: none;" id="Expandir4">
    			
    			
    			<div id="DespachosEventoId"></div>
    			<table width="100%">
    				<tr>
    					<td>
    						<button type="button" class="boton_general" onclick="return GB_showPage('A S I G N A C I O N - D E - R E C U R S O S', '/operaciones/modulos/evento115/asignarrecurso.php?idHdrEvento=<?php echo $_POST['Evento']?>')"><span>Asignar R.</span></button>
    					</td>
    				</tr>
    			</table>
    		</div>
    		</fieldset>
    		<fieldset>
    			<legend><a href="javascript:void(0);" onclick="if ($('#Expandir5').is(':visible')){$('#Expandir5').hide();}else{$('#Expandir5').show();}" >Descripci&oacute;n General del Evento &#9660;&#9650;</a></legend>
    		<div style="display: none;" id="Expandir5">
    		<form action="modulos/evento115/logica/evento115.php" method="post">
				<input type="hidden" name="guardarRegistroResumen" value="1">
				<input type="hidden" name="idHdrEvento" value="<?php echo $_POST['Evento']?>">
    			<textarea rows="4" style="width: 100%" name="resumen"><?php echo $rowt['descripcionFinal']?></textarea>
    			<button type="button" class="boton_save" onclick="guardarRegistroResumenFinal(this.form)">Actualizar</button>
    		</form>
    		</div>
    		</fieldset>
	    	<table width="100%">
	    		<tr>
	    			<td align="center">
	    				<button type="button" class="boton_general" onclick="MostrarListadoFichas()">Listar Fichas</button>
	    			</td>
	    			<td align="center">
	    				<form action="modulos/evento115/logica/evento115.php" method="post">
							<input type="hidden" name="finalizarFicha" value="5">
							<input type="hidden" name="idHdrEvento" value="<?php echo $_POST['Evento']?>">
	    					<button type="button" class="boton_save" onclick="finalizarFichaEcu(this.form)">Finalizar</button>
	    				</form>
	    			</td>
	    		</tr>
	    	</table>
<?php 
$sql = "SELECT s.idGenGeoSenplades AS 's',c.idGenGeoSenplades AS 'c',d.idGenGeoSenplades AS 'd', sz.idGenGeoSenplades AS 'sz',z.idGenGeoSenplades AS 'z'
FROM genGeoSenplades AS s 
INNER JOIN genGeoSenplades AS c ON s.gen_idGenGeoSenplades=c.idGenGeoSenplades
INNER JOIN genGeoSenplades AS d ON c.gen_idGenGeoSenplades=d.idGenGeoSenplades
INNER JOIN genGeoSenplades AS sz ON d.gen_idGenGeoSenplades=sz.idGenGeoSenplades
INNER JOIN genGeoSenplades AS z ON sz.gen_idGenGeoSenplades=z.idGenGeoSenplades
WHERE s.idGenGeoSenplades={$rowt['idGenGeoSenplades']}";
if(($rsGeoSemplades = $conn->query($sql)) != false){
	$row = $rsGeoSemplades->fetch(PDO::FETCH_ASSOC);
}

$sql1 = "SELECT t.idGenTipoTipificacion AS 't', s.idGenSubTipificacion AS 's', c.idGenClaseTipificacion AS 'c'
FROM genTipoTipificacion t
INNER JOIN genSubTipificacion s ON t.idGenSubTipificacion = s.idGenSubTipificacion
INNER JOIN genClaseTipificacion c ON s.idGenClaseTipificacion = c.idGenClaseTipificacion
WHERE t.idGenTipoTipificacion = {$rowt['idGenTipoTipificacionReal']}";
if(($tipotipificacion = $conn->query($sql1)) != false){
	$row1 = $tipotipificacion->fetch(PDO::FETCH_ASSOC);
}
?>
<script type="text/javascript">
	getdata('<?php echo $_POST['Evento']?>');
	getdataDespacho('<?php echo $_POST['Evento']?>');
	getComboGeosempladesSelect('<?php echo $_SERVER['PHP_SELF']?>', {GenGeoSemplades:'<?php echo $row['z']?>'}, $('#DistritoId'), '<?php echo $row['sz']?>');
	getComboGeosempladesSelect('<?php echo $_SERVER['PHP_SELF']?>', {GenGeoSemplades:'<?php echo $row['sz']?>'}, $('#CircuitoId'), '<?php echo $row['d']?>');
	getComboGeosempladesSelect('<?php echo $_SERVER['PHP_SELF']?>', {GenGeoSemplades:'<?php echo $row['d']?>'}, $('#subCircuitoId'), '<?php echo $row['c']?>');
	getComboGeosempladesSelect('<?php echo $_SERVER['PHP_SELF']?>', {GenGeoSemplades:'<?php echo $row['c']?>'}, $('#subCircuitoId2'), '<?php echo $row['s']?>')
	$('#zonaId').val('<?php echo $row['z']?>');
	getComboTipificacionSelect('<?php echo $_SERVER['PHP_SELF']?>', {ClaseTipificacion:'<?php echo $row1['c']?>'}, $('#subtipificacionId'), '<?php echo $row1['s']?>');
	getComboTipificacionSelect('<?php echo $_SERVER['PHP_SELF']?>', {SubClaseTipificacion:'<?php echo $row1['s']?>'}, $('#tipotipificacionId'), '<?php echo $row1['t']?>')
	$('#ClaseId').val('<?php echo $row1['c']?>');
</script>