<?php
session_start();
include '../../../clases/autoload.php';
include_once('../../../funciones/funcion_select.php');
$conn = DB::getConexionDB();
$tgraba = 'vehiculos/graba.php';
$directorio = 'modulos/vehiculos';
$idcampo = 'idHdrVehiculo';

if (isset($_GET['c'])) {

	$sql = "SELECT 
	  hdrVehiculo.idHdrVehiculo,
	  genVehiculo.placa,
	  genVehiculo.motor,
	  genVehiculo.chasis,
	  dgpUnidad.nomenclatura,
	  genVehiculo.idGenVehiculo,
	  hdrVehiculo.idDgpUnidad,
	  hdrVehiculo.idGenEstado,
	  hdrVehiculo.fechaAsignacion
	FROM
	  hdrVehiculo 
	  INNER JOIN dgpUnidad 
	    ON hdrVehiculo.idDgpUnidad = dgpUnidad.idDgpUnidad 
	  INNER JOIN genVehiculo 
	    ON genVehiculo.idGenVehiculo = hdrVehiculo.idGenVehiculo
	WHERE hdrVehiculo.idHdrVehiculo = '{$_GET['c']}'";
	$rs = $conn->query($sql);
	$rowt = $rs->fetch(PDO::FETCH_ASSOC);
}
/*
* Aqui se incluye el formulario de edicion
*/
?>

<form name="edita" id="edita" method="post">
	<table width="100%" border="0">
		<tr>
			<td class="etiqueta">C&oacute;digo:</td>
			<td>
				<input type="text" name="idHdrVehiculo" readonly="readonly" value="<?php echo isset($rowt['idHdrVehiculo']) ? $rowt['idHdrVehiculo'] : '' ?>" class="inputSombra" style="width:80px" />
			</td>
		</tr>
		<?php /*---------------------------------------------------*/
		//  *** CAMBIAR ***  
		?>
		<tr>
			<td class="etiqueta">Unidad Policial:</td>
			<td>
				<table border="0" width="100%">
					<tr>
						<td>
							<input type="hidden" name="idDgpUnidad" id="idDgpUnidad" value="<?php echo isset($rowt['idDgpUnidad']) ? $rowt['idDgpUnidad'] : '' ?>" size="10" readonly="readonly">
							<label name="Unidad" id="Unidad" style="border:none; background-color:#fff; color:#006; font-size:11px;font-weight:bold;height:auto"><?php echo isset($rowt['nomenclatura']) ? $rowt['nomenclatura'] : '' ?></label>
						</td>
						<td>
							<a href="/operaciones/modulos/hdr/unidad.php?id=0" class="button" id="btnUnidad" onclick="return GB_showPage('U N I D A D E S', this.href)">
								<span>Unidades</span></a>
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td class="etiqueta">
				Vehiculo
			</td>
			<td>
				<table border="0" width="100%">
					<tr>
						<td>
							<input type="hidden" name="idGenVehiculo" id="idGenVehiculo" value="<?php echo isset($rowt['idGenVehiculo']) ? $rowt['idGenVehiculo'] : '' ?>" size="10" readonly="readonly">
							<?php
							$str = '';

							if (!empty($rowt)) {
								if (strlen($rowt['placa']) > 0) {
									$str = $rowt['placa'];
								} else {
									if (strlen($rowt['motor']) > 0) {
										$str = $rowt['motor'];
									} else {
										$str = $rowt['chasis'];
									}
								}
							}
							?>
							<label name="GenVehiculo" id="GenVehiculo" style="border:none; background-color:#fff; color:#006; font-size:11px;font-weight:bold;height:auto"><?php echo $str; ?></label>
						</td>
						<td>
							<a href="/operaciones/modulos/vehiculos/vehiculo.php?id=0" class="button" id="btnVehiculo" onclick="return GB_showPage('V E H I CU L O S', this.href)">
								<span>Buscar</span>
							</a>
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td class="etiqueta">Estado:</td>
			<td> <?php echo generaComboSimple($conn, 'genEstado', 'idGenEstado', 'descripcion', (isset($rowt['idGenEstado']) ? $rowt['idGenEstado'] : '')); ?></td>
		</tr>
		<tr>
			<td class="etiqueta">Fecha de Asignaci&oacute;n:</td>
			<td><input type="text" name="fechaAsig" size="12" value="<?php echo isset($rowt['fechaAsignacion']) ? $rowt['fechaAsignacion'] : '' ?>" readonly="readonly" class="inputSombra" style="width:80px" />
				<input type="button" value="" onclick="displayCalendar(document.forms[0].fechaAsig,'yyyy-mm-dd',this)" class="calendario" id="fechaAsigID" />
			</td>
		</tr>
		<tr>
			<?php /*----------------------------------------------------*/ ?>
			<td colspan="2">
				<hr /><input type="hidden" name="opc" value="<?php echo $_GET['opc'] ?>" />
			</td>
		</tr>
		<?php include_once('../../../funciones/botonera.php'); ?>
	</table>
</form>