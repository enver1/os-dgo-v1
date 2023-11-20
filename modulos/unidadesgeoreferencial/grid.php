<?php 	
/**
 * nombre de tabla y id de campo
 */
$sNtabla = "genUnidadesGeoreferencial";
$idcampo='id'.ucfirst($sNtabla)
?>
<table id='my-tbl'>
<tr>
	
   <?php 
   /**
    * campos a mostrarse en la tabla
    */
   $gridS=array('C&oacute;digo'=>'idGenUnidadesGeoreferencial', 'Actividad GA'=>'descTipoActividad','Sector Semplades'=>'descUnidad');
   foreach ($gridS as $campos=>$valor){
	?>
		<th class="data-th"><?php echo $campos ?></th>
    <?php 
	}
	?>
	<th class="data-th">Editar</th>
	<th class="data-th">Eliminar</th>
</tr>
<?php	
	//loop por cada registro tomando los campos delarreglo $gridS
	while ($row = $rs->fetch(PDO::FETCH_ASSOC)){
		echo "<tr class='data-tr' align='center'>";
   	foreach ($gridS as $campos=>$valor) { 
			echo '<td>'.$row[$valor].'</th>';
   	} 
    if(isset($_SESSION['privilegios']) and substr($_SESSION['privilegios'],1,1)==1) {
			echo '<td><a href="javascript:void(0);" onclick="getregistro('.$row[$idcampo].')">Editar</a></td>';}
		else
			{echo '<td>&nbsp;</td>';}
    if(isset($_SESSION['privilegios']) and substr($_SESSION['privilegios'],2,1)==1) {
			echo '<td><a href="javascript:void(0);" onclick="return delregistro('.$row[$idcampo].')">Eliminar</a></td>';}
		else
			{echo '<td>&nbsp;</td>';}
		echo "</tr>";
	}       
?>	
</table>
<br />