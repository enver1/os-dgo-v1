<?php

/**
 * verificar la sessi�n
 */
if (!isset($_SESSION)) {
	session_start();
}

/**
 * cabecera
 */
header('Content-Type: text/html; charset=UTF-8');

/**
 * archivos que se incluyen en la ejecuci�n del script
 */
include_once('../../../clases/autoload.php');
include_once('../../../funciones/paginacion/libs/ps_pagination.php');
include_once('../../../funciones/funciones_generales.php');
include_once 'logica/logica.php';
/**
 * obtener datos desde una clase
 */
$conn = DB::getConexionDB();
$logica = new logica($conn);

include 'sincronizarEventos.php';

$array = $logica->getFichaEvento($_SESSION['usuarioAuditar'], 12);

$estadosEcu = array(1 => "No esta tratando", 2 => "Esta Tratando", 3 => "Transferido", 4 => "Ya Transferido", 5 => "Finalizado");
$alertasEcu = array('V' => 'CLAVE VERDE', 'A' => 'CLAVE AMARILLA', 'N' => 'CLAVE NARANJA', 'R' => 'CLAVE ROJA');
$alertasEcuColores = array('V' => '#7FFF00', 'A' => '#FFFF00', 'N' => '#FFA500', 'R' => '#FF0000');
?>
<span class="texto_gris">Listado de Alertas</span>
<br /><br />
<table id='my-tbl'>
	<tr>
		<th class="data-th">NUMERO DE FICHA</th>
		<th class="data-th">DESCRIPCION</th>
		<th class="data-th">ESTADO</th>
		<th class="data-th">NIVEL DE ALERTA</th>
		<th class="data-th">SELECCIONAR</th>
	</tr>
	<?php
	foreach ($array as $row) {
	?>
		<tr class='data-tr' align='center' style="background-color: <?php echo $alertasEcuColores[$row['nivelAlerta']]; ?>;">
			<td><?php echo $row['codigoEvento'] ?></td>
			<td><?php echo $row['descripcion'] ?></td>
			<td><?php echo $estadosEcu[$row['estadoEcu']] ?></td>
			<td><?php echo $alertasEcu[$row['nivelAlerta']] ?></td>
			<td><button type="button" onclick="MostrarFichaEcu(<?php echo $row['idHdrEvento'] ?>)" class="boton_general">Seleccionar</button></td>
		</tr>
	<?php
	}
	?>
</table>