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
include_once('../../../../clases/autoload.php');
include_once('../../../../funciones/paginacion/libs/ps_pagination.php');
include_once('../../../../funciones/funciones_generales.php');
$conn = DB::getConexionDB();
/**
 * Sql a ejecutarse
 */

$sql = "SELECT a.idHdrRuta,c.descGestionAdmin nomenclatura,a.fechaHdrRutaInicio,a.fechaHdrRutaFin,a.horarioInicio,a.horarioFin,DATE(NOW()) fecha_hoy 
FROM hdrRuta a INNER JOIN genActividadGA b ON a.idGenActividadGA=b.idGenActividadGA 
INNER JOIN genGestionAdmin c ON b.idGenGestionAdmin=c.idGenGestionAdmin 
WHERE b.idGenActividadGA = {$_REQUEST['unidad']} AND (a.fechaHdrRutaInicio BETWEEN '{$_REQUEST['fecha']}' AND '{$_REQUEST['fechafin']}' )";
echo '<hr />';
$pager = new PS_Pagination($conn, $sql, 25, 10, null);

if ($rs = $pager->paginate()) {
	$num = $rs->rowCount();
} else {
	$num = 0;
}
echo "<div class='page-nav' style='margin-bottom:5px'>";
echo $pager->renderFullNav();
echo "</div>";

if ($num >= 1) {
?>
	<table id='my-tbl'>
		<tr>
			<th class="data-th">Codigo</th>
			<th class="data-th">Unidad</th>
			<th class="data-th">Fecha Inicial</th>
			<th class="data-th">Fecha Final</th>
			<th class="data-th">Horario Inicial</th>
			<th class="data-th">Horario Final</th>
			<th class="data-th">Imprimir</th>
		</tr>
		<?php
		//loop por cada registro
		while ($row = $rs->fetch(PDO::FETCH_ASSOC)) {
			echo "<tr class='data-tr' align='center'>";
			echo "<td>{$row['idHdrRuta']}</td>";
			echo "<td>{$row['nomenclatura']}</td>";
			echo "<td>{$row['fechaHdrRutaInicio']}</td>";
			echo "<td>{$row['fechaHdrRutaFin']}</td>";
			echo "<td>{$row['horarioInicio']}</td>";
			echo "<td>{$row['horarioFin']}</td>";
			echo "<td><a href='javascript:void(0);' onclick='imprimirdata(\"" . sha1($row['idHdrRuta']) . "\")'>Elegir</a></td>";
			echo "</tr>";
		}
		?>
	</table>
	<br />
<?php
} else {
	echo "No hay registros!";
}
echo "<div class='page-nav'>";
echo $pager->renderFullNav();
echo "</div>";
?>