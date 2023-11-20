<?php
include_once('../../funciones/cabecera_modulo.php');
include_once('../../../funciones/funcion_select.php');
//print_r($_GET['id']);
if (isset($_GET['id']))
	{
		$sql="select * from hdrRecurso where sha1(idHdrRecurso)='".$_GET['id']."'";
	
	//print_r($sql1);
	$rs=$conn->query($sql);
	$rowt = $rs->fetch(PDO::FETCH_ASSOC);
	
	}
	//print_r($sql1);
$idcampo="HdrRecurso";
?>
<script>
	/**
	 * validar campos obligatorios
	 * @param thisform formulario a validar
	 */
	function validar(thisform){
		var nominativo = thisform.nominativo.value;
		var estado = thisform.idHdrEstadoRecurso.value;
		var radiorecurso = thisform.radioRecurso.value;
		
		if(nominativo.length < 1){
			alert('Debe ingresar un nominativo');
			thisform.nominativo.focus();
		}else{
			if(radiorecurso == 'N'){
				/**
				 * Telefono recurso
				 */
				var telefRec = thisform.telefonoRecurso.value;
				if(telefRec.length < 7){
					alert('Ingrese un número de telefono');
					thisform.telefonoRecurso.focus();
				}else{
					if(estado < 1){
						alert('Debe seleccionar un estado');
						thisform.idHdrEstadoRecurso.focus();
					}else{
						thisform.submit();
					}
				}
			}else{
				if(estado < 1){
					alert('Debe seleccionar un estado');
					thisform.idHdrEstadoRecurso.focus();
				}else{
					thisform.submit();
				}
			}
		}
	}
</script>
<div id="contenido">
<form method="post" action="../hdr/grabar/grabarecursopie.php" method="post" >
<table width="100" border="0">
  	<tr>
    	<td>C&oacute;digo:</td>
         
		<td>
        <input type="hidden" name="idHdrRuta" id="idHdrRuta" value="<?php echo isset($_GET['recno'])?$_GET['recno']:'0' ?>" size="10" readonly="readonly" />
        <input type="hidden" name="pesta" id="pesta" value="<?php echo isset($_GET['pesta'])?$_GET['pesta']:0 ?>" size="10" readonly="readonly" />
        <input type="hidden" name="opc"  value="<?php echo isset($_GET['opc'])?$_GET['opc']:0 ?>" size="10" readonly="readonly" />
        <input type="hidden" name="ruta" value="<?php echo isset($rowt['idHdrRuta'])?$rowt['idHdrRuta']:0 ?>" size="10" readonly="readonly" />
        <input type="text" name="id<?php echo $idcampo ?>"  readonly="readonly" value="<?php echo isset($rowt['idHdrRecurso'])?$rowt['idHdrRecurso']:'' ?>" class="inputSombra" style="width:80px"/></td>
    </tr>
    <tr>
       <td>Nominativo:</td>
		<td>
        <input type="text" name="nominativo"  size="60" value="<?php echo isset($rowt['nominativo'])?$rowt['nominativo']:'' ?>" class="inputSombra" /></td>
    </tr>
    <tr>
    	<td>Telefono Recurso</td>
        <td>
        	<input type="text" name="telefonoRecurso"  style="width:290px" value="<?php echo isset($rowt['telefonoRecurso'])?$rowt['telefonoRecurso']:'' ?>" class="inputSombra" />
        </td>
    </tr>
    <tr>
    	<td>Radio Recurso</td>
        <td>
        	<select name="radioRecurso" id="radioRecurso" class="inputSombra" style="width:300px">
            	<option value="S">SI</option>
                <option value="N">NO</option>
            </select>
        </td>
    </tr>
    <tr>
      <td>Estado:</td>
		<td> <?php echo generaComboSimple($conn,'hdrEstadoRecurso','idHdrEstadoRecurso','descripcion',isset($rowt['idHdrEstadoRecurso'])?$rowt['idHdrEstadoRecurso']:'idHdrEstadoRecurso'); ?>
		</td>
    </tr>
    <tr>
      <td>Observaci&oacute;n:</td>
		<td> <input type="text" name="observacion"  size="60" value="<?php echo isset($rowt['obsHdrRecurso']) ? $rowt['obsHdrRecurso'] : '' ?>" class="inputSombra" />
		</td>
    </tr>
    <tr>  
         <td width="110" align="center" colspan="2">
            <button type="button" class="boton_save" onclick="validar(this.form)">Enviar</button>
           </td>
       	<td>&nbsp;</td>
    </tr>
</table>
</form>
</div>
<?php
include_once('../../funciones/pie_modulo.php');
?>