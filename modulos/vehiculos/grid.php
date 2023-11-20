
<?php 	

include_once('../../funciones/funcion_select.php');
if (!isset($_SESSION)){ session_start();}
/*-----------------------------------------*/
	$sNtabla='hdrVehiculo'; // *** CAMBIAR ** Nombre de la tabla;
/*------------------------------------------*/
// Personalizar de acuerdo al numero de columnas que se muestran en el grid, tanto en los titulos como en
// las filas 
/*-----------------------------------------*/
	$idcampo=ucfirst($sNtabla); // Nombre del Id de la Tabla primera mayuscula
?>
<table id='my-tbl'>
<tr>
	<th class="data-th">Codigo</th>
	<th class="data-th">Unidad Policial</th>
	<th class="data-th">Marca</th>
	<th class="data-th">Modelo</th>
	<th class="data-th">Veh&iacute;culo</th>
	<th class="data-th">Editar</th>
	<th class="data-th">Eliminar</th>
</tr>
<?php	
	//loop por cada registro
	while ($row = $rs->fetch(PDO::FETCH_ASSOC)){
		echo "<tr class='data-tr' align='center'>";
		echo "<td>".$row['id'.$idcampo]."</td>";
		echo "<td>{$row['unidad']}</td>";
		echo "<td>{$row['marca']}</td>";
		echo "<td>{$row['modelo']}</td>";
		
		$str = '';
		
		if(strlen($row['placa']) > 0){
			$str = $row['placa'];
		}else{
			if(strlen($row['motor']) > 0){
				$str = $row['motor'];
			}else{
				$str = $row['chasis'];
			}
		}
		
		
		echo "<td>$str</td>";
	/*------ De aqui para abajo NO modificar ---------------*/
    if(isset($_SESSION['privilegios']) and substr($_SESSION['privilegios'],1,1)==1) {
			echo '<td><a href="javascript:void(0);" onclick="getregistro('.$row['id'.$idcampo].')">Editar</a></td>';}
		else
			{echo '<td>&nbsp;</td>';}
    if(isset($_SESSION['privilegios']) and substr($_SESSION['privilegios'],2,1)==1) {
			echo '<td><a href="javascript:void(0);" onclick="return delregistro('.$row['id'.$idcampo].')">Eliminar</a></td>';}
		else
			{echo '<td>&nbsp;</td>';}
		echo "</tr>";
	}       
?>	
</table>
<br />
