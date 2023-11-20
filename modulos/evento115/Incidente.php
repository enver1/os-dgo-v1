<?php 
include_once('../../funciones/cabecera_modulo.php'); 
/**
 * objeto cliente
 */
$client = new SoapClient("http://190.214.21.185:8086/sis_ecu911/Service.svc?wsdl");

$return = $client->getIncidentAppeal(array("value"=>$_GET['id']));

$rowResult = $return->getIncidentAppealResult->incidentAppeal;

$rowResultDiaposal = $return = $client->getIncDisposal(array("value"=>$_GET['id']));

$auxRow = $rowResultDiaposal->getIncDisposalResult->incDisposal;

/**
 * obtener tipificación
 * clase de tipificación
 */
$claseTipificacion="SELECT idGenClaseTipificacion,descripcion FROM genClaseTipificacion";
$rsClaseTipificacion = $conn->query($claseTipificacion);
?>
<script type="text/javascript" src="validacion.js"></script>
<span class="texto_gris"><?php echo $auxRow->IncidentTypeName;?></span>
	<table width="100%" cellpadding="2" cellspacing="1">
		<tr>
			<td class="etiqueta" width="20%">IncidentTitle</td>
			<td width="30%"><?php echo $rowResult->IncidentTitle;?></td>
			<td class="etiqueta" width="20%">Nivel:</td>
			<td width="30%"><?php echo $rowResult->IncidentGradeName;?></td>
		</tr>
		<tr>
			<td class="etiqueta">Reportado por:</td>
			<td><?php echo $rowResult->IncidentReportMan;?></td>
			<td class="etiqueta">Recepci&oacute;n de la alerta:</td>
			<td><?php echo $rowResult->IncidentTime;?></td>
		</tr>
		<tr>
			<td class="etiqueta">Tel&eacute;fono:</td>
			<td><?php echo $rowResult->IncidentReportPhone;?></td>
			<td class="etiqueta">Tel&eacute;fono de contacto:</td>
			<td><?php echo $rowResult->ContactPhone;?></td>
		</tr>
		<tr>
			<td class="etiqueta">Direcci&oacute;n:</td>
			<td colspan="3"><?php echo $rowResult->IncidentAddress;?></td>
		</tr>
		<tr>
			<td class="etiqueta">Latitud:</td>
			<td><?php echo $auxRow->latitude;?></td>
			<td class="etiqueta">Longitud:</td>
			<td><?php echo $auxRow->longitude;?></td>
		</tr>
		<tr>
			<td class="etiqueta" valign="top">Descripci&oacute;n:</td>
			<td colspan="3"><?php echo $rowResult->IncidentDescription;?></td>
		</tr>
		<tr>
			<td class="etiqueta">Inicio Incidente</td>
			<td><?php echo $auxRow->StartTime;?></td>
			<td class="etiqueta">Fin Incidente</td>
			<td><?php echo $auxRow->EndTime;?></td>
		</tr>
	</table>
	<table>
	  <tr>
	    <td class="etiqueta" width="20%">Clase Tipificaci&oacute;n</td>
	    <td>
	    	<select name="claseTipificacion" id="claseTipificacion" class="inputSombra" style="width:200px" onchange="getSubTipificacion('combos.php',{claseTipificacion:this.value},$('#subTipificacionTD'))">
	    		<option value="">Seleccione...</option>
	    		<?php 
	    		while($row=$rsClaseTipificacion->fetch(PDO::FETCH_ASSOC)){
	    			?>
	    			<option value="<?php echo $row['idGenClaseTipificacion']?>"><?php echo $row['descripcion']?></option>
	    			<?php
	    		}
	    		?>
	    	</select>
	    </td>
	    <td class="etiqueta" width="20%">Sub Tipificaci&oacute;n</td>
	    <td id="subTipificacionTD">
	    	<select name="subTipificacion" id="subTipificacion" class="inputSombra" style="width:150px">
	    		<option value="">Seleccione...</option>
	    	</select>
	    </td>
	    <td class="etiqueta" width="20%">Tipo Tipificaci&oacute;n</td>
	    <td id="tipoTipificacionTD">
	    	<select name="idGenTipoTipificacion" id="idGenTipoTipificacion" class="inputSombra" style="width:150px">
	    		<option value="">Seleccione...</option>
	    	</select>
	    </td>
	  </tr>
	</table>

	<table id='my-tbl'>
	  <tr>
	    <th class="data-th">Items</th>
	    <th class="data-th">Vehiculo</th>
	    <th class="data-th">Fecha Hora en Sitio</th>
	    <th class="data-th">Ultima acci&oacute;n en despacho</th>
	    <th class="data-th">Retroalimentaci&oacute;n en sitio</th>
	  </tr>
	  <?php 
	  
	  if(isset($rowResultDiaposal->getIncDisposalResult->incDisposal)){
		  $i = 1;
		  foreach ($rowResultDiaposal->getIncDisposalResult->incDisposal as $rowResult){
				if(isset($rowResult->IncidentDisposalId)){
			?>
		  <tr class="data-tr">
		  	<td><?php echo $i++;?></td>
		    <td><?php echo $rowResult->ResVehicleNumber ?></td>
		    <td><?php echo $rowResult->T_Sitio ?></td>
		    <td><?php echo $rowResult->IncidentDisposalEndTime ?></td>
		    <td><?php echo $rowResult->FeedbackContent_Sitio ?></td>
		  </tr>
		  <?php }
		  }
		  
		  if($i == 1){
		  	?>
		  	<tr class="data-tr">
		  	<td><?php echo $i++;?></td>
		    <td><?php echo $auxRow->ResVehicleNumber ?></td>
		    <td><?php echo $auxRow->T_Sitio ?></td>
		    <td><?php echo $auxRow->IncidentDisposalEndTime ?></td>
		    <td><?php echo $auxRow->FeedbackContent_Sitio ?></td>
		  </tr>
		  	<?php
		  }
	   }else{
	   	?>
	   	<tr>
	   		<td colspan="3"><?php echo "No hay datos que mostrar";?></td>
	   	</tr>
	   	<?php
	   }?>
	</table>

<?php include_once('../../funciones/pie_modulo.php'); ?>