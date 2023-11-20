<?php
if (!isset($_SESSION)) {
	session_start();
}
include '../../../clases/autoload.php';
$conn = DB::getConexionDB();
/*-------------------------------------------------*/
$directorioC	= 'modulos/unidadesgeoreferencial';
$directorio	= 'unidadesgeoreferencial';
$idcampo = 'idGenUnidadesGeoreferencial';

if (isset($_GET['c'])) {
	$sql = "SELECT a.idGenUnidadesGeoreferencial idGenUnidadesGeoreferencial, a.idGenActividadGA idGenActividadGA, a.idGenGeoSenplades idGenGeoSenplades,
	 CONCAT((SELECT g.descGestionAdmin 
	FROM genGestionAdmin g WHERE g.idGenGestionAdmin = b.idGenGestionAdmin),' - ',(SELECT t.descGenTipoActividad FROM genTipoActividad t WHERE t.idGenTipoActividad =  b.idGenTipoActividad) ) descTipoActividad, c.descripcion desSector
	FROM genUnidadesGeoreferencial a, genActividadGA b, genGeoSenplades c
	WHERE a.idGenActividadGA = b.idGenActividadGA AND a.idGenGeoSenplades = c.idGenGeoSenplades
	AND a.idGenUnidadesGeoreferencial ='" . $_GET['c'] . "'";
	$rs = $conn->query($sql);
	$rowt = $rs->fetch(PDO::FETCH_ASSOC);
}
?>
<script type="text/javascript" src="../../../js/jquery.easyui.min.js"></script>

<script type="text/javascript">
	$(document).ready(function() {
		//---------------------------------------------------
		$('#tapp1').tree({
			onClick: function(node) {
				var node = $('#tapp1').tree('getSelected');
				//alert(node.id);
				$('#descripcion').attr('value', node.text);
				$('#idGenGeoSenplades').attr('value', node.id);
				$("html, body").animate({
					scrollTop: 0
				}, "slow");
			}
		});

		$('#tapp2').tree({
			onClick: function(node) {
				var node = $('#tapp2').tree('getSelected');
				if (node.attributes[0] != null) {
					$('#desc_unidad_actividad').attr('value', node.text);
					$('#idGenActividadGA').attr('value', node.attributes[0]);
				} else {

					$('#desc_unidad_actividad').attr('value', '');
					$('#idGenActividadGA').attr('value', '');
					alert('Elija otro');
				}
				$("html, body").animate({
					scrollTop: 0
				}, "slow");
			}
		});
	});
</script>
<table width="100%" border="0">
	<tr>
		<td width="55%" valign="top" style="border-right:dotted 1px">
			<form name="edita" id="edita" method="post">
				<table width="100%" border="0">
					<tr>
						<td class="etiqueta">C&oacute;digo:</td>
						<td>
							<input type="text" name="idGenUnidadesGeoreferencial" readonly="readonly" value="<?php echo isset($rowt['idGenUnidadesGeoreferencial']) ? $rowt['idGenUnidadesGeoreferencial'] : '' ?>" class="inputSombra" style="width:150px" />
						</td>
					</tr>
					<!--nuevo codigo-->
					<tr>
						<td class="etiqueta">Unidad Actividad:</td>
						<td>
							<input type="hidden" readonly="readonly" size="5" name="idGenActividadGA" id="idGenActividadGA" value="<?php echo isset($rowt['idGenActividadGA']) ? $rowt['idGenActividadGA'] : '' ?>" />
							<input type="text" id="desc_unidad_actividad" readonly="readonly" name="desc_unidad_actividad" value="<?php echo isset($rowt['descTipoActividad']) ? $rowt['descTipoActividad'] : '' ?>" size="40" class="inputSombra" style="width:250px" /> ->
						</td>
					</tr>
					<tr>
						<td class="etiqueta">Sector:</td>
						<td>
							<input type="hidden" readonly="readonly" size="5" name="idGenGeoSenplades" id="idGenGeoSenplades" value="<?php echo isset($rowt['idGenGeoSenplades']) ? $rowt['idGenGeoSenplades'] : '' ?>" />
							<input type="text" id="descripcion" readonly="readonly" name="descripcion" value="<?php echo isset($rowt['desSector']) ? $rowt['desSector'] : '' ?>" size="40" class="inputSombra" style="width:250px" /> ->
						</td>
					</tr>
					<tr>
						<td colspan="2">
							<hr /><input type="hidden" name="opc" value="<?php echo $_GET['opc'] ?>" />
						</td>
					</tr>
					<?php include_once('../../../funciones/botonera.php'); ?>
					<!-- 					<tr> -->
					<td width="10%">
						<span class="titulows">Seleccione Actividad:</span>
						<div style=" overflow: scroll; height:150px">
							<ul id="tapp2" class="easyui-tree" animate="true" style="font-size:10px" url="<?php echo $directorioC ?>/tree_unidad_actividad.php?id=<?php echo (isset($_GET['id']) ? $_GET['id'] : 0); ?>"></ul>
						</div>
						<span class="titulows">Seleccione Sector:</span>
						<div style=" overflow: scroll; height:150px">
							<ul id="tapp1" class="easyui-tree" animate="true" style="font-size:10px" url="<?php echo $directorioC ?>/tree_unidad_todo.php?id=<?php echo (isset($_GET['id']) ? $_GET['id'] : 0); ?>">
							</ul>
						</div>
					</td>
					<!-- 					</tr> -->
				</table>
			</form>
		</td>
	</tr>
</table>
<?php include 'validacion.php'; ?>