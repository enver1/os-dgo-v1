<?php 	
if (!isset($_SESSION)){ session_start();}
//header('Content-Type: text/html; charset=UTF-8');
?>
<table id='my-tbl'>
<tr>
	<th class="data-th" colspan="8" align="right">
  	<span style="color:#fff">Buscar... </span>
    <input type="text" name="criterio" id="criterio" />
    <a href="javascript:void(0)" onclick="buscagrid()"><img src="../imagenes/ver.png" alt="0" border="0" /></a>
  </th>
</tr>
<tr>
	<th class="data-th">Codigo</th>
	<th class="data-th">Descripcion</th>
	<th class="data-th">Padre</th>
	<th class="data-th">Tipo Division</th>
	<th class="data-th">Siglas</th>    
   	<th class="data-th">Código</th>
	<th class="data-th">Editar</th>
	<th class="data-th">Eliminar</th>
</tr>
<?php	
	//loop por cada registro
	$sNtabla='genGeoSenplades';
	$idcampo=ucfirst($sNtabla);
	while ($row = $rs->fetch(PDO::FETCH_ASSOC)){
		echo "<tr class='data-tr' align='center'>";
		echo "<td>".$row['id'.ucfirst($idcampo)]."</td>";
		echo "<td>{$row['descripcion']}</td>";
		echo "<td>{$row['gen_idGenGeoSenplades']}</td>";
		echo "<td>{$row['idGenTipoGeoSenplades']}</td>";
		echo "<td>{$row['siglasGeoSenplades']}</td>";
		echo "<td>{$row['codigoSenplades']}</td>";
    if(isset($_SESSION['privilegios']) and substr($_SESSION['privilegios'],1,1)==1) {
			echo '<td><a href="javascript:void(0);" onclick="getregistro('.$row['id'.$idcampo].')">Editar</a></td>';}
		else
			{echo '<td>&nbsp;</td>';}
    if(isset($_SESSION['privilegios']) and substr($_SESSION['privilegios'],2,1)==1) {
			echo '<td><a href="javascript:void(0);" onclick="return delregistro('.$row['id'.ucfirst($idcampo)].')">Eliminar</a></td>';}
		else
			{echo '<td>&nbsp;</td>';}
		echo "</tr>";
	}       
?>	
</table>
<br />
