<?php
header("Content-type: image/png");
session_start();
//header('Content-Type: text/html; charset=UTF-8');
include '../../../../clases/autoload.php';
include_once('../../../../funciones/funcion_select.php');
/*-------------------------------------------------*/
$conn = DB::getConexionDB();
$directorio = 'modulos/graficas/operativo'; // *** CAMBIAR ***
/*-------------------------------------------------*/
$idcampo = '';

?>
<style type="text/css">
	.reli {
		border: solid 1px #666;
		-webkit-border-radius: 15px;
		-moz-border-radius: 15px;
		border-radius: 15px;
		padding: 10px;
		margin: 3px 1px 10px 1px;
		text-align: left;
		font-weight: bold;
		-webkit-box-shadow: 3px 4px 3px -2px rgba(0, 0, 0, 0.75);
		-moz-box-shadow: 3px 4px 3px -2px rgba(0, 0, 0, 0.75);
		box-shadow: 3px 4px 3px -2px rgba(0, 0, 0, 0.75);
	}

	.recuadro {
		border: solid 1px #666;
		-webkit-border-radius: 5px;
		-moz-border-radius: 5px;
		border-radius: 5px;
		padding: 10px;
		margin: 20px 20px 20px 20px;
		text-align: center;
		font-weight: bold;
		-webkit-box-shadow: 3px 4px 3px -2px rgba(0, 0, 0, 0.75);
		-moz-box-shadow: 3px 4px 3px -2px rgba(0, 0, 0, 0.75);
		box-shadow: 3px 4px 3px -2px rgba(0, 0, 0, 0.75);
	}

	.recuadro1 {
		border: solid 1px #666;
		-webkit-border-radius: 5px;
		-moz-border-radius: 5px;
		border-radius: 5px;
		padding: 1px;
		margin: 3px 1px 10px 1px;
		text-align: center;
		font-weight: bold;
		-webkit-box-shadow: 3px 4px 3px -2px rgba(0, 0, 0, 0.0);
		-moz-box-shadow: 3px 4px 3px -2px rgba(0, 0, 0, 0.0);
		box-shadow: 3px 4px 3px -2px rgba(0, 0, 0, 0.0);
	}
</style>

<script>
	$(document).ready(function() {
		$('#tpais').tree({
			onClick: function(node) {
				porusuario();
				var node = $('#tpais').tree('getSelected');
				$('#idGenGeoSenplades').attr('value', node.id);
				$('#lugar').attr('value', node.text);
				$("html, body").animate({
					scrollTop: 0
				}, "slow");
			}
		});
	});

	function porusuario() {
		var fin = $('#fechaini').val();
		var fini = fin + ' ' + '00:00:01';
		var ffi = $('#fechafin').val();
		var ffin = ffi + ' ' + '23:59:59';
		var lugar = $('#idGenGeoSenplades').val();

		if (fini == '' || ffin == '' || lugar == null) {
			alert("No ha ingresado datos en fecha de inicio, fin  o no seleccionó un lugar...");
			return false;
		} else {
			inicia(fini, ffin, lugar);
		}

	}

	function inicia(fini, ffin, lugar) {

		var urlt = 'modulos/graficas/operativo/vista.php?fini=' + fini + '&ffin=' + ffin + '&lugar=' + lugar;
		$('#imag').attr('src', urlt);
		$("html, body").animate({
			scrollTop: 0
		}, "slow");
		var urltd = 'modulos/graficas/operativo/vistaTotal.php?fini=' + fini + '&ffin=' + ffin + '&lugar=' + lugar;
		$('#imagda').attr('src', urltd);
		$("html, body").animate({
			scrollTop: 0
		}, "slow");
		// ini();
	}
</script>

<form name="edita" id="edita" method="post">
	<fieldset class="reli">
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
							<input type="button" value="" onclick="displayCalendar(document.edita.fechafin,'yyyy-mm-dd',this)" class="calendario" /></br> </br>

						</td>


						<td>

							<input type="hidden" name="idGenGeoSenplades" id="idGenGeoSenplades" readonly="readonly" value="<?php echo isset($rowt['idGenGeoSenplades']) ? $rowt['idGenGeoSenplades'] : '' ?>" />

						</td>
					</table>
				</td>
				<td width="50%">
					<table width="100%">
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

				<td colspan="2">
					<input type="button" onclick="porusuario()" class="Button" value="Buscar Operativos" align="center" />
					<input type="hidden" name="id<?php echo $idcampo ?>" readonly="readonly" value="<?php echo isset($rowt['id' . $idcampo]) ? $rowt['id' . $idcampo] : '' ?>" />
				</td>

			</tr>
			<tr>

				<td colspan="2">
					<hr>
					<input type="hidden" name="opc" value="<?php echo $_GET['opc'] ?>" />
				</td>
			</tr>
			<tr>
				<td colspan="2" alig="center" width="100%">

					<div align="center">
						<input type="text" name="lugar" id="lugar" readonly="readonly" value="" class="recuadro" size="100" />
					</div>
				</td>
			</tr>
			<tr>
				<td>
					<div id="graf" name="graf" class="recuadro">
						<img src="modulos/graficas/operativo/fondo1.png" id="imag" width="100%" height="300px" alt="" />
					</div>
				</td>
				<td>
					<div id="grafda" name="grafda" class="recuadro">
						<img src="modulos/graficas/operativo/fondo1.png" id="imagda" width="100%" height="300px" alt="" />
					</div>
				</td>
			</tr>


			<?php //include_once('../../../funciones/botonera.php'); 
			?>

		</table>
		<table width="100%">
			<tr>
				<td width="361" align="center">
					<div align="center">

					</div>
				</td>
			</tr>
		</table>
	</fieldset>
</form>
<div align="center"></div>