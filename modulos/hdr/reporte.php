<?php
include_once '../clases/autoload.php';
$conn = DB::getConexionDB();
/**
 * obtener informaci�n de la unidad correspondiente
 */
$sqlUnidad = "SELECT * from v_datos_GA where sha2(idGenUsuarioAplicacion,512)='" . $_GET['opc'] . "' AND idGenUsuario=" . $_SESSION['usuarioAuditar'];
/**
 * ejecutando consulta
 */
$rs = $conn->query($sqlUnidad);

/**
 * obteniendo resultado
 */
$rowUnidad = $rs->fetch();
if (!empty($rowUnidad)) {
} else {
	$rowUnidad['descGestionAdmin'] = 'NO TIENE UNIDAD';
	$rowUnidad['idGenActividadGA'] = 0;
}
?>
<script>
	/**
	 * imprimir datos
	 */
	function imprimirdata(recno) {
		var url = "modulos/hdr/reportes/hdrimprime.php?recno=" + recno;
		var l = screen.width;
		var t = screen.height;
		var opts = 'scrollbars=yes,toolbar=no,width=' + screen.width + ',height=' + screen.height + ',top=' + t + ' ,left=' + l;
		var name = 'pdf';
		window.open(url, name, opts);
	}
	/**
	 * obtener resultado de la busqueda
	 */
	function getdata(pageno) {
		var fecha = $('#fecha').val();
		var fechafin = $('#fechafin').val();
		var unidad = $('#idGenActividadGA').val();
		var targetURL = 'modulos/hdr/reportes/hdrBusqueda.php?page=' + pageno + '&fecha=' + fecha + '&unidad=' + unidad + '&fechafin=' + fechafin;
		console.log(targetURL);
		$('#retrieved-data').html('<p><img src="../funciones/paginacion/images/ajax-loader.gif" /></p>');
		$('#retrieved-data').load(targetURL).hide().fadeIn('slow');
	}
</script>

<form action="#" name="idReporteHdr" id="idReporteHdr">
	<table width="100%" border="0">
		<tr>
			<td valign="top" style="float: left;">
				<span>Listar Hoja de Ruta:</span>
				<table>
					<tr>
						<td class="etiqueta">
							Fecha Inicio:
						</td>
						<td valign="top">
							<input type="text" id="fecha" name="fecha" size="12" value="<?php echo date('Y-m-d') ?>" readonly="readonly" onchange="fecha_es()" />
							<input type="button" value="" onclick="displayCalendar(document.forms[0].fecha,'yyyy-mm-dd',this)" class="calendario" />
						</td>
					</tr>
					<tr>
						<td class="etiqueta">
							Fecha Fin:
						</td>
						<td valign="top">
							<input type="text" id="fechafin" name="fechafin" size="12" value="<?php echo date('Y-m-d') ?>" readonly="readonly" onchange="fecha_es()" />
							<input type="button" value="" onclick="displayCalendar(document.forms[0].fechafin,'yyyy-mm-dd',this)" class="calendario" />
						</td>
					</tr>
					<tr>
						<td class="etiqueta">
							Unidad:
						</td>
						<td valign="top">
							<input type="text" size="40" class="inputSombra" style="width:250px" name="Unidad" id="Unidad" value="<?php echo $rowUnidad['descGestionAdmin']; ?>">
							<input type="hidden" name="idGenActividadGA" id="idGenActividadGA" value="<?php echo $rowUnidad['idGenActividadGA']; ?>">
						</td>
					</tr>
					<?php if ($rowUnidad['idGenActividadGA'] > 0) { ?>
						<tr>
							<td colspan="2">
								<button type="button" onclick="getdata('1')" class="boton_general">Enviar</button>
							</td>
						</tr>
					<?php  } ?>
				</table>
			</td>
		</tr>
	</table>
</form>
<div id='retrieved-data'></div>