<?php
if (!isset($_SESSION)){ session_start();}

/*-------------------------------------------------*/
$tgraba='hdr/grabar/grabacabecera.php'; // *** CAMBIAR *** nombre del php para insertar o actualizar un registro
$Ntabla='hdrRuta'; // *** CAMBIAR *** Nombre de la Tabla
$directorio='modulos/hdrdetalle'; // *** CAMBIAR ***

/*-------------------------------------------------*/
$idcampo=ucfirst($Ntabla); // Nombre del Id de la Tabla

/**
 * Aqui se incluye el formulario de edicion
 */
if(isset($_GET['recno'])){
	$sql="SELECT a.*, v_persona.documento, v_persona.siglas, v_persona.apenom FROM hdrRuta a INNER JOIN v_persona ON a.idGenPersona = v_persona.idGenPersona where sha1(idHdrRuta)='".$_GET['recno']."'";
	$rs=$conn->query($sql);
	$rowt=$rs->fetch();
}

if(isset($_POST['cti'])){
	include '../../../funciones/db_connect.inc.php';
	$sql="SELECT * FROM v_persona where documento = '{$_POST['documento']}'";
	$rs=$conn->query($sql);
	$rowt=$rs->fetch();
	echo '<label name="Unidad" id="Unidad" style="border:none; background-color:#fff; color:#006; font-size:11px;font-weight:bold;height:auto">'.$rowt['siglas'].'. '.$rowt['apenom'].'</label><br>';
	exit();
}
?>
<script>
/**
 * fechas
 */
function fecha_es()
{
	document.getElementById('fechaFin').value=document.getElementById('fechaInicio').value;
}

/**
 * eliminar registro
 */
function delregistro(opc, pesta, recno){
	$.ajax({
		type: "GET",
		url: "modulos/hdr/borrar/borrarHojadeRuta.php?recno=" + recno,
		success: function(result){
			alert(result);
			getdata(1);
		}
	});
}

/**
 * obtener los datos de la grilla
 */
function getdata(pageno){

	var targetURL = '';

	if($('#hdrdetalleID').length > 0){

		targetURL = 'modulos/hdr/hdrdetalle.php?page=' + pageno + '&unidad=<?php echo $rowUnidad['idGenActividadGA']; ?>&opc=<?php echo $_GET['opc']; ?>&recno=<?php echo isset($_GET['recno'])? $_GET['recno']:0 ?>';
	}   

	if($('#nominativos').length > 0){
		targetURL = 'modulos/hdr/recursos.php?page=' + pageno + '&opc=<?php echo $_GET['opc']; ?>&recno=<?php echo isset($_GET['recno'])? $_GET['recno']:0 ?>&pesta=<?php echo isset($_GET['pesta'])? $_GET['pesta']:0 ?>';
	}

	if($('#recursospie').length > 0){
		targetURL = 'modulos/hdr/recursospie.php?page=' + pageno + '&opc=<?php echo $_GET['opc']; ?>&recno=<?php echo isset($_GET['recno'])? $_GET['recno']:0 ?>&pesta=<?php echo isset($_GET['pesta'])? $_GET['pesta']:0 ?>';
	}
	
	$('#retrieved-data').html('<p><img src="../funciones/paginacion/images/ajax-loader.gif" /></p>');        
	if(targetURL != ''){
		$('#retrieved-data').load( targetURL ).hide().fadeIn('slow');
	}
}

/**
 * Elimina un recurso que haya sido registrado
 * la eliminación va en cadena.
 */
function delRecurso(idRecursos){
	if(confirm('Desea Eliminar el Registro?')){
	 	$.ajax({
		type: "POST",
		url: "modulos/hdr/borrar/borraRecurso.php",
		data: {id:idRecursos},
		success: function(result){
			alert(result);
			window.location="index.php?opc=<?php echo $_GET['opc']?>&recno=<?php echo isset($_GET['recno'])? $_GET['recno']:0 ?>&pesta=<?php echo isset($_GET['pesta'])? $_GET['pesta']:0 ?>";
		}
	});
	}
}

function buscarDatos(cedula){
	if(cedula.length == 10){
		$.ajax({
			type: "POST",
			url: "modulos/hdr/cabecera.php",
			data: {documento:cedula, cti:1},
			success: function(result){
				document.getElementById('personalJF').innerHTML = result;
			}
		});
	}
}
</script>
<span class="texto_gris">Cabecera del Formulario <?php echo isset($rowt['idHdrRuta'])?'(Editando Hoja de Ruta Seleccionada)':'';?></span>
<form method="post" action="modulos/hdr/grabar/grabacabecera.php" method="post" onsubmit="/operaciones/modulos/hdr/validar/validarcabecera.js">
<table width="100%" border="0">
	<tr>
    	<td class="etiqueta">Unidad</td>
    	<td colspan="2">
        <input type="hidden" name="idHdrRuta" id="idHdrRuta" value="<?php echo isset($rowt['idHdrRuta'])?$rowt['idHdrRuta']:0 ?>" size="10" readonly="readonly">
        <input type="hidden" name="idGenActividadGA" id="idGenActividadGA" value="<?php echo $rowUnidad['idGenActividadGA']; ?>" size="10" readonly="readonly">
        <input type="hidden" name="opc" value="<?php echo $_GET['opc']?>" />
        <input type="hidden" name="pesta" value="<?php echo isset($_GET['pesta'])? $_GET['pesta']:0 ?>" />
        <input type="hidden" name="recno" value="<?php echo isset($_GET['recno'])? $_GET['recno']:0 ?>" />
        <label name="Unidad" id="Unidad" style="border:none; background-color:#fff; color:#006; font-size:11px;font-weight:bold;height:auto"><?php echo $rowUnidad['descGestionAdmin']; ?></label>
   	    </td>
   	    <td class="etiqueta">Jefe de Control</td>
   	    <td>
   	    	<table>
   	    	<tr>
   	    			<td colspan="2"><div id='personalJF'><?php 
   	    			if(isset($rowt['documento'])){
   	    				echo '<label name="Unidad" id="Unidad" style="border:none; background-color:#fff; color:#006; font-size:11px;font-weight:bold;height:auto">'.$rowt['siglas'].'. '.$rowt['apenom'].'</label><br>';
   	    			}
   	    			?></div></td>
   	    		</tr>
   	    		<tr>
   	    			<td>
			   	    	<input type="text" name="cedula" id="cedula" value="<?php echo isset($rowt['documento'])?$rowt['documento']:'' ?>">
			   	    </td>
			   	    <td>
			   	    <a href="javascript:void(0)" onclick="buscarDatos($.trim(document.forms[0].cedula.value))" class="button" id="Buscar">
			            <span><img  src="../imagenes/ver.png" alt="0" border="0"/> Buscar</span></a>
			            
			   	    	<a href="../funciones/persona_list.php?policia=<?php echo $poli ?>&activo=<?php echo $activo ?>" onclick="return GB_showPage('Busca Persona', this.href)" class="button">
			            <span><img  src="../imagenes/ver.png" alt="0" border="0"/> Buscar por Nombres</span></a>
			   	    </td>
   	    		</tr>
   	    	</table>
   	    </td>
    </tr>
    <tr>
    	<td class="etiqueta">Fecha Inicio</td>
    	<td><input type="text"  id="fechaHdrRutaInicio" name="fechaHdrRutaInicio" size="12" value="<?php echo isset($rowt['fechaHdrRutaInicio'])?$rowt['fechaHdrRutaInicio']:'' ?>" readonly="readonly" onchange="fecha_es()"/>
        <input type="button" value="" onclick="displayCalendar(document.forms[0].fechaHdrRutaInicio,'yyyy-mm-dd',this)" class="calendario"/></td>
        <td></td>
    	<td class="etiqueta">Fecha Fin</td>
    	<td><input type="text" id="fechaHdrRutaFin" name="fechaHdrRutaFin" size="12" value="<?php echo isset($rowt['fechaHdrRutaFin'])?$rowt['fechaHdrRutaFin']:'' ?>" readonly="readonly"/>
        <input type="button" value="" onclick="displayCalendar(document.forms[0].fechaHdrRutaFin,'yyyy-mm-dd',this)" class="calendario"/></td>
    </tr>
	<tr>
    	<td class="etiqueta">Hora Inicio</td>
    	<td><input type="text" name="horarioInicio" value="<?php echo isset($rowt['horarioInicio'])?$rowt['horarioInicio']:'' ?>"></td>
        <td></td>
    	<td class="etiqueta">Hora Fin</td>
    	<td><input type="text" name="horarioFin" value="<?php echo isset($rowt['horarioFin'])?$rowt['horarioFin']:'' ?>"></td>
    </tr>
	<tr>
    	<td></td>
    	<td  colspan="2" align="center"><input type="submit" value="Enviar" class="boton_save"></td>
        <td colspan="2" align="center">
        	<a href="index.php?opc=<?php echo $_GET['opc'] ?>&pesta=1" class="button" style="width:100px"><span>Nuevo</span></a>
            <td></td>
    </tr>
</table>
</form>