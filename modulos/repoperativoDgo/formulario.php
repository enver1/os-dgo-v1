<?php
session_start();
header('Content-Type: text/html; charset=UTF-8');
include '../../../clases/autoload.php';
include_once('../../../funciones/funcion_select.php');
/*-------------------------------------------------*/
$conn = DB::getConexionDB();
$directorio = 'modulos/repoperativo'; // *** CAMBIAR ***
/*-------------------------------------------------*/
/*
* Aqui se incluye el formulario de edicion
*/

?>
<script type="text/javascript" src="<?php echo $directorio ?>/validacion.js"></script>
<script>
	$(document).ready(function() {
		$('#tpais').tree({
			onClick: function(node) {
				var node = $('#tpais').tree('getSelected');
				$('#idGenGeoSenplades').attr('value', node.id);
				//  $('#lugar').attr('value',node.text);
				$("html, body").animate({
					scrollTop: 0
				}, "slow");
			}
		});
	});
</script>

<form name="edita" id="edita" method="post">
	<fieldset>
		<legend><strong>Búsqueda operativos por fecha </strong></legend>
		<table width="100%" border="0">
			<tr>
				<td width="46%">
					<table>
						<td>
							Fecha Ini:
							<input type="text" name="fechaini" id="fechaini" size="12" style="width:100px" class="inputSombra" readonly="readonly" />
							<input type="button" value="" onclick="displayCalendar(document.edita.fechaini,'yyyy-mm-dd',this)" class="calendario" /></br> </br>
							Fecha Fin:
							<input type="text" name="fechafin" id="fechafin" size="12" style="width:100px" class="inputSombra" readonly="readonly" />
							<input type="button" value="" onclick="displayCalendar(document.edita.fechafin,'yyyy-mm-dd',this)" class="calendario" />
						</td>


						<td>
							<input type="radio" id="forma" name="forma" value="2">Detallado </br>
							<input type="radio" id="forma" name="forma" value="3" checked>Cantidades </br>
							<input type="radio" id="forma" name="forma" value="4">Excel </br>
							<input type="radio" id="forma" name="forma" value="5">Novedad Geolocalizada
							<input type="hidden" name="idGenGeoSenplades" id="idGenGeoSenplades" readonly="readonly" value="<?php echo isset($rowt['idGenGeoSenplades']) ? $rowt['idGenGeoSenplades'] : '' ?>" />
						</td>
					</table>
				</td>
				<td width="50%">
					<table width="85%">
						<td width="45%" valign="top">
							<div style=" overflow: scroll; height:200px">
								<ul id="tpais" class="easyui-tree" animate="true" style="font-size:10px" url="modulos/repoperativo/tree_unidad_todo.php?id=<?php echo (isset($_GET['id']) ? $_GET['id'] : 0) ?>">
								</ul>
							</div>
						</td>
					</table>
				</td>

			</tr>

			<tr>

				<td><input type="hidden" name="id<?php echo $idcampo ?>" readonly="readonly" value="<?php echo isset($rowt['id' . $idcampo]) ? $rowt['id' . $idcampo] : '' ?>" /></td>

			</tr>

			<tr>
				<?php /*----------------------------------------------------*/ ?>
				<td colspan="2"><input type="hidden" name="opc" value="<?php echo $_GET['opc'] ?>" /></td>
			</tr>
			<?php //include_once('../../../funciones/botonera.php'); 
			?>

		</table>
		<table width="936">
			<tr>
				<td width="361" align="center">
					<div align="center">
						<input type="button" onclick="porusuario()" class="Button" value="Buscar Operativos" align="center" />
					</div>
				</td>
			</tr>
		</table>
	</fieldset>
</form>
<div align="center"></div>