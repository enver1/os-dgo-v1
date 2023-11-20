<?php
session_start();
header('Content-Type: text/html; charset=UTF-8');
include '../../../../clases/autoload.php';
$dgoInfOrdenServicio = new DgoInfOrdenServicio;
$idDgoInfOrdenServicio       = strip_tags($_GET['id']);
$row        = $dgoInfOrdenServicio->validaEstadoInforme($idDgoInfOrdenServicio);
?>
<div class="col2" style="width:400px;margin-left:40px;margin-top:30px;background-color:#eee">
	<table border="0" style="font-size:14px;text-align:left" width="100%">
		<tr>
			<?php if ($row['verificado'] == 'N') { ?>
				<td colspan="2" style="height:30px">
					<span>NO VERIFICADO</span>
				</td>
			<?php } else { ?>
				<td style="height:30px"><span>VERIFICADO EL</td>
				<td><span style="font-weight:normal"><?php echo $row['fechaVerificado'] ?></span></td>
			<?php } ?>
		</tr>
		<tr>
			<?php if ($row['procesado'] == 'N') { ?>
				<td colspan="2" style="height:30px">
					<span>NO PROCESADO</span>
				</td>
			<?php } else { ?>
				<td style="height:30px">
					<span>PROCESADO EL
				</td>
				<td><span style="font-weight:normal"><?php echo $row['fechaProcesado'] ?></span></td>
			<?php } ?>
		</tr>
		<tr>
			<?php if ($row['impreso'] == 'N') { ?>
				<td colspan="2" style="height:30px">
					<span>NO IMPRESO</span>
				</td>
			<?php } else { ?>
				<td style="height:30px">
					<span>IMPRESO EL
				</td>
				<td><span style="font-weight:normal"><?php echo $row['fechaImpresoUno'] ?></span></td>
			<?php } ?>
		</tr>
	</table>
</div>