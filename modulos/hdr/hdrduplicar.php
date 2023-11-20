<?php
include_once('../../funciones/cabecera_modulo.php');
include_once('../../../funciones/funcion_select.php');
/**
 * obtener información de la unidad correspondiente
 */
$sqlUnidad ="select * from v_datos_GA where sha1(idGenUsuarioAplicacion)='".$_GET['opc']."' and idGenUsuario=".$_SESSION['usuarioAuditar'];

/**
 * ejecutando consulta
 */
$rs=$conn->query($sqlUnidad);
/**
 * obteniendo resultado
*/
$rowUnidad=$rs->fetch();

/**
 * Nombre del Id de la Tabla
 */
$idcampo=ucfirst('hdrRuta');


/**
 * obtener información de la Hoja de ruta a duplicarse
 */
$sql = "SELECT 
  a.*,
   v_persona.apenom AS 'nombre',
  v_persona.documento, 
  v_persona.siglas
FROM
  hdrRuta a 
  INNER JOIN v_persona 
    ON a.idGenPersona = v_persona.idGenPersona 
WHERE SHA1(a.idHdrRuta) = '{$_GET['recno']}'";
$rs=$conn->query($sql);
$rowt=$rs->fetch();
?>
<!--<script type="text/javascript" src="../../../../js/calendario/calendar/calendar.js?random=20060118"></script>-->
<link type="text/css" rel="stylesheet" href="../../../js/calendario/calendar/calendar.css?random=20051112" media="screen" />
<script type="text/javascript" src="../../../js/calendario/calendar/calendar.js?random=20060118"></script>
<span class="texto_gris">Cabecera del Formulario</span>
<form method="post" action="../hdr/grabar/grabahdrduplicar.php" name="formHdrduplicar">
<table width="100%" border="0">
	<tr>
    	<td class="etiqueta">Unidad</td>
    	<td colspan="2">
	        <input type="hidden" name="idHdrRutaClonar" id="idHdrRutaClonar" value="<?php echo isset($rowt['idHdrRuta'])?$rowt['idHdrRuta']:0 ?>" size="10" readonly="readonly">
	        <input type="hidden" name="idGenActividadGA" id="idGenActividadGA" value="<?php echo isset($rowUnidad['idGenActividadGA'])?$rowUnidad['idGenActividadGA']:'' ?>" size="10" readonly="readonly">
	        <input type="hidden" name="opc" value="<?php echo $_GET['opc']?>" />
	        <input type="hidden" name="pesta" value="<?php echo isset($_GET['pesta'])? $_GET['pesta']:0 ?>" />
	        <label name="Unidad" id="Unidad" style="border:none; background-color:#fff; color:#006; font-size:11px;font-weight:bold;height:auto"><?php echo isset($rowUnidad['descGestionAdmin'])?$rowUnidad['descGestionAdmin']:'' ?></label>
   	    </td>
        <td class="etiqueta">Jefe de Control</td>
        <td>
        	<label name="Unidad" id="Unidad" style="border:none; background-color:#fff; color:#006; font-size:11px;font-weight:bold;height:auto"><?php echo isset($rowt['nombre'])?$rowt['siglas'].'. '.$rowt['nombre']:'' ?></label>
   	    	<input type="hidden" name="idGenPersona" value="<?php echo isset($rowt['idGenPersona'])?$rowt['idGenPersona']:'' ?>">
   	    </td>
    </tr>
    <tr>
    	<td class="etiqueta">Fecha Inicio</td>
    	<td><input type="text"  id="fechaHdrRutaInicio" name="fechaHdrRutaInicio" size="12" value="<?php echo date('Y-m-d'); ?>" readonly="readonly" onchange="fecha_es()"/>
        <input type="button" value="" onclick="displayCalendar(this.form.fechaHdrRutaInicio,'yyyy-mm-dd',this)" class="calendario"/></td>
        <td></td>
    	<td class="etiqueta">Fecha Fin</td>
    	<td><input type="text" id="fechaHdrRutaFin" name="fechaHdrRutaFin" size="12" value="<?php echo date('Y-m-d'); ?>" readonly="readonly"/>
        <input type="button" value="" onclick="displayCalendar(this.form.fechaHdrRutaFin,'yyyy-mm-dd',this)" class="calendario"/></td>
    </tr>
	<tr>
    	<td class="etiqueta">Hora Inicio</td>
    	<td><input type="text" name="horarioInicio" value="<?php echo isset($rowt['horarioInicio'])?$rowt['horarioInicio']:'' ?>"></td>
        <td></td>
    	<td class="etiqueta">Hora Fin</td>
    	<td><input type="text" name="horarioFin" value="<?php echo isset($rowt['horarioFin'])?$rowt['horarioFin']:'' ?>"></td>
    </tr>
	<tr>
    	<td>&nbsp;</td>
    	<td  colspan="2" align="center"><input type="submit" value="Enviar" class="boton_save"></td>
        <td colspan="2" align="center">&nbsp;</td>
    </tr>
</table>
</form>

<?php 
include_once('../../funciones/pie_modulo.php');
?>