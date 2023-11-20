<?php
/**
 * ejecucion codigo ajax
 */
if(isset($_GET['integrante'])){
	include '../../../funciones/db_connect.inc.php';
	
	/**
	 * consulta de datos para mostrar
	 */
	$sql2 = "SELECT idHdrIntegrante, a.idGenPersona, siglas, apenom,documento,idHdrFuncion,idGenEstado,observacionIntegrante FROM v_persona a,hdrIntegrante b WHERE a.idGenPersona=b.idGenPersona AND idHdrIntegrante=".$_GET['idIntegrante'];
	
	/**
	 * obtener datos
	 */
	$persona = $conn->prepare($sql2);
    $persona->execute();
    $rowT = $persona->fetch();
    
    /**
	 * sql que se ejecuta con ajax
     */
    $sqlFuncion = "SELECT fa.idHdrFuncion, fa.descripcion
		FROM hdrFuncion fa where fa.idHdrFuncion not in (SELECT i.idHdrFuncion FROM hdrIntegrante i WHERE sha1(i.idHdrRecurso) = '" . $_GET['id'] . "')";
    
    
    /**
     * cuando es edici髇 se debe mostrar en el combo los que faltan mas la propia funci髇 seleccionada, ya que puede modificar el estado
     * o la observaci髇
     */
    if($_GET['pesta'] != 3){
    	/**
    	 * Cuando no es recursos a pie debe aparecer todas las funciones, pero solo una vez debe dejar seleccionar
    	 * jefe patrulla, conductor y guardia
    	 */
    	$sqlFuncion .=" or (fa.idHdrFuncion != 1 and fa.idHdrFuncion != 2 and fa.idHdrFuncion != 4) or fa.idHdrFuncion =".$rowT['idHdrFuncion'];
    }else{
    	/**
    	 * cuando es recurso a pie solo debe dejar seleccionar jefe de patruya y auxiliar,
    	 * pero solo una vez guardia
    	 */
    	$sqlFuncion .=" AND fa.idHdrFuncion = 1 OR fa.idHdrFuncion = 3 OR fa.idHdrFuncion > 4 or fa.idHdrFuncion =".$rowT['idHdrFuncion'];
    }
    
    /**
	 * obtiene el listado de datos que deben mostrarse en el combo
	 * de funciones para la modificaci髇 de datos
     */
    $combo = $conn->query($sqlFuncion);
    $array = array();
	while ($rowRE = $combo->fetch(PDO::FETCH_ASSOC)) {
		$array[] = $rowRE;
    }
    
    $sqlActividades = "SELECT
    idHdrIntegAct AS 'codigo',
    obsActividad AS 'actividad',
    TIME(horaIni) AS 'inicio',
    TIME(horaFin) AS 'fin'
    FROM
    hdrIntegAct
    WHERE idHdrIntegrante = {$_GET['idIntegrante']}
    ORDER BY horaIni ASC";
    $rs = $conn->query($sqlActividades);
    $arrayActividad = array();
    while($row = $rs->fetch(PDO::FETCH_ASSOC)){
    	$arrayActividad[] = $row;
    }
    
	echo json_encode(array('datos'=>$rowT, 'combo'=>$array, 'actividad'=>$arrayActividad),true);
	exit();
}

if(isset($_POST['bscPersona'])){
	include '../../../funciones/db_connect.inc.php';
	/**
	 * consulta de datos para mostrar
	 */
	$sql2 = "select * from v_persona where apenom Like '%{$_POST['cedula']}%'";
	
	/**
	 * obtener datos
	 */
	$rs = $conn->query($sql2);
	?>
	<fieldset>
    	<legend>Resultado de la B&uacute;squeda</legend>
	<table width="100%">
		<tr>
			<th class="data-th">Cedula</th>
			<th class="data-th">1er Apellido</th>
			<th class="data-th">2do Apellido</th>
			<th class="data-th">1er Nombre</th>
			<th class="data-th">2do Nombre</th>
			<th class="data-th">Sexo</th>
		</tr>
	<?php
	while($rowT = $rs->fetch(PDO::FETCH_ASSOC)){
		?>
		<tr class='data-tr' align='center'>
			<td><a href="javascript:void(0)" onclick="document.forms[0].cedula.value = '<?php echo trim($rowT['documento'])?>';$('#Buscar').click()"><?php echo $rowT['documento']?></a></td>
			<td><?php echo $rowT['apellido1']?></td>
			<td><?php echo $rowT['apellido2']?></td>
			<td><?php echo $rowT['nombre1']?></td>
			<td><?php echo $rowT['nombre2']?></td>
			<td><?php echo $rowT['sexo']?></td>
		</tr>
		<?php
	}
	?>
	</table>
	</fieldset>
	<?php
	exit();
}

include_once('../../funciones/cabecera_modulo.php');
include_once('../../../funciones/funcion_select.php');
include_once('../../js/ajaxHDR.php');

if (isset($_GET['id'])) {
    $sql = "select * from hdrIntegrante where sha1(idHdrRecurso)='" . $_GET['id'] . "'";
    
    $rs = $conn->query($sql);
    $rowt = $rs->fetch(PDO::FETCH_ASSOC);
    
}

$sqlFuncion = "SELECT fa.idHdrFuncion, fa.descripcion
		FROM hdrFuncion fa where fa.idHdrFuncion not in (SELECT i.idHdrFuncion FROM hdrIntegrante i WHERE sha1(i.idHdrRecurso) = '" . $_GET['id'] . "')";

if($_GET['pesta'] != 3){
	/**
	 * Cuando no es recursos a pie debe aparecer todas las funciones, pero solo una vez debe dejar seleccionar
	 * jefe patrulla, conductor y guardia
	 */
	$sqlFuncion .= " or (fa.idHdrFuncion != 1 and fa.idHdrFuncion != 2 and fa.idHdrFuncion != 4);";
}else{
	/**
	 * cuando es recurso a pie solo debe dejar seleccionar jefe de patruya y auxiliar,
	 * pero solo una vez guardia
	 */
	$sqlFuncion .= " AND fa.idHdrFuncion = 1 OR fa.idHdrFuncion = 3 OR fa.idHdrFuncion > 4;";
}

$cedulaIngresada = isset($_POST['cedula']) ? trim($_POST['cedula']) : ''; //n煤mero de c茅dula del ingresada*****************		
$idGenPersona = '';
$siglas = '';
$apenom = '';
if (isset($_POST['consultar']) or isset($_GET['c'])) {
	    $sql2 = sprintf("SELECT
						idGenPersona,
						siglas,
						apenom,
						documento
					FROM
						v_persona
					WHERE
						documento = '$cedulaIngresada'");
	    
	//echo $sql;
    $persona = $conn->prepare($sql2);
    $persona->execute();
    $rowT = $persona->fetch();
    //print_r($rowT['documento']);// fin consulta para verificar que el inscrito esta o no en la db siipne
    $idGenPersona = $rowT['idGenPersona'];
    $siglas = $rowT['siglas'];
    $apenom = $rowT['apenom'];
    
    if(strlen($siglas) < 1){
    	$miembro = false;
    	$apenom = '';
    	$idGenPersona = '';
    	unset($rowT);
    }else{
    	$persona = $conn->prepare("SELECT 
								  hdrIntegrante.idGenPersona 
								FROM
								  hdrRecurso 
								  INNER JOIN hdrIntegrante 
								    ON hdrRecurso.idHdrRecurso = hdrIntegrante.idHdrRecurso 
								WHERE SHA1(hdrRecurso.idHdrRuta) = '{$_GET['recno']}' 
								  AND NOT ISNULL(hdrIntegrante.idGenPersona) 
								  AND hdrIntegrante.idGenPersona = {$rowT['idGenPersona']}");
    		 
    	$persona->execute();
    	$aux = $persona->fetch();
    	
    	if(isset($aux['idGenPersona'])){
    		$siglas = '';
    		$apenom = '';
    		$idGenPersona = '';
    		unset($rowT);
    	}else{
    		unset($aux);
    	}
    }
}

//echo $sql;
$idcampo = "HdrRecurso";
?>
<script>
	function eliminarActividades(form){
		if(confirm('驴Desea Eliminar el Registro?')){
			$.ajax({
				type: "POST",
				url: "../hdr/borrar/borrarActividadIntegrante.php",
				data: $(form).serialize(),
				success: function(result){
					try{
						$('#formActividadesId').find('#actividadesId').find('option').remove();
						var obj = jQuery.parseJSON(result);
						for(var i= 0; i < obj.length;i++){
							  var o = obj[i];
							  $('#formActividadesId').find('#actividadesId').append("<option value='"+o.codigo+"'>"+o.inicio + " - " +o.fin + " [ " +o.actividad+" ]</option>");
						}
						limpiarActividad(form);
					}catch(e){
						alert(result);
					}
				}
			});
		}
	}
	/**
	 * limpiar los componentes de una actividad para registrar uno nuevo
	 */
	function limpiarActividad(form){
		form.idHdrIntegAct.value = '0';
		form.horaInicioActividad.value = '';
		form.horaFinActividad.value = '';
		form.txtactividad.value = '';
	}
	/**
	 * agregar datos para edici髇
	 */
	function selectActividad(componente){
		var form = componente.form;
		form.idHdrIntegAct.value = componente.value;
		var string = componente.options[componente.selectedIndex].text;
		form.horaInicioActividad.value = string.substring(0,string.indexOf('-')).trim();
		form.horaFinActividad.value = string.substring(string.indexOf('-') + 1,string.indexOf('[')).trim();
		form.txtactividad.value = string.substring(string.indexOf('[') + 1,string.indexOf(']')).trim();
	}
	/**
	 * inserta o actualiza alguna actividad
	 */
	function GrabarActividad(form){
		$.ajax({
			type: "POST",
			url: "../hdr/grabar/grabarActividadIntegrante.php",
			data: $(form).serialize(),
			success: function(result){
				try{
					$('#formActividadesId').find('#actividadesId').find('option').remove();
					var obj = jQuery.parseJSON(result);
					for(var i= 0; i < obj.length;i++){
						  var o = obj[i];
						  $('#formActividadesId').find('#actividadesId').append("<option value='"+o.codigo+"'>"+o.inicio + " - " +o.fin + " [ " +o.actividad+" ]</option>");
					}
				}catch(e){
					alert(result);
				}
			}
		});
	}

	function buscarPorNombre(form){
		$.ajax({
			type: "POST",
			url: "<?php echo $_SERVER['PHP_SELF']?>",
			data: {bscPersona:'1', cedula:$(form.cedula).val()},
			success: function(result){
				try{
					$('#busquedapornombre').html(result);
				}catch(e){
					alert(result);
				}
			}
		});
	}
	/**
	 * mostrar datos
	 @param id id de integrante asignado
	 */
	function Mostrar(idInt, idPesta, idRecno){
		$.ajax({
			url: "<?php echo $_SERVER['PHP_SELF'];?>",
			data: {integrante:'1', idIntegrante: idInt, pesta : idPesta, id : idRecno},
			success: function(result){
				try{
					var obj = jQuery.parseJSON(result);

					 var form = document.getElementById('formularioIntegrantes');
					  
					  $('#formularioIntegrantes').find('#idHdrFuncion').find('option').remove();

					  for(var i= 0; i < obj['combo'].length;i++){
						  var o = obj['combo'][i];
						  
						  $('#formularioIntegrantes').find('#idHdrFuncion').append("<option value='"+o.idHdrFuncion+"'>"+o.descripcion+"</option>");
					  }

					  for(var i= 0; i < obj['actividad'].length;i++){
						  var o = obj['actividad'][i];
						  $('#formActividadesId').find('#actividadesId').append("<option value='"+o.codigo+"'>"+o.inicio + " - " +o.fin + " [ " +o.actividad+" ]</option>");
					  }

					  form.idHdrFuncion.value = obj['datos']['idHdrFuncion'];
					  form.idGenEstado.value = obj['datos']['idGenEstado'];
					  form.observacion.value = obj['datos']['observacionIntegrante'];
					  form.integrante.value = obj['datos']['idHdrIntegrante'];
					  form.idGenPersonal.value = obj['datos']['idGenPersona'];
					  document.getElementById('idSiglasIF').innerHTML = obj['datos']['siglas'];
					  document.getElementById('idApenomIF').innerHTML = obj['datos']['apenom'];
					  document.getElementById('consIntegranteForm').cedula.value = $.trim(obj['datos']['documento']);
					  document.getElementById('idActividadesDesc').style.display = '';
					  document.getElementById('formActividadesId').integrante.value = obj['datos']['idHdrIntegrante'];
				}catch(e){
					alert(result);
				}
			}
		});
	}
	/**
 	 * valida campos obligatorios antes del envio de datos
	 */
	function ValidarIntegrantesforma(thisForm){
		var genPersonal = thisForm.idGenPersonal.value;
		var	funcion = thisForm.idHdrFuncion.value;
		var estado = thisForm.idGenEstado.value;
		
		if(genPersonal <= 0){
			alert("Debe escojer un Personal Policial");
			document.getElementById('consIntegranteForm').cedula.focus();
		}else{
			if(funcion <= 0){
				alert("Debe seleccionar una Funci贸n");
				thisForm.idHdrFuncion.focus();
			}else{
				if(estado <= 0){
					alert("Debe seleccionar un Estado");
					thisForm.idGenEstado.focus();
				}else{
					thisForm.submit();
				}
			}
		}
	}
	/**
	 * validar que haya ingresado una cedula valida
	 */
	function validarConsulta(thisForm){
		var text = thisForm.cedula.value;
		if(text.length == 10){
			thisForm.submit();
		}else{
			alert('Debe ingresar una c茅dula v谩lida');
			thisForm.cedula.focus();
		}
	}
	/**
	 * Eliminar un registro
	 */
	function Eliminar(idIntegrante){
		if(confirm('驴Desea Eliminar el Registro?')){
			$.ajax({
			type: "POST",
			url: "../hdr/borrar/borraIntegrante.php",
			data: {id:idIntegrante},
			success: function(result){
				try{
					var obj = jQuery.parseJSON(result);
					
					if(obj.length > 0){
						alert(obj['1']);
						location.href = "/operaciones/modulos/hdr/integrantesforma.php?Guardar=si&id=<?php echo $_GET['id'];?>&recno=<?php echo $_GET['recno']; ?>&pesta=<?php echo $_GET['pesta'];?>&opc=<?php echo $_GET['opc'];?>";
					}else{
						//cuando devuelve error
						alert(result);
					}
				}catch(e){
					alert(result);
				}	
			}
		});
		}
	}
</script>
<div id="contenido">
    <form action="" method="post" enctype="multipart/form-data" name="consIntegranteForm" id="consIntegranteForm">
        <table width="100" border="0">
            <tr>
                <td>Integrante:</td>
                <td> 
                    <input type="text" name="cedula" id="cedula" class="inputSombra" value="<?php echo isset($rowT['documento'])?trim($rowT['documento']):''?>"/>
                    <input type="hidden" name="consultar" value="consultar"/>
                </td>
                <td>
                	<button type="button"  class="boton_general" onclick="validarConsulta(this.form)" id="Buscar"><span> C&eacute;dula</span></button>
                </td>
                <td>
                	<button type="button"  class="boton_general" onclick="buscarPorNombre(this.form)"><span> Nombre</span></button>
                </td>
            </tr>
        </table>
    </form>
    <div id="busquedapornombre"></div>
    	<table>
    		<tr>
    			<td valign="top">
    				<form method="post" action="../hdr/grabar/grabaintegrante.php" id="formularioIntegrantes" name="formularioIntegrantes" >
    				<table width="100" border="0">
			            <tr>
			                <td>
			                    <input type="hidden" name="idHdrRuta" id="idHdrRuta" value="<?php echo isset($_GET['recno']) ? $_GET['recno'] : 0 ?>" size="10" readonly="readonly" />
			
			                    <input type="hidden" name="opc"  value="<?php echo isset($_GET['opc']) ? $_GET['opc'] : 0 ?>" size="10" readonly="readonly" />
			                    <input type="hidden" name="recurso"  value="<?php echo isset($_GET['id']) ? $_GET['id'] : 0 ?>" size="10" readonly="readonly" />
			                    <input type="hidden" name="integrante" value="<?php echo isset($rowT['idHdrIntegrante']) ? $rowT['idHdrIntegrante'] : 0 ?>" size="10" readonly="readonly" />
			                    <input type="hidden" name="idGenPersonal" value="<?php echo isset($rowT['idGenPersona']) ? $rowT['idGenPersona'] : 0 ?>" size="10" readonly="readonly" />
			                    <input type="hidden" name="id<?php echo $idcampo ?>"  readonly="readonly" value="<?php echo isset($rowt['idHdrRecurso']) ? $rowt['idHdrRecurso'] : '' ?>" class="inputSombra" style="width:80px"/>
			                    
			                    <!-- datos-->
			                    <input type="hidden" name="id" value="<?php echo $_GET['id']?>"/>
			                    <input type="hidden" name="pesta" value="<?php echo $_GET['pesta'];?>"/>
			                    <input type="hidden" name="recno" value="<?php echo $_GET['recno'];?>"/>
			                    </td>
			            </tr>
			            <tr>
			                <td>Grado:</td>
			                <td id="idSiglasIF"><?php echo $siglas; ?></td>
			            </tr>
			            <tr>
			                <td>Nombres:</td>
			                <td id="idApenomIF"><?php echo $apenom; ?></td>
			            </tr>
			            <tr>
			                <td>Funci贸n:</td>
			                <td> <?php echo generaComboSimpleSQL($conn, 'hdrFuncion', 'idHdrFuncion', 'descripcion',( isset($rowT['idHdrFuncion']) ? $rowT['idHdrFuncion'] : 'idHdrFuncion'),$sqlFuncion,'idHdrFuncion'); ?>
			                </td>
			            </tr>
			            <tr>
			                <td>Estado:</td>
			                <td> <?php echo generaComboSimple($conn, 'genEstado', 'idGenEstado', 'descripcion', isset($rowT['idGenEstado']) ? $rowT['idGenEstado'] : ''); ?>
			                </td>
			            </tr>
			            <tr>
			                <td>Observaci贸n:</td>
			                <td> <input type="text" name="observacion"  size="60" value="<?php echo isset($rowT['observacionIntegrante']) ? $rowT['observacionIntegrante'] : '' ?>" class="inputSombra" />
			                </td>
			            </tr>
			            <tr>  
			                <td colspan="2" align="center">
			                <button type="button" class="boton_general" onclick="location.reload()" style="float: left;">Nuevo</button>
			                <button type="button" onclick="ValidarIntegrantesforma(this.form);" value="Enviar" class="boton_save" style="float: left;">Enviar</button>
			                <input type="hidden" name="Enviar" value="Enviar"/>
			                </td>
			                <td>&nbsp;</td>
			            </tr>
			        </table>
			        </form>
    			</td>
    			<td>
    				<form action="#" method="post" id="formActividadesId">
    				<table width="100%" border="0" id="idActividadesDesc" style="display: none">
    					<tr>
    						<td class="etiqueta">Hora Inicio:</td>
					    	<td>
					    		<input type="hidden" name="idHdrIntegAct" id="idHdrIntegAct" value="0" size="10" readonly="readonly" />
					    		<input type="hidden" name="integrante" value="0" size="10" readonly="readonly" />
					    		<input type="text"  id="horaInicioActividadId" name="horaInicioActividad" size="6"/>
					        </td>
					        
					    	<td class="etiqueta">Hora Fin:</td>
					    	<td>
					    		<input type="text" id="horaFinActividadId" name="horaFinActividad" size="6" />
					        </td>
    					</tr>
    					<tr>
    						<td class="etiqueta">Observaci&oacute;n actividad:</td>
    						<td colspan="3">
    							<textarea rows="2" cols="40" name="txtactividad" id="txtactividadId"></textarea>
    						</td>
    					</tr>
    					<tr>
    						<td colspan="4" align="right">
    							<button type="button" class="boton_save" onclick="GrabarActividad(this.form)" style="float: right;">Guardar</button>
    							<button type="button" class="boton_general" onclick="limpiarActividad(this.form)" style="float: right;">Nuevo</button>
    						</td>
    					</tr>
    					<tr>
    					    <td class="etiqueta">Actividades:</td>
    						<td colspan="3">
    							<select multiple="multiple" style="width: 300px; height: 100px" name="actividades[]" id="actividadesId" onchange='selectActividad(this)'></select>
    						</td>
    					</tr>
    					<tr>
    						<td colspan="4" align="right">
    							<button type="button" class="boton_general" onclick="eliminarActividades(this.form)">Eliminar</button>
    						</td>
    					</tr>
    				</table>
    				</form>
    			</td>
    		</tr>
    	</table>
</div>
<?php
/* ----------------------------------------- */
$sNtabla = 'hdrIntegrante'; // *** CAMBIAR ** Nombre de la tabla;
/* ------------------------------------------ */
// Personalizar de acuerdo al numero de columnas que se muestran en el grid, tanto en los titulos como en
// las filas 
/* ----------------------------------------- */

$idcampo = ucfirst($sNtabla); // Nombre del Id de la Tabla primera mayuscula
$sqlgrid = "Select i.idHdrIntegrante integrante, p.siglas grado, p.apenom nombres, f.descripcion funcion from v_persona p, hdrIntegrante i, hdrFuncion f where i.idHdrFuncion=f.idHdrFuncion and i.idGenPersona=p.idGenPersona and sha1(i.idHdrRecurso)='" . $_GET['id'] . "'";
$rs1 = $conn->query($sqlgrid);
//print_r($_GET['recno']);
//print_r($sql);
//$rowREt = $rs->fetch(PDO::FETCH_ASSOC);
?>
<table id='my-tbl'>
    <tr>
        <th class="data-th">Codigo</th>
        <th class="data-th">Grado</th>
        <th class="data-th">Nombres</th>
        <th class="data-th">Funci贸n</th>
        <th class="data-th">Editar</th>
        <th class="data-th">Eliminar</th>
    </tr>

<?php
//loop por cada registro
while ($rowRE = $rs1->fetch(PDO::FETCH_ASSOC)) {
    echo "<tr class='data-tr' align='center'>";
    echo "<td>{$rowRE['integrante']}</td>";
    echo "<td>{$rowRE['grado']}</td>";
    echo "<td>{$rowRE['nombres']}</td>";
    echo "<td>{$rowRE['funcion']}</td>";
    echo '<td><a href="javascript:void(0);" onclick="Mostrar('.$rowRE['integrante'].','.$_GET['pesta'].',\''.$_GET['id'].'\')">Elegir</a></td>';//' . $rowRE['integrante'] . '
    echo '<td><a href="javascript:void(0);" onclick="Eliminar('.$rowRE['integrante'].')">Eliminar</a></td>';
    echo "</tr>";
}
?>	
</table>
<?php

if(isset($aux) && count($aux) > 0){
	echo "<script>alert('El miembro policial se encuentra ya asignado a un recurso');</script>";
}

if(isset($miembro)){
	echo "<script>alert('El documento ingresado no pertenece a un miembro policial');</script>";
}

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