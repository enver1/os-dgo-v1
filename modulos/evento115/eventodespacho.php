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

$sql = "SELECT er.idRecursoEvento, r.nominativo, er.descripcion, r.idHdrRecurso FROM hdrRecursoEvento er
INNER JOIN hdrRecurso r ON er.idHdrRecurso = r.idHdrRecurso
WHERE er.idHdrEvento = {$_REQUEST['codigoEvento']}
ORDER BY nominativo ASC";

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
<style>
	a.tooltipIM:hover {text-decoration:none;}
	a.tooltipIM span {
		z-index:10;display:none; padding:14px 10px;
		margin-top:-100px; margin-left:-220px;
		width:241px; line-height:16px;
	}
	a.tooltipIM:hover span{
		display:inline; position:absolute;
		/*background:url(/operaciones/imagenes/img_tool_im.png) no-repeat;*/
		padding: 8px
		15px;
		background-color: #e6eef0;
		-moz-border-radius: 5px;
		-webkit-border-radius: 5px;
		margin: 10px
		0;
		/*  width:241px;
		 height:109px; */
	}
</style>
<table id='my-tbl' style="width: 100%;">
	<tr>
		<th class="data-th">Codigo</th>
		<th class="data-th">Nominativo</th>
		<th class="data-th">Descripci&oacute;n</th>
		<th class="data-th">Personal</th>
		<th class="data-th">&nbsp;</th> 
		<th class="data-th">&nbsp;</th> 
	</tr>
	<?php	
		//loop por cada registro
		while ($rowHR = $rs->fetch(PDO::FETCH_ASSOC)){
		?>
	<tr class='data-tr' align='center'>
		<td><?php echo $rowHR['idRecursoEvento']?></td>
		<td><?php echo $rowHR['nominativo']?></td>
		<td><?php echo $rowHR['descripcion']?></td>
		<td>
		<a class="tooltipIM" href="javascript:void(0)">
			<img src="/operaciones/imagenes/Policia.png"/>
			<span style="color:blue;" class="fichaSel">
                <table border="0" cellspacing="0">
		            <tbody>
		            <?php 
		            $sqlgrid="Select i.idHdrIntegrante integrante, p.siglas grado, p.apenom nombres, f.descripcion funcion from v_persona p, hdrIntegrante i, hdrFuncion f where i.idHdrFuncion=f.idHdrFuncion and i.idGenPersona=p.idGenPersona and i.idHdrRecurso='".$rowHR['idHdrRecurso']."'";
		            $rs2=$conn->query($sqlgrid);
		            
		            while ($rowRE3 = $rs2->fetch(PDO::FETCH_ASSOC))
		            {
		            	if ($rowRE3['funcion']=='Jefe de Patrulla'){
		            		$imagen='Jefe.png';
		            	}
		            	if ($rowRE3['funcion']=='Auxiliar'){
		            		$imagen='Auxiliar.png';
		            	}
		            	if ($rowRE3['funcion']=='Conductor'){
		            		$imagen='Conductor.png';
		            	}
		            	if ($rowRE3['funcion']=='Guardia'){
		            		$imagen='Guardia.png';
		            	}
		            	?>
		            	<tr>
							<td><img src="/operaciones/imagenes/<?php echo $imagen?>"/></td><td><?php echo $rowRE3['grado']?></td><td><?php echo $rowRE3['nombres']?></td>
						</tr>
		            	<?php
		            }
		            ?>
				    </tbody>
				</table>
			</span>
		</a>
		</td>
		<td><a href="javascript:void(0)" onclick="return GB_showPage('REGISTRO DE ACTIVIDADES', '/operaciones/modulos/evento115/ingresarActividad.php?idRecursoEvento=<?php echo $rowHR['idRecursoEvento']?>')">Resgitrar Actividad</a></td>
		<td><a href="javascript:void(0)" onclick="eliminarAsignacionrecurso('<?php echo $rowHR['idRecursoEvento']?>','<?php echo "{$_REQUEST['codigoEvento']}"?>')">Eliminar</a></td>
	</tr>
		<?php
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