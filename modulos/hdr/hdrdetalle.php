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
include_once('../../../funciones/paginacion/libs/ps_pagination.php');
include_once('../../../funciones/funciones_generales.php');

$sql = "SELECT a.idHdrRuta, CONCAT(v_persona.apellido1,' ',v_persona.nombre1)AS'jefe', c.descGestionAdmin nomenclatura, a.fechaHdrRutaInicio, a.fechaHdrRutaFin, a.horarioInicio, a.horarioFin, DATE(NOW()) fecha_hoy, v_persona.siglas 
FROM
  hdrRuta a 
  INNER JOIN genActividadGA b 
    ON a.idGenActividadGA = b.idGenActividadGA 
  INNER JOIN genGestionAdmin c 
    ON b.idGenGestionAdmin = c.idGenGestionAdmin 
  INNER JOIN v_persona
    ON a.idGenPersona = v_persona.idGenPersona
WHERE b.idGenActividadGA = {$_REQUEST['unidad']} 
ORDER BY a.idHdrRuta DESC ";

$pager = new PS_Pagination( $conn, $sql, 25, 10, null );

if($rs = $pager->paginate())
{
	$num = $rs->rowCount();
}
else
{$num=0;}
echo "<div class='page-nav' style='margin-bottom:5px'>";
echo $pager->renderFullNav();
echo "</div>";

if($num >= 1 ){
?>
<table id='my-tbl'>
	<tr>
		<th class="data-th">Codigo</th>
		<th class="data-th">Jefe de Control</th>
		<th class="data-th">Unidad</th>
		<th class="data-th">Fecha Inicial</th>
		<th class="data-th">Fecha Final</th> 
	    <th class="data-th">Horario Inicial</th>
		<th class="data-th">Horario Final</th>
	    <th class="data-th">Editar</th>
		<th class="data-th">Eliminar</th>
		<th class="data-th">Duplicar</th>
	</tr>
	<?php	
		//loop por cada registro
		while ($rowHR = $rs->fetch(PDO::FETCH_ASSOC)){

			$color = '';
			if(isset($_GET['recno'])){
				if($_GET['recno'] == sha1($rowHR['idHdrRuta'])){
					$color = 'style="background-color: gray;"';
				}
			}

			echo "<tr class='data-tr' align='center' $color >";
			echo "<td>{$rowHR['idHdrRuta']}</td>";
			echo "<td>{$rowHR['siglas']}. {$rowHR['jefe']}</td>";
			echo "<td>{$rowHR['nomenclatura']}</td>";
			echo "<td>{$rowHR['fechaHdrRutaInicio']}</td>";
			echo "<td>{$rowHR['fechaHdrRutaFin']}</td>";
			echo "<td>{$rowHR['horarioInicio']}</td>";
			echo "<td>{$rowHR['horarioFin']}</td>";
			if(isset($_SESSION['privilegios']) and substr($_SESSION['privilegios'],1,1)==1 and $rowHR['fechaHdrRutaInicio']>=$rowHR['fecha_hoy']) {
				echo '<td><a href="index.php?opc='.$_REQUEST['opc'].'&pesta=1&recno='.sha1($rowHR['idHdrRuta']).'">Editar</a></td>';}
			else
				{echo '<td>&nbsp;</td>';}
	    if(isset($_SESSION['privilegios']) and substr($_SESSION['privilegios'],2,1)==1 and $rowHR['fechaHdrRutaInicio']>=$rowHR['fecha_hoy']) {
				echo '<td><a href="javascript:void(0);" onclick="delregistro(\''.$_REQUEST['opc'].'\',\'1\',\''.sha1($rowHR['idHdrRuta']).'\')">Eliminar</a></td>';}
			else
				{echo '<td>&nbsp;</td>';}
				echo '<td><a href="/operaciones/modulos/hdr/hdrduplicar.php?opc='.$_REQUEST['opc'].'&pesta=1&recno='.sha1($rowHR['idHdrRuta']).'" onclick="return GB_showPage(\'H O J A  D E  R U T A\',this.href)">Elegir</a></td>';
			echo "</tr>";
		}
	?>	
</table>
<?php 
}else{
	echo "No hay registros!";
}
echo "<div class='page-nav'>";
echo $pager->renderFullNav();
echo "</div>";
?>