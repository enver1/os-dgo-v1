<?php
/**
 * cuando se llama al archivo por primera ve
 */
if(!isset($_REQUEST['comboAjax'])){
	include_once('../../funciones/cabecera_modulo.php');
}else{
	include '../../../funciones/db_connect.inc.php';
}

/**
 * libreria necesaria para ejecutar sentencias
 */
include_once('../../../funciones/funcion_select.php');

/**
 * obtener la columna que debe mostrarse en el combo
 */
$columna = isset($_REQUEST['mostrar'])?$_REQUEST['mostrar']:'placa';

/**
 * para obtener los vehiculos que tienen el estado activo
 */
$estado = 1;//activo de la tabla genestado

/**
 * sentencia que se ejecutará en el combo
 */
$sql1 = "SELECT 
  vehiculo.idHdrVehiculo,
  genVehiculo.$columna 
FROM
  hdrVehiculo vehiculo,
  dgpUnidad unidad,
  genUnidadActividadGA unacGA,
  genActividadGA acGA,
  genUsuarioActividadGA usuacGA,
  genVehiculo
WHERE unidad.idDgpUnidad = vehiculo.idDgpUnidad 
  AND genVehiculo.idGenVehiculo = vehiculo.idGenVehiculo
  AND unidad.idDgpUnidad = unacGA.idDgpUnidad 
  AND unacGA.idGenActividadGA = acGA.idGenActividadGA 
  AND acGA.idGenActividadGA = usuacGA.idGenActividadGA 
  AND usuacGA.idGenUsuario = {$_SESSION['usuarioAuditar']} 
  AND vehiculo.idGenEstado = $estado
  AND LENGTH(genVehiculo.$columna) > 0 
  AND vehiculo.idHdrVehiculo NOT IN 
  (SELECT 
    hr.idHdrVehiculo 
  FROM
    hdrRecurso hr 
  WHERE SHA1(hr.idHdrRuta) = '{$_GET['recno']}' 
    AND NOT hr.idHdrVehiculo = '')";
echo $sql1;
if (isset($_GET['id'])){
	$sql="select * from hdrRecurso where sha1(idHdrRecurso)='".$_GET['id']."'";
	$rs=$conn->query($sql);
	$rowt = $rs->fetch(PDO::FETCH_ASSOC);
}

if(isset($_REQUEST['comboAjax'])){
	echo generaComboSimpleSQL($conn,'hdrVehiculo','idHdrVehiculo',$columna, 0 ,$sql1,'idHdrVehiculo');
	exit();
}

$idcampo="HdrRecurso";
?>
<script>

	function obtenerCombo(idRecno, columna){
		$.ajax({
			url: "<?php echo $_SERVER['PHP_SELF'];?>",
			data: {recno : idRecno, comboAjax: 'ok', mostrar: columna},
			success: function(result){
				document.getElementById('idComboVehiculo').innerHTML = result;
			}
		});
	}
	/**
	 * validar campos obligatorios
	 * @param thisform formulario a validar
	 */
	function validar(thisform){
		var nominativo = thisform.nominativo.value;
		var vehiculo = thisform.idHdrVehiculo.value;
		var estado = thisform.idHdrEstadoRecurso.value;
		var radiorecurso = thisform.radioRecurso.value;
		
		if(nominativo.length < 1){
			alert('Debe ingresar un nominativo');
			thisform.nominativo.focus();
		}else{
			if(vehiculo < 1){
				alert('Debe seleccionar un vehÃ­culo');
				thisform.idHdrVehiculo.focus();
			}else{
				if(radiorecurso == 'N'){
					/**
					 * Telefono recurso
					 */
					var telefRec = thisform.telefonoRecurso.value;
					if(telefRec.length < 7){
						alert('Ingrese un nÃºmero de telefono');
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
	}
</script>
<div id="contenido">
<form method="post" action="../hdr/grabar/grabarecurso.php" method="post" >
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
       <td>VehÃ­culo:</td>
		<td>
			<table>
				<tr>
					<td>
						<input type="radio" name="mostrar" checked="checked" value="placa" onclick="if(this.checked)obtenerCombo('<?php echo $_GET['recno']; ?>', this.value)">&nbsp;Placa</td>
					<td>
						<input type="radio" name="mostrar" value="chasis" onclick="if(this.checked)obtenerCombo('<?php echo $_GET['recno']; ?>', this.value)">&nbsp;Chasis</td>
					<td>
						<input type="radio" name="mostrar" value="motor" onclick="if(this.checked)obtenerCombo('<?php echo $_GET['recno']; ?>', this.value)">&nbsp;Motor</td>
				</tr>
				<tr>
					<td colspan="3">
						<div id="idComboVehiculo">
							<?php
							if(isset($rowt['idHdrVehiculo'])){
								$rs=$conn->query($sql1);
								
								$sqlRecurso = "SELECT d.placa placa, d.chasis, d.motor FROM hdrVehiculo c,genVehiculo d WHERE c.idGenVehiculo = d.idGenVehiculo AND c.idHdrVehiculo = ".$rowt['idHdrVehiculo'];
								$rU = $conn->query($sqlRecurso);
								$rowRecurso = $rU->fetch(PDO::FETCH_ASSOC);
								
								?>
								<select class="inputSombra" style="width:300px" name="idHdrVehiculo" id="idHdrVehiculo">
									<option value="">Seleccione opción</option>
									<option value="<?php echo $rowt['idHdrVehiculo']?>" selected="selected"><?php 
									
										if(strlen($rowRecurso['placa']) > 0){
											echo $rowRecurso['placa'];
										}else{
											if(strlen($rowRecurso['chasis'])>0){
												echo $rowRecurso['chasis'];
											}else{
												echo $rowRecurso['motor'];
											}
										}
										?></option>
										<?php 
										while($row = $rs->fetch(PDO::FETCH_ASSOC)){
										?>
										<option value="<?php echo $row['idHdrVehiculo']?>"><?php echo $row[$columna]?></option>
										<?php
										}
										?>
								</select>
								<?php
							}else{
								echo generaComboSimpleSQL($conn,'hdrVehiculo','idHdrVehiculo',$columna,$rowt['idHdrVehiculo'],$sql1);
							}
							?>
						</div>
					</td>
				</tr>
			</table>
		</td>
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
            	<option value="S" <?php echo $rowt['radioRecurso']=='S'?'selected':''?>>SI</option>
                <option value="N" <?php echo $rowt['radioRecurso']=='N'?'selected':''?>>NO</option>
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