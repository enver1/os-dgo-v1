<?php 
include_once('../../funciones/cabecera_modulo.php');
?>
<script type="text/javascript" src="../../../js/jquery.easyui.min.js"></script>

<?php
include_once('../../../funciones/funcion_select.php');
$directorio='modulos/hdr';
//print_r($_GET['id']);
if (isset($_GET['id'])){
	
		$sql="select * from hdrRecurso where sha1(idHdrRecurso)='".$_GET['id']."'";
		//$sql1="Select * from hdrVehiculo vehiculo, dgpUnidad unidad where vehiculo.idDgpUnidad=unidad.idDgpUnidad and unidad.idDgpUnidad=(Select ruta.idDgpUnidad from hdrRuta ruta where sha1(ruta.idHdrRuta)='".$_GET['recno']."')";
		$rs=$conn->query($sql);
		$rowt = $rs->fetch(PDO::FETCH_ASSOC);
}

$idcampo="HdrRecurso";
?>

<script>
$(document).ready(function(){
	$('#tpais').tree({
		onClick: function(node){
			var node = $('#tpais').tree('getSelected');
			$('#codSenplades').attr('value',node.id);
			$('#lugar').attr('value',node.text);
			$("html, body").animate({ scrollTop: 0 }, "slow");
		}
	});
 });
 
function grabar(thisForm)
{
	 var seleccionados = getChecked();
	 var url="grabaSector.php?sectores="+seleccionados;
	 document.getElementById('seleccionados').value=seleccionados;

	 if(seleccionados.length > 1){
	 	thisForm.submit();
	 }
	 else{
		 alert('Debe seleccionar un sector');
	 }
}
function getChecked(){
	var nodes = $('#tpais').tree('getChecked');
	var s = '';
	for(var i=0; i<nodes.length; i++){
	if (s != '') s += ',';
	s += nodes[i].id;
	}
	return (s);
}

 </script>


<form method="post" action="../hdr/grabar/grabaSector.php" name="edita" id="edita">
<table width="100%" border="0">
<tr>
	<td>
		<?php echo $rowt['nominativo']; ?>
	</td>
</tr>
 <tr>
 	
            <td width="45%" valign="top">
            <input type="hidden" name="seleccionados" id="seleccionados" value=""/>
            <div style=" overflow: scroll; height:250px">
                    <ul id="tpais" class="easyui-tree" animate="true" style="font-size:10px" checkbox="true" 
                        url="treesectorpatrulla.php?idRecurso=<?php echo $_GET['id'];?>">
                    </ul>
            </div>
            </td>
        </tr>
</table>
<table width="100%" border="0">

    <tr>
        <td>
        	<input type="hidden" name="id" id="id" value="<?php echo $_GET['id'];?>" />
        	<button type="button" onclick="grabar(this.form)" class="boton_save">Grabar</button>
        	
        	 <input type="hidden" name="recno" value="<?php echo isset($_GET['recno'])?$_GET['recno']:0 ?>" size="10" readonly="readonly" />
        	 <input type="hidden" name="pesta" value="<?php echo isset($_GET['pesta'])?$_GET['pesta']:0 ?>" size="10" readonly="readonly" />
        	 <input type="hidden" name="opc" value="<?php echo isset($_GET['opc'])?$_GET['opc']:0 ?>" size="10" readonly="readonly" />
        </td>
    </tr>
   
</table>

</form>

<?php
include_once('../../funciones/pie_modulo.php');

/**
 * cuando se guardan datos o se modifican o eliminan, se debe actualizar la tabla que muestra en el contenedor padre
 */
if(isset($_GET['Guardar'])){
	?>
	<script type="text/javascript">
		var stringUrl = ''; 
		if(parent.parent.document.getElementById('nominativos')){
			stringUrl = 'recursos.php';
		}else{
			stringUrl = 'recursospie.php';
		}
		/**
		 * Obtener tabla y mostrar resultados
		 */
		$.ajax({
			type: "POST",
			url: stringUrl + "?id=<?php echo $_GET['id'];?>&recno=<?php echo $_GET['recno']; ?>&pesta=<?php echo $_GET['pesta'];?>&opc=<?php echo $_GET['opc'];?>&page=1",
			success: function(result){
				if(parent.parent.document.getElementById('nominativos')){
					parent.parent.document.getElementById('nominativos').innerHTML = result;
				}else{
					parent.parent.document.getElementById('recursospie').innerHTML = result;
				}
			}
		});
	</script>
	<?php
}
?>