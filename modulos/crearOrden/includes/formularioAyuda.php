<?php
session_start();
include_once('../../../../funciones/funciones_generales.php');
include_once('../../../../clases/autoload.php');
$conn = DB::getConexionDB();
$sql = "	SELECT      os.idDgoOrdenServicio,
						os.jefeOperativo,
						os.comandanteUnidad,
						os.nombreElabora,
						os.nombreOperativo,
						os.fechaOrden,
						os.horaOrden,
						os.horaFormacion,
						os.estadoOrden,   
						tc.descripcion as calificacion,
						gt.descripcion as tipoOperativo,
						gt1.descripcion as operativo
						FROM
						dgoOrdenServicio os
						INNER JOIN dgoTipoCalificacion tc ON tc.idDgoTipoCalificacion = os.idDgoTipoCalificacion
						INNER JOIN genTipoOperativo gt ON gt.idGenTipoOperativo = os.idGenTipoOperativo
						INNER JOIN genTipoOperativo gt1 ON gt1.idGenTipoOperativo = gt.genTipoOperativo_idGenTipoOperativo
						WHERE
							os.idDgoOrdenServicio ='" . $_GET['id'] . "'";
$rs = $conn->query($sql);
$row = $rs->fetch(PDO::FETCH_ASSOC);

?>
<div class="formaper" style="width:95%;text-align:left;font-size:11px;background-color:#A0C8F3;color:#0c0c0b;margin:5px auto;border-width:1px;font-weight:normal" align="left">
	<table width="100%" border="0">
		<tr>
			<td class="etiqueta">Jefe del Operativo:</td>
			<td style="padding-top:3px" align="left"><?php echo $row[upc('jefeOperativo')] ?>
			</td>
			<td class="etiqueta">Nombre Operativo:</td>
			<td><?php echo $row[upc('nombreOperativo')] ?></td>
		</tr>
		<tr>
			<td class="etiqueta">Operativo:</td>
			<td style="padding-top:3px" align="left"><?php echo $row[upc('operativo')] ?>
			</td>
			<td class="etiqueta">Tipo Operativo:</td>
			<td><?php echo $row[upc('tipoOperativo')] ?></td>
		</tr>
		<tr>
			<td class="etiqueta">Fecha Orden:</td>
			<td><?php echo $row[upc('fechaOrden')] ?>
			</td>
			<td class="etiqueta">Estado Orden:</td>
			<td><?php echo $row[upc('estadoOrden')] ?>
			</td>
		</tr>
	</table>
</div>