<?php 
/**
 * verificar la sessión
 */
if (!isset($_SESSION)) { session_start(); }

error_reporting(0);

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

$sql = "SELECT idHdrTipoResum, desHdrTipoResum FROM hdrTipoResum WHERE idHdrGrupResum = {$_GET['idHdrGrupResum']}";

$pager = new PS_Pagination( $conn, $sql, 25, 10, null );

if($rs = $pager->paginate())
{
	$num = $rs->rowCount();
}
else
{
	$num=0;
}
echo "<div class='page-nav' style='margin-bottom:5px'>";
echo $pager->renderFullNav();
echo "</div>";

if($num >= 1 ){
?>
<table id='my-tbl'>
	<tr>
		<th class="data-th">C&oacute;digo</th>
		<th class="data-th">Descripci&oacute;n</th>
		<th class="data-th">&nbsp;</th>
		<th class="data-th">&nbsp;</th>
		
	</tr>
	<?php	
		//loop por cada registro
		while ($rowHR = $rs->fetch(PDO::FETCH_ASSOC)){
			echo "<tr class='data-tr' align='center' >";
			echo "<td>{$rowHR['idHdrTipoResum']}</td>";
			echo "<td>{$rowHR['desHdrTipoResum']}</td>";
			if(isset($_SESSION['privilegios']) and substr($_SESSION['privilegios'],1,1)==1) {
			echo "<td><a href='tiporesumen.php?idHdrGrupResum={$_GET['idHdrGrupResum']}&idHdrTipoResum={$rowHR['idHdrTipoResum']}'>Editar</a></td>";}
		else
			{echo '<td>&nbsp;</td>';}
    if(isset($_SESSION['privilegios']) and substr($_SESSION['privilegios'],2,1)==1) {
			echo '<td><a href="javascript:void(0);" onclick="return delregistroTipo('.$rowHR['idHdrTipoResum'].')">Eliminar</a></td>';}
		else
			{echo '<td>&nbsp;</td>';}
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