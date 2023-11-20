<?php
/**
 * verificar la sessión
 */
if (!isset($_SESSION)) { session_start(); }

/**
 * cabecera
 */
header('Content-Type: text/html; charset=UTF-8');

/**
 * archivos que se incluyen en la ejecución del script
*/
include_once('../../../funciones/db_connect.inc.php');

$sql = "SELECT er.idHdrEventoResum, gr.desHdrGrupResum, tr.desHdrTipoResum, er.cantidad, er.descEventoResum
FROM hdrEventoResum er
INNER JOIN hdrTipoResum tr ON er.idHdrTipoResum = tr.idHdrTipoResum
INNER JOIN hdrGrupResum gr ON tr.idHdrGrupResum = gr.idHdrGrupResum
WHERE er.idHdrEvento = {$_REQUEST['codigoEvento']}
ORDER BY desHdrGrupResum ASC";
$rs = $conn->query($sql);
?>
<table style="width: 100%;">
	<tr>
		<th class="data-th" width="15%">Codigo</th>
		<th class="data-th" width="25%">Detalle</th>
		<th class="data-th" width="25%">Par&aacute;metro</th>
		<th class="data-th" width="5%">cantidad</th>
		<th class="data-th" width="30%">Descripci&oacute;n</th> 
		<th class="data-th" width="30%">&nbsp;</th>
	</tr>
	<?php	
		//loop por cada registro
		while ($rowHR = $rs->fetch(PDO::FETCH_ASSOC)){
		?>
	<tr  class='data-tr' align='center'>
		<td><?php echo $rowHR['idHdrEventoResum']?></td>
		<td><?php echo $rowHR['desHdrGrupResum']?></td>
		<td><?php echo $rowHR['desHdrTipoResum']?></td>
		<td><?php echo number_format($rowHR['cantidad'],0)?></td>
		<td><?php echo $rowHR['descEventoResum']?></td>
		<td><a href="javascript:void(0)" onclick="eliminarEventoDetalle('<?php echo $rowHR['idHdrEventoResum']?>','<?php echo $_REQUEST['codigoEvento'];?>')">Eliminar</a></td>
	</tr>	
		<?php
		}
	?>	
</table>