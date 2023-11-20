<?php 	
include_once('../funciones/funcion_select.php');
/*-----------------------------------------*/
	$sNtabla='hdrIntegrante'; // *** CAMBIAR ** Nombre de la tabla;
/*------------------------------------------*/
// Personalizar de acuerdo al numero de columnas que se muestran en el grid, tanto en los titulos como en
// las filas 
/*-----------------------------------------*/

		$idcampo=ucfirst($sNtabla); // Nombre del Id de la Tabla primera mayuscula
		$sql="select a.idHdrRecurso idHdrRecurso, a.nominativo nominativo, b.descripcion descripcion from hdrRecurso a, hdrEstadoRecurso b where a.idHdrEstadoRecurso=b.idHdrEstadoRecurso and sha1(a.idHdrRuta)='".$_GET['recno']."' and a.idHdrEstadoRecurso='1'" ;
?>
<table>
	<tr>
    	
    </tr>
</table>
<table id='my-tbl'>
<tr>
	<th class="data-th">Codigo</th>
    <th class="data-th">Nominativo</th>
	<th class="data-th">Grado</th>
	<th class="data-th">Apellido 1</th>
    <th class="data-th">Apellido 2</th>
    <th class="data-th">Nombres</th>
	<th class="data-th">Función</th>
	<th class="data-th">Editar</th>
    <th class="data-th">Eliminar</th>
</tr>

<?php	
	//loop por cada registro
	while ($rowRE = $rs->fetch(PDO::FETCH_ASSOC)){
		echo "<tr class='data-tr' align='center'>";
		echo "<td>".$rowRE['id'.$idcampo]."</td>";
		echo "<td>{$rowRE['nominativo']}</td>";
		echo "<td>{$rowRE['estado']}</td>";
		echo '<td><a href="/operaciones/modulos/hdr/intengrantesforma.php?id='.$rowRE['id'.$idcampo].'&recno='.$_GET['recno'].'&pesta='.$_GET['pesta'].'&opc='.$_GET['opc'].' " onclick="return GB_showPage(\'R E C U R S O S\', this.href)"><span>Editar</span></td>';
		echo "</tr>";
	}
?>	
</table>
<a href="/operaciones/modulos/hdr/integrantesforma.php?id=0<?php echo '&recno='.$_GET['recno']?>&pesta=<?php echo $_GET['pesta'] ?>&opc=<?php echo $_GET['opc'] ?>" class="button" onclick="return GB_showPage('R E C U R S O S', this.href)"><span>Nuevo</span></a>
<br />