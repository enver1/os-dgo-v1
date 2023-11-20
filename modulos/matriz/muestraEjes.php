<?php
include_once('../../../funciones/db_connect.inc.php');
$sql="select ep.idDgoEjeProcSu,ep.idDgoEje,ej.descDgoEje from dgoActUnidad a
join dgoEjeProcSu ep on a.idDgoProcSuper=ep.idDgoProcSuper
join dgoEje ej on ep.idDgoEje=ej.idDgoEje
WHERE idDgoActUnidad='".$_GET['id']."'";
//echo $sql;
$rsS=$conn->query($sql);
echo '<span class="texto_azul">EJES:</span><br><table width="100%"><tr>';
while($rowS=$rsS->fetch())
{ ?>
	<td align="center" id="td<?php echo $rowS['idDgoEje'] ?>" style="padding:5px 0">
	<input type="button" value="<?php echo $rowS['descDgoEje'] ?>" onClick="genMatriz(<?php echo $rowS['idDgoEjeProcSu'] ?>,<?php echo $rowS['idDgoEje'] ?>)" 
	style="width:120px;height:40px;font-size:10px; cursor:pointer; white-space:normal"></td>
<?php
}
echo '</tr></table>';
?>