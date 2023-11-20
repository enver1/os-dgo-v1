<?php
include_once '../clases/autoload.php';
$conn = DB::getConexionDB();
$sql = "select * from v_datos_GA where sha1(idGenUsuarioAplicacion)='" . $_GET['opc'] . "' and idGenUsuario=" . $_SESSION['usuarioAuditar'];
/**
 * ejecutando consulta
 */
$rs = $conn->query($sql);
/**
 * obteniendo resultado
 */
$rowUnidad = $rs->fetch();
if (!isset($rowUnidad['idGenActividadGA'])) {
	echo 'Solicite al Administrador del Sistema que le asigne una Unidad de Gesti&oacute;n Administrativa';
} else {
?>
	<div id="formulariocabecera" style="overflow:hidden;width:900px;float:left;padding-top:10px">
		<?php include_once("cabecera.php"); ?>
	</div>
	<div id="botonesPestania" style="margin-top:10px;overflow:hidden;width:900px;height:30px;float:left;">
		<?php
		$recno = '';
		if (isset($_GET['recno']))
			$recno = "&recno=" . $_GET['recno'];
		?>
		<table width="100%" cellspacing="0" cellpadding="0" style="height:30px" border="0">
			<tr>
				<td width="25%" id="p1" class="<?php echo (isset($_GET['pesta']) and $_GET['pesta'] == 1) ? "fichaSel" : "ficha" ?>" align="center">
					<a href="index.php?opc=<?php echo $_GET['opc'] ?>&pesta=1<?php echo $recno ?>" class="pestania">Hojas de Ruta</a>
				</td>
				<td width="25%" id="p2" class="<?php echo (isset($_GET['pesta']) and $_GET['pesta'] == 2) ? "fichaSel" : "ficha" ?>" align="center">
					<a href="index.php?opc=<?php echo $_GET['opc'] ?>&pesta=2<?php echo $recno ?>" class="pestania">Recursos</a>
				</td>
				<td width="25%" id="p3" class="<?php echo (isset($_GET['pesta']) and $_GET['pesta'] == 3) ? "fichaSel" : "ficha" ?>" align="center">
					<a href="index.php?opc=<?php echo $_GET['opc'] ?>&pesta=3<?php echo $recno ?>" class="pestania">Recursos a Pie</a>
				</td>
				<td width="25%"></td>
			</tr>
		</table>
	</div>
	<div id="formulariodetalle" style="overflow:hidden;width:904px;float:left;">
		<?php if (isset($_GET['pesta'])) {
			switch ($_GET['pesta']) {
				case 1:
		?>
					<div id="hdrdetalleID" style="width:900px;float:left;border:solid 2px #474747">
						<div id='retrieved-data'>
							<img src="../funciones/paginacion/images/ajax-loader.gif" />
						</div>
						<script type="text/javascript">
							getdata(1);
						</script>
					</div>
				<?php break;
				case 2:
				?>
					<div id="nominativos" style="width:900px;float:left;border:solid 2px #474747">
						<div id='retrieved-data'>
							<img src="../funciones/paginacion/images/ajax-loader.gif" />
						</div>
						<script type="text/javascript">
							getdata(1);
						</script>
					</div>
				<?php break;
				case 3:
				?>
					<div id="recursospie" style="width:900px;float:left;border:solid 2px #474747">
						<div id='retrieved-data'>
							<img src="../funciones/paginacion/images/ajax-loader.gif" />
						</div>
						<script type="text/javascript">
							getdata(1);
						</script>
						<?php //include_once("recursospie.php"); 
						?>
					</div>
			<?php
					break;
			}
		} else {
			?>
			<div id="hdrdetalleID" style="width:900px;float:left;border:solid 2px #474747">
				<div id='retrieved-data'>
					<img src="../funciones/paginacion/images/ajax-loader.gif" />
				</div>
				<script type="text/javascript">
					getdata(1);
				</script>
			</div>
		<?php
		} ?>
	</div>
<?php
}
?>