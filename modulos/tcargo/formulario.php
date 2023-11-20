<?php
session_start();
header('Content-Type: text/html; charset=UTF-8');
include '../../../funciones/db_connect.inc.php';
include_once('../../../funciones/funcion_select.php');
include_once('config.php');

$dt = new DateTime('now', new DateTimeZone('America/Guayaquil'));
$fechaHoy = $dt->format('Y-m-d');

/*-------------------------------------------------*/
if (isset($_GET['c'])) {
	$sql = "select * from " . $Ntabla . " where " . $idcampo . "='" . $_GET['c'] . "'";
	$rs = $conn->query($sql);
	$rowt = $rs->fetch(PDO::FETCH_ASSOC);
}
/* ==== Aqui se incluye el formulario de edicion */
?>

<form name="edita" id="edita" method="post">
	<table width="100%" border="0">
		<tr>
			<td class="etiqueta">C&oacute;digo:</td>
			<td>
				<input type="text" name="<?php echo $idcampo ?>" readonly="readonly" value="<?php echo isset($rowt[$idcampo]) ? $rowt[$idcampo] : '' ?>" class="inputSombra" style="width:150px" />
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
                <?php echo empty($campos['align']) ? '' : ';text-align:' . $campos['align'] ?> " <?php echo empty($campos['maxChar']) ? '' : 'maxlength="' . $campos['maxChar'] . '"' ?> value="<?php echo isset($rowt[$campos['campoTabla']]) ? $rowt[$campos['campoTabla']] : '' ?>" class="inputSombra" <?php echo $campos['soloLectura'] == 'true' ? 'readonly="readonly"' : '' ?> />
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
		echo botonera($idcampo, true, true, true, true);
	} else
		echo botonera($idcampo, true, true, true, false);
	?>
</form>