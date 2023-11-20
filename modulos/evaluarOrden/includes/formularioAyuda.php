<?php
session_start();
include_once('../../../../funciones/funciones_generales.php');
include_once('../../../../clases/autoload.php');
$conn = DB::getConexionDB();
$sql = "	SELECT      os.idDgoInfOrdenServicio,
						os.responsableInforme,
						os.comandanteUnidad,
						os.nombreElabora,
						os.nombreInforme,
						os.detalleInforme,
						os.fechaInforme,
						os.horaInforme,
						os.estadoInforme,   
						tc.descripcion as calificacion
						FROM
						dgoInfOrdenServicio os
						INNER JOIN dgoTipoCalificacion tc ON tc.idDgoTipoCalificacion = os.idDgoTipoCalificacion
						WHERE
							os.idDgoInfOrdenServicio ='" . $_GET['id'] . "'";
$rs = $conn->query($sql);
$row = $rs->fetch(PDO::FETCH_ASSOC);

?>
<div class="formaper" style="width:95%;text-align:left;font-size:11px;background-color:#A0C8F3;color:#0c0c0b;margin:5px auto;border-width:1px;font-weight:normal" align="left">
	<table width="100%" border="0">
		<tr>
			<td class="etiqueta">Responsable Informe:</td>
			<td style="padding-top:3px" align="left"><?php echo $row[upc('responsableInforme')] ?>
			</td>
		</tr>
		<tr>
			<td class="etiqueta">Nombre Informe:</td>
			<td style="padding-top:3px" align="left"><?php echo $row[upc('nombreInforme')] ?>
			</td>
			<td class="etiqueta">Detalle Informe:</td>
			<td><?php echo $row[upc('detalleInforme')] ?></td>
		</tr>
		<tr>
			<td class="etiqueta">Fecha Informe:</td>
			<td><?php echo $row[upc('fechaInforme')] ?>
			</td>
			<td class="etiqueta">Estado Informe:</td>
			<td><?php echo $row[upc('estadoInforme')] ?>
			</td>
		</tr>
	</table>
</div>