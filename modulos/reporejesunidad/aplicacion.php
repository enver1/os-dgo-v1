<?php
if (isset($_SESSION['usuarioAuditar'])) {
	include_once('../clases/autoload.php');
	$conn = DB::getConexionDB();
	include_once('../funciones/funcion_select.php');
	include_once('../funciones/funciones_generales.php');
?>
	<script type="text/javascript" src="../js/jquery.easyui.min.js"></script>
	<script type="text/javascript" src="../../../js/sha1.js"></script>
	<script type="text/javascript">
		/*Funcion carga los tipos de sancion segun la clase*/
		function muestraEjes() {
			var u = $('#idDgoActUnidad').val();

			if (u != "") {
				var targetURL = 'modulos/reporejesunidad/ejes.php?codigo=' + CryptoJS.SHA1(u);
				$('#muestra-ejes').html('<p><img src="../../../funciones/paginacion/images/ajax-loader.gif" /></p>');
				$('#muestra-ejes').load(targetURL).hide().fadeIn('slow');
			}
		}

		function imprimirdata() {
			var ep = $('#idDgoEjeProcSu').val();
			var un = $('#idDgoActUnidad').val();

			if (un != '' && ep == '') {
				var url = "modulos/reporejesunidad/imprime.php?un=" + CryptoJS.SHA1(un) + "&ep=";
			} else {
				var url = "modulos/reporejesunidad/imprime.php?ep=" + CryptoJS.SHA1(ep) + "&un=" + CryptoJS.SHA1(un);
			}

			if (un == 0 || un == '') {
				alert('No hay datos seleccionados para la impresion');
			} else {
				if (ep == '') {
					alert('No hay eje seleccionado para la impresion');
					die();
				}
				if (un == '') {
					alert('No hay Unidad Seleccionada para la Impresión');
					die();
				}
				var l = screen.width;
				var t = screen.height;
				var opts = 'scrollbars=yes,toolbar=no,width=' + screen.width + ',height=' + screen.height + ',top=' + t + ' ,left=' + l;
				var name = 'pdf';
				window.open(url, name, opts);
			}

		}
	</script>
	<div id="proceso">
		<table width="100%" border="0">
			<tr>
				<td class="etiqueta" width="40%">Unidad:</td>
				<td width="60%">
					<?php
					$sqlU = "SELECT
	c.idDgoActUnidad ,d.nomenclatura descripcion
FROM
	dgoVisita a,
	v_usuario b,
	dgoActUnidad c,
	dgpUnidad d,
	dgoProcSuper e
WHERE
	a.idGenPersona = b.idGenPersona
AND a.idDgoActUnidad=c.idDgoActUnidad
AND c.idDgpUnidad=d.idDgpUnidad 
AND c.idDgoProcSuper=e.idDgoProcSuper AND e.idGenEstado=1 
AND b.idGenUsuario = '" . $_SESSION['usuarioAuditar'] . "'";
					generaComboSimpleSQL(
						$conn,
						'dgoActUnidad',
						'idDgoActUnidad',
						'descripcion',
						'',
						$sqlU,
						'onchange="muestraEjes()"',
						'width:250px'
					);
					?>
				</td>
			</tr>
			<tr>
				<td class="etiqueta" width="40%">Eje:</td>
				<td width="60%">
					<span class="titulows" id="muestra-ejes" title="">
						<select disabled="disabled" name="idDgoEjeProcSu" id="idDgoEjeProcSu" class="inputSombra" style="width:250px">
							<option value="0">Selecciona opci&oacute;n...</option>
						</select>
					</span>
				</td>
			</tr>
			<tr>
				<td colspan="2" align="center"><br><input type="button" name="imprimir" onclick="imprimirdata()" value="Imprimir" class="boton_print" />
				</td>
			</tr>
		</table>
	</div>
	<div id='detalleEje'>
	</div>
	<div id='formulario'>
	</div>
<?php
} else {
	header('Location: imprime.php');
}

?>