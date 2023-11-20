<?php
if (isset($_SESSION['usuarioAuditar'])) {
	include_once('config.php');
	$sqltable = urldecode($sqltable);
	if (substr($sqltable, -1) == '=')
		$sqltable .= '0';
	//echo 'XX:'.$sqltable;
	//$sqltable=urlencode($sqltable);
	include_once('../funciones/funcion_select.php');
	include_once('../clases/autoload.php');
	$conn = DB::getConexionDB();
	$tgrid = $directorio . '/grid.php'; // php para mostrar la grid
	$tforma = $directorio . '/formulario.php'; // php para mostrar el formulario en la parte superior
	$tborra = $directorio . '/borra.php'; // php para borrar un registro
	$tgraba = $directorio . '/graba.php'; // php para grabar un registro
	$tprint = $directorio . '/imprime.php'; // nombre del php que imprime los registros
	include_once('../js/ajaxuid.php');
	$sqltable = urldecode(decrypt(urldecode($sqltable), $_SESSION['nomUsuarioLogueado']));
	$formulario = array(
		1 => array(
			'tipo' => 'comboSQL',
			'etiqueta' => 'Proceso Unidad:',
			'tabla' => 'dgoActUnidad',
			'campoTabla' => 'idDgoActUnidadX',
			'sql' => "select a.idDgoActUnidad idDgoActUnidadX, 
	CONCAT_WS(' / ',b.descripcion,c.nomenclatura) descripcion  
	FROM dgoActUnidad a, dgoProcSuper b, dgpUnidad c WHERE a.idDgoProcSuper=b.idDgoProcSuper 
	AND a.idDgpUnidad=c.idDgpUnidad AND b.idGenEstado=1",
			'onclick' => ' onchange="muestraGrid()" ',
			'soloLectura' => 'false',
			'ancho' => '400'
		),
	);
?>
	<script type="text/javascript" src="<?php echo 'modulos/' . $directorio ?>/validacion.js"></script>
	<script src="../js/sha1.js" type="text/jscript"></script>
	<script>
		function muestraGrid() {
			var c = $('#idDgoActUnidadX').val();
			var sql = escape("<?php echo $sqltable ?>" + c);
			var urlf = "modulos/configvisita/fechas.php?c=" + c;
			var targetURL = "modulos/muestraresultados.php?page=1&grilla=<?php echo $tgrid ?>&opc=<?php echo $_GET['opc'] ?>&sql=" + sql;
			$('#fechasRango').load(urlf);
			$('#retrieved-data').load(targetURL);
			getregistro(0);
		}

		function grabador(c, d) {
			grabaregistro(c, d);
			muestraGrid();
		}

		function eliminador(c, d) {
			delregistro(c, d);
			muestraGrid();
		}
	</script>
	<div id="filtro" style="border-bottom:solid 3px #777;height:40px">
		<table width="100%">
			<tr>
				<td class="etiqueta">Proceso Unidad:</td>
				<td>
					<?php
					foreach ($formulario as $campos)
						generaComboSimpleSQL(
							$conn,
							$campos['tabla'],
							$campos['campoTabla'],
							'descripcion',
							isset($rowt[$campos['campoTabla']]) ? $rowt[$campos['campoTabla']] : '',
							$campos['sql'],
							$campos['onclick'],
							(empty($campos['ancho']) ? 'width:250px' : 'width:' . $campos['ancho'] . 'px')
						);

					?></td>
			</tr>
		</table>
	</div>
	<div id='fechasRango'>
	</div>
	<div id='formulario'>
		<img src="../funciones/paginacion/images/ajax-loader.gif" />
	</div>
	<div id='retrieved-data'>
		<img src="../funciones/paginacion/images/ajax-loader.gif" />
	</div>
<?php  // Este archivo contiene las funciones de ajax para update, insert, delete, y edit 
} else
	header('Location: imprime.php');
?>