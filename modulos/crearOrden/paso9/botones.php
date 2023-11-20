<?php
session_start();
header('Content-Type: text/html; charset=UTF-8');
include_once 'config.php';
include_once '../../../../clases/autoload.php';
$crearOrdenServicio = new CrearOrdenServicio;
$tprint     = $directorio . '/imprime.php'; // nombre del php que imprime los registros
$tprevi     = $directorio . '/previsualiza.php'; // nombre del php que previsualiza los registros
// $dt         = new DateTime('now', new DateTimeZone('America/Guayaquil'));
// $hoy        = $dt->format('Y-m-d');
$idDgoOrdenServicio       = strip_tags($_GET['id']);
$row        = $crearOrdenServicio->validaEstadoOrden($idDgoOrdenServicio);
?>
<table border="0">
	<tr>
		<td colspan="2">
			<?php if ($row['verificado'] == 'N') { ?>
				<a href="javascript:void(0)" onclick="return verifica(<?php echo $idDgoOrdenServicio ?>)">
					<img src="../../../../imagenes/iconos/verificar.png" alt="0" border="0" id="icono" /></a>
			<?php } else { ?>
				<img src="../../../../imagenes/iconos/verificarno.png" alt="0" border="0" id="icono" />
			<?php } ?>
		</td>
	</tr>
	<tr>
		<td colspan="2">
			<?php if ($row['procesado'] == 'N' and $row['verificado'] == 'S') { ?>
				<a href="javascript:void(0)" onclick="previsualiza()">
					<img src="../../../../imagenes/iconos/previsualizar.png" alt="0" border="0" id="icono" /></a>
			<?php } else { ?>
				<img src="../../../../imagenes/iconos/previsualizarno.png" alt="0" border="0" id="icono" />
			<?php } ?>
		</td>
	</tr>
	<tr>
		<td colspan="2">
			<?php if ($row['procesado'] == 'N' and $row['verificado'] == 'S') { ?>
				<a href="javascript:void(0)" onclick="return procesar()">
					<img src="../../../../imagenes/iconos/procesar.png" alt="0" border="0" id="icono" /></a>
			<?php } else { ?>
				<img src="../../../../imagenes/iconos/procesarno.png" alt="0" border="0" id="icono" />
			<?php } ?>
		</td>
	</tr>
	<tr>
		<td colspan="2">
			<?php if ($row['procesado'] == 'S' and $row['verificado'] == 'S' and $row['estadoOrden'] == 'VALIDADA') { ?>
				<a href="javascript:void(0)" onclick="imprimir()">
					<img src="../../../../imagenes/iconos/imprimir.png" alt="0" border="0" id="icono" /></a>
			<?php } else { ?>
				<img src="../../../../imagenes/iconos/imprimirno.png" alt="0" border="0" id="icono" />
			<?php } ?>
		</td>
	</tr>

</table>