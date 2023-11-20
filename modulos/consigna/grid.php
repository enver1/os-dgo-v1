<?php 	
if (!isset($_SESSION)){ session_start();}
/*-----------------------------------------*/
	$sNtabla='hdrConsigna'; // *** CAMBIAR ** Nombre de la tabla;
/*------------------------------------------*/
// Personalizar de acuerdo al numero de columnas que se muestran en el grid, tanto en los titulos como en
// las filas 
/*-----------------------------------------*/
	$idcampo=ucfirst($sNtabla); // Nombre del Id de la Tabla primera mayuscula
?>
<table id='my-tbl'>
<tr>
	<th class="data-th">Codigo</th>
	<th class="data-th">Lugar</th>
	<th class="data-th">Estado</th>
    <th class="data-th">Descripción</th>
	<th class="data-th">Inicio</th>
	<th class="data-th">Fin</th>
    <th class="data-th">Observación</th>
    <th class="data-th">Editar</th>
	<th class="data-th">Eliminar</th>
</tr>
<?php	
	//loop por cada registro
	while ($row = $rs->fetch(PDO::FETCH_ASSOC)){
		echo "<tr class='data-tr' align='center'>";
		echo "<td>".$row['id'.$idcampo]."</td>";
		echo "<td>{$row['idGenGeoSenplades']}</td>";
		echo "<td>{$row['idGenEstado']}</td>";
		echo "<td>{$row['descripcionConsigna']}</td>";
		echo "<td>{$row['fechaInicial']}</td>";
		echo "<td>{$row['fechaCaducidad']}</td>";
		echo "<td>{$row['observacion']}</td>";

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
