<?php
session_start();
include '../../../../clases/autoload.php';
$conn = DB::getConexionDB(); // include the database connection
include_once('../../../../funciones/funcion_select.php');
$_GET['acun'] = (isset($_GET['acun'])) ? $_GET['acun'] : 0;
$xsql = "SELECT a.idDgoResAct, b.descDgoCargo FROM dgoResAct a, dgoCargo b WHERE a.idDgoCargo=b.idDgoCargo AND a.idDgoActUnidad=" . $_GET['acun'];

$formulario = array(
	1 => array(
		'tipo' => 'persona',
		'etiqueta' => 'Partipante:',
		'campoTabla' => 'idGenPersona',
		'campoCedula' => 'cedulaPersona',
		'campoNombre' => 'nombrePersona',
		'onclick' => 'onclick="buscaPersona()"',
		'ancho' => '100',
		'maxChar' => '10',
		'botonBuscar' => 'S',
		'botonOculto' => 'false',
		'botonNombres' => 'S',
		'soloLectura' => 'false',
		'onKey' => 'onkeypress="return buscaOnEnter(event);"',
		'oculto' => '',
		'tabla' => ''
	),


	2 => array(
		'tipo' => 'text',
		'etiqueta' => 'Grado:',
		'campoTabla' => 'grado',
		'ancho' => '100',
		'maxChar' => '',
		'align' => 'left',
		'soloLectura' => 'true'
	),

	4 => array(
		'tipo' => 'comboArreglo',
		'etiqueta' => 'Tipo Participaci&oacute;n:',
		'campoTabla' => 'tipoParticipacion',
		'arreglo' => array('A' => 'APROBACIÓN', 'E' => 'EJECUCIÓN', 'P' => 'PARTICIPANTE'),
		'soloLectura' => 'false',
		'ancho' => '150'
	),

	3 => array(
		'tipo' => 'textArea',
		'etiqueta' => 'Observaci&oacute;n',
		'campoTabla' => 'obsDgoParticipa',
		'maxChar' => '300',
		'ancho' => '500',
		'alto' => '70',
		'soloLectura' => 'false'
	),
);

$dt = new DateTime('now', new DateTimeZone('America/Guayaquil'));
$fechaHoy = $dt->format('Y-m-d');
$idcampo = 'idDgoParticipa';
$Ntabla = 'dgoParticipa';
/*-------------------------------------------------*/
if (isset($_GET['c'])) {
	$sql = "select a.*,  b.documento cedulaPersona, b.apenom nombrePersona, b.siglas grado from " . $Ntabla . " a, v_personal_simple b where a.idGenPersona=b.idGenPersona and a." . $idcampo . "='" . $_GET['c'] . "'";
	//$sql="SELECT a.*, b.descDgoCargo FROM dgoResAct a, dgoCargo b WHERE a.idDgoCargo=b.idDgoCargo AND a.idDgoResAct='".$_GET['c']."'";
	$rs = $conn->query($sql);
	$rowt = $rs->fetch(PDO::FETCH_ASSOC);
}
/* ==== Aqui se incluye el formulario de edicion */
?>
<link type="text/css" rel="stylesheet" href="../../../../js/calendario/calendar/calendar.css?random=20051112" media="screen" />

<script type="text/javascript" src="../../../../js/calendario/calendar/calendar.js?random=20060118"></script>
<?php
if (isset($_GET['x'])) {
?>
	<script>
		var eje = $('#cedulaPersona').val('<?php echo $_GET['x'] ?>');
		$('#Buscar').click();
	</script>
<?php } ?>
<form name="edita" id="edita" method="post">
	<table width="100%" border="0">
		<tr style="display:none">
			<td class="etiqueta">C&oacute;digo:</td>
			<td>
				<input type="text" name="<?php echo $idcampo ?>" readonly="readonly" id="<?php echo $idcampo ?>" value="<?php echo isset($rowt[$idcampo]) ? $rowt[$idcampo] : '' ?>" class="inputSombra" style="width:150px" />
				<input type="hidden" name="fechaHoy" value="<?php echo $fechaHoy ?>">
				<input type="hidden" name="idDgoVisita" id="idDgoVisita" value="<?php echo isset($_GET['vst']) ? $_GET['vst'] : 0 ?>">
				<input type="hidden" name="idDgoEjeProcSu" id="idDgoEjeProcSu" value="<?php echo isset($_GET['eje']) ? $_GET['eje'] : 0 ?>">
			</td>
		</tr>
		<?php /*==================//  *** CAMBIAR *** // ===========================*/
		foreach ($formulario as $campos) {
		?>
			<tr>
				<td class="etiqueta"><?php echo (($campos['tipo'] == 'hidden') ? '' : $campos['etiqueta']) ?></td>
				<td>
					<?php
					switch ($campos['tipo']) {
							/* Campo tipo Input Text*/
						case 'text': ?>
							<input type="text" name="<?php echo $campos['campoTabla'] ?>" } id="<?php echo $campos['campoTabla'] ?>" style=" <?php echo empty($campos['ancho']) ? '' : 'width:' . $campos['ancho'] . 'px' ?>
                <?php echo empty($campos['align']) ? '' : ';text-align:' . $campos['align'] ?> " <?php echo empty($campos['maxChar']) ? '' : 'maxlength="' . $campos['maxChar'] . '"' ?> value="<?php echo isset($rowt[$campos['campoTabla']]) ? $rowt[$campos['campoTabla']] : '' ?>" class="inputSombra" <?php echo $campos['soloLectura'] == 'true' ? 'readonly="readonly"' : '' ?> /> <span style="font-size:9px;color:#C00"><?php echo (isset($campos['ayuda']) ? $campos['ayuda'] : '') ?></span>
						<?php break;
							/* Campo tipo Hidden Text*/
						case 'hidden': ?>
							<input type="hidden" name="<?php echo $campos['campoTabla'] ?>" value="<?php echo isset($rowt[$campos['campoTabla']]) ? $rowt[$campos['campoTabla']] : '' ?>" />
						<?php break;
							/* Campo tipo Select Option*/
						case 'combo':
							generaComboSimple(
								$conn,
								$campos['tabla'],
								$campos['campoTabla'],
								$campos['campoValor'],
								isset($rowt[$campos['campoTabla']]) ? $rowt[$campos['campoTabla']] : '',
								(empty($campos['ancho']) ? 'width:250px' : 'width:' . $campos['ancho'] . 'px')
							) ?>
						<?php break;
							/* Campo tipo Select Option con arreglo de valores*/
						case 'comboArreglo':
							generaComboArreglo(
								$campos['campoTabla'],
								$campos['arreglo'],
								isset($rowt[$campos['campoTabla']]) ? $rowt[$campos['campoTabla']] : '',
								(empty($campos['ancho']) ? 'width:250px' : 'width:' . $campos['ancho'] . 'px')
							) ?>
						<?php break;
							/* Campo tipo Input Fecha*/
						case 'date': ?>
							<input type="text" name="<?php echo $campos['campoTabla'] ?>" id="<?php echo $campos['campoTabla'] ?>" <?php echo empty($campos['ancho']) ? '' : 'style="width:' . $campos['ancho'] . 'px"' ?> <?php echo empty($campos['maxChar']) ? '' : 'maxlength="' . $campos['maxChar'] . '"' ?> value="<?php echo isset($rowt[$campos['campoTabla']]) ? $rowt[$campos['campoTabla']] : '' ?>" class="inputSombra" <?php echo $campos['soloLectura'] == 'true' ? 'readonly="readonly"' : '' ?> />
							<input type="button" value="" onclick="displayCalendar(document.forms[0].<?php echo $campos['campoTabla']  ?>,'yyyy-mm-dd',this)" class="calendario" />
						<?php break;
							/* Campo tipo textArea*/
						case 'textArea': ?>
							<textarea name="<?php echo $campos['campoTabla'] ?>" onKeyUp="max(this,<?php echo $campos['maxChar'] ?>,'<?php echo $campos['campoTabla'] ?>')" onKeyPress="max(this,<?php echo $campos['maxChar'] ?>,'<?php echo $campos['campoTabla'] ?>')" class="inputSombra" style="height:<?php echo $campos['alto'] ?>px;
             width:<?php echo $campos['ancho'] ?>px;
            font-family:Verdana;font-size:12px" <?php echo $campos['soloLectura'] == 'true' ? 'readonly="readonly"' : '' ?>><?php echo isset($rowt[$campos['campoTabla']]) ? $rowt[$campos['campoTabla']] : '' ?></textarea>
				</td>
			</tr>
			<?php if (!empty($campos['maxChar'])) { ?>
				<tr>
					<td></td>
					<td>
						<font id="Dig<?php echo $campos['campoTabla'] ?>" color="red">0</font> Caracteres digitados / Restan
						<font id="Res<?php echo $campos['campoTabla'] ?>" color="red"><?php echo $campos['maxChar'] ?></font>
					<?php }
							break;
							/* Campo tipo Select Option con instruccion SQL*/
						case 'comboSQL':
							generaComboSimpleSQL(
								$conn,
								$campos['tabla'],
								$campos['campoTabla'],
								'descripcion',
								isset($rowt[$campos['campoTabla']]) ? $rowt[$campos['campoTabla']] : '',
								$campos['sql'],
								$campos['onclick'],
								(empty($campos['ancho']) ? 'width:250px' : 'width:' . $campos['ancho'] . 'px')
							) ?>
				<?php break;
							/* Campo tipo Select CheckBox con instruccion SQL*/
						case 'check':
							generaCheckSQL($conn, $campos['campoTabla'], $campos['sql'], isset($rowt[$campos['campoTabla']]) ? $rowt[$campos['campoTabla']] : '', 5, $campos['campoTabla'], $campos['campoValor']) ?>
				<?php break;
							/* Campo tipo Select RabioButton con instruccion SQL*/
						case 'radio':
							generaRadioSQL($conn, $campos['campoTabla'], $campos['campoValor'], isset($rowt[$campos['campoTabla']]) ? $rowt[$campos['campoTabla']] : '', $campos['sql'], $campos['onclick'], $campos['soloLectura']) ?>
				<?php break;
							/* Campo persona */
						case 'persona': ?>
					<table id="<?php echo $campos['tabla'] ?>" style="<?php echo $campos['oculto'] ?>">
						<tr>
							<td>
								<input type="hidden" name="<?php echo $campos['campoTabla'] ?>" id="<?php echo $campos['campoTabla'] ?>" value="<?php echo isset($rowt[$campos['campoTabla']]) ? $rowt[$campos['campoTabla']] : '' ?>" />
								<input type="text" name="<?php echo $campos['campoCedula'] ?>" id="<?php echo $campos['campoCedula'] ?>" value="<?php echo isset($rowt[$campos['campoCedula']]) ? $rowt[$campos['campoCedula']] : '' ?>" class="inputSombra" style="width:100px" <?php echo ($campos['soloLectura'] == 'true') ? ' readonly="readonly" ' : ' ' ?> <?php echo $campos['onKey'] ?> />
							</td>
							<td>
								<?php if ($campos['botonBuscar'] == 'S') { ?>
									<input type="button" id="Buscar" class="boton_general" <?php echo $campos['onclick'] ?> value="Buscar" <?php echo (isset($campos['botonOculto']) and $campos['botonOculto'] == 'true') ? 'style="display:none"' : '' ?> />
								<?php } ?>
							</td>
							<td><input type="text" name="<?php echo $campos['campoNombre'] ?>" id="<?php echo $campos['campoNombre'] ?>" value="<?php echo isset($rowt[$campos['campoNombre']]) ? $rowt[$campos['campoNombre']] : '' ?>" class="inputSombra" readonly="readonly" style="width:442px" /></td>
							<td>
								<?php if (isset($campos['botonNombres']) and $campos['botonNombres'] == 'S') { ?>
									<a href="javascript:void(0)" onclick="buscaPorNombres()"><img src="../../../../imagenes/buscarNombres.png" border="0" alt="Abrir"></a>
								<?php } ?>
							</td>
						</tr>
					</table>
					<?php break;
							/* Campo tipo Arbol*/
						case 'arbol':
							if ($campos['tabla'] == 'dgpUnidad' or $campos['tabla'] == 'genDivPolitica') {
								switch ($campos['tabla']) {
									case 'dgpUnidad': ?>
								<table>
									<tr>
										<td>
											<input type="hidden" name="idDgpUnidad" id="idDgpUnidad" value="<?php echo isset($rowt[$campos['campoTabla']]) ? $rowt[$campos['campoTabla']] : '' ?>" />
											<input type="text" name="unidadDescripcion" id="unidadDescripcion" value="<?php echo isset($rowt[$campos['campoValor']]) ? $rowt[$campos['campoValor']] : '' ?>" class="inputSombra" readonly="readonly" />
										</td>
										<td><a href="../../funciones/arbolUnidades.php?id=0" class="button" onclick="return GB_showPage('U N I D A D E S', this.href)"><span>Unidades</span></a></td>
									</tr>
								</table>
							<?php break;
									case 'genDivPolitica': ?>
								<table>
									<tr>
										<td>
											<input type="hidden" name="idGenDivPolitica" id="idGenDivPolitica" value="<?php echo isset($rowt[$campos['campoTabla']]) ? $rowt[$campos['campoTabla']] : '' ?>" />
											<input type="text" name="divPoliticaDescripcion" id="divPoliticaDescripcion" value="<?php echo isset($rowt[$campos['campoTabla']]) ? $rowt[$campos['campoTabla']] : '' ?>" class="inputSombra" readonly="readonly" />
										</td>
										<td><a href="../../funciones/arbolPaises.php?id=0" class="button" onclick="return GB_showPage('DIVISION GEOGRAFICA', this.href)"><span>Lugares</span></a></td>
									</tr>
								</table>
						<?php break;
								}
							} else {
								echo '<span class="texto_red">Solo permite arboles para las tablas dgpUnidad y genDivPolitica</span>'; ?>

					<?php }
							break;
						case 'file':
					?>
					<?php if (!empty($rowt[$campos['campoTabla']])) { ?>
						<a href="<?php echo  is_null($campos['pathFile'] . $rowt[$campos['campoTabla']]) ? 'javascript:void(0);' : $campos['pathFile'] . $rowt[$campos['campoTabla']] ?>" class="button" id="ololo" title="Certificado" onclick="return GB_showPage('<?php echo $campos['etiqueta'] ?>', this.href)"><span><img src="../../../imagenes/pdf_icon.gif" alt="" border="0" />&nbsp;Ver <?php echo $campos['etiqueta'] ?></span></a>
					<?php } ?>
					<input type="file" name="myfile" id="myfile" size="40" />
					<input type="hidden" name="<?php echo $campos['campoTabla'] ?>" id="<?php echo $campos['campoTabla'] ?>" value="<?php echo isset($rowt[$campos['campoTabla']]) ? $rowt[$campos['campoTabla']] : '' ?>" />
					<input type="hidden" name="pathFile" value="<?php echo $campos['pathFile'] ?>" />
					<input type="hidden" name="fileSize" value="<?php echo $campos['fileSize'] ?>" />
					<input type="hidden" name="fileTypes" value="<?php echo $campos['fileTypes'] ?>" />
					<input type="hidden" name="campoTablaValida" value="<?php echo $campos['campoTablaValida'] ?>" />
					<input type="hidden" name="campoEtiqueta" value="<?php echo $campos['etiqueta'] ?>" />
				<?php break;
						default:
							echo '<span class="texto_red">Tipo de campo no definido en el Framework 2.0</span>';
							break;

				?>
			<?php } ?>
					</td>
				</tr>
			<?php } ?>





			<?php
			/*============================================================================================*/ ?>
			<tr>
				<td colspan="2">
					<hr /><input type="hidden" name="opc" value="<?php echo $_GET['opc'] ?>" />
				</td>
			</tr>
	</table>
	<?php
	$swf = false;
	foreach ($formulario as $campos) {
		if ($campos['tipo'] == 'file')
			$swf = true;
	}
	if ($swf) {
		//            idCampo nuevo graba impri file	
		echo botonera($idcampo, false, true, false, true);
	} else
		echo botonera($idcampo, false, true, false, false);
	?>
</form>