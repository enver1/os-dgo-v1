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

/**
 * sentencia a ser ejecutada
 */
$sql = "SELECT a.idHdrRecurso, a.nominativo, d.placa placa, b.descripcion estado, d.chasis, d.motor FROM hdrRecurso a, hdrEstadoRecurso b, hdrVehiculo c,genVehiculo d WHERE a.idHdrEstadoRecurso = b.idHdrEstadoRecurso AND c.idGenVehiculo = d.idGenVehiculo AND a.idHdrVehiculo = c.idHdrVehiculo AND SHA1(a.idHdrRuta) = '{$_REQUEST['recno']}' ORDER BY a.idHdrRecurso";

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
	<table id='my-tbl'>
		<tr>
			<th class="data-th">Codigo</th>
			<th class="data-th">Nominativo</th>
			<th class="data-th">Vehiculo</th>
			<th class="data-th">Estado</th>
			<th class="data-th">Editar</th>
			<th class="data-th">Eliminar</th>
		</tr>
	
	<?php
	//loop por cada registro
	while ($rowRE = $rs->fetch(PDO::FETCH_ASSOC)){
		
		$identificativoVehicular = '';
		
		if(strlen($rowRE['placa']) > 0){
			$identificativoVehicular = $rowRE['placa'];
		}else{
			if(strlen($rowRE['chasis']) > 0){
				$identificativoVehicular = $rowRE['chasis'];
			}else{
				$identificativoVehicular = $rowRE['motor'];
			}
		}
		
		echo "<tr class='data-tr' align='center'>";
		echo "<td>{$rowRE['idHdrRecurso']}</td>";
		echo "<td>{$rowRE['nominativo']}</td>";
		echo "<td>$identificativoVehicular</td>";
		echo "<td>{$rowRE['estado']}</td>";
		echo '<td style="text-align:center;">
	
		<a href="/operaciones/modulos/hdr/recursosforma.php?id='.sha1($rowRE['idHdrRecurso']).'&recno='.$_REQUEST['recno'].'&pesta='.$_REQUEST['pesta'].'&opc='.$_REQUEST['opc'].'" onclick="return GB_showPage(\'R E C U R S O S\',this.href)"><img src="/operaciones/imagenes/Nominativo.png"/>
		</a>';
					$sqlgrid="Select i.idHdrIntegrante integrante, p.siglas grado, p.apenom nombres, f.descripcion funcion from v_persona p, hdrIntegrante i, hdrFuncion f where i.idHdrFuncion=f.idHdrFuncion and i.idGenPersona=p.idGenPersona and i.idHdrRecurso='".$rowRE['idHdrRecurso']."'";
							$rs1=$conn->query($sqlgrid);
							$rs2=$conn->query($sqlgrid);
							echo '
							<a class="tooltipIM" href="/operaciones/modulos/hdr/integrantesforma.php?id='.sha1($rowRE['idHdrRecurso']).'&recno='.$_REQUEST['recno'].'&pesta='.$_REQUEST['pesta'].'&opc='.$_REQUEST['opc'].'" onclick="return GB_showPage(\'I N T E G R A N T E S\',this.href)"><img src="/operaciones/imagenes/Policia.png"/>
		<span style="color:blue;"  class="fichaSel">
                <table border="0" cellspacing="0" style="">
                <tbody>';
		if ($rowRE2 = $rs1->fetch(PDO::FETCH_ASSOC))
			{
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
				echo '<tr>
						<td><img src="/operaciones/imagenes/'.$imagen.'"/></td><td>'.$rowRE3['grado'].'</td><td> '.$rowRE3['nombres'].'</td></tr>';
					}
					}
							else
						{
						echo ("Ingrese Integrantes al Nominativo");
	}
	echo '</tbody></table>
							</span>
		</a>
		<a class="tooltipIM" href="/operaciones/modulos/hdr/sectoresforma.php?id='.sha1($rowRE['idHdrRecurso']).'&recno='.$_REQUEST['recno'].'&pesta='.$_REQUEST['pesta'].'&opc='.$_REQUEST['opc'].'" onclick="return GB_showPage(\'S E C T O R E S\',this.href)"><img src="/operaciones/imagenes/Sector.png"/>';
		echo '<span style="color:blue;"  class="fichaSel">';
		echo GetHdrsectorPatrulla(sha1($rowRE['idHdrRecurso']),$conn);
		echo '</span>';
        echo '</a></td>';
        echo '<td><a href="javascript:void(0);" onclick="delRecurso(\''.sha1($rowRE['idHdrRecurso']).'\')">Eliminar</a></td>';
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
<a href="/operaciones/modulos/hdr/recursosforma.php?id=0<?php echo '&recno='.$_REQUEST['recno']?>&pesta=<?php echo $_REQUEST['pesta'] ?>&opc=<?php echo $_REQUEST['opc'] ?>" class="button" onclick="return GB_showPage('R E C U R S O S', this.href)"><span>Nuevo</span></a>
<br>

<?php

/**
 * funcion que obtiene el sector a patrullar
 * @param string $idHdrRecursos
 * @return string
 */
function GetHdrsectorPatrulla($idHdrRecursos, $conn){
	/**
	 * obtener principales
	 */
	$sql="SELECT GROUP_CONCAT(genGeoSenplades.descripcion)AS'sectorPatrulla' FROM genGeoSenplades
	INNER JOIN hdrSectorPatrulla ON genGeoSenplades.idGenGeoSenplades = hdrSectorPatrulla.idGenGeoSenplades
	WHERE SHA(hdrSectorPatrulla.idHdrRecurso) = '$idHdrRecursos'";

	$rs = $conn->query($sql);

	$string = '';

	while($row = $rs->fetch(PDO::FETCH_ASSOC)){
		$string = $row['sectorPatrulla'];
	}

	return strlen($string)>0?$string:'Ingrese Sector al nominativo';
}