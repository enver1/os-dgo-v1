<?php
if (!isset($_SESSION)){ session_start();}
include '../../../funciones/db_connect.inc.php';

/**
 * obtener combo para seleccionar el subtipo
 */
if(isset($_REQUEST['claseTipificacion'])){
	$subtificacion = "SELECT idGenSubTipificacion,descripcion FROM genSubTipificacion WHERE idGenClaseTipificacion = ".$_REQUEST['claseTipificacion'];
	$rsSubtificacion = $conn->query($subtificacion);
	?>
	<select name="subTipificacion" id="subTipificacion" class="inputSombra" style="width:200px" onchange="getSubTipificacion('combos.php',{subTipificacion:this.value},$('#tipoTipificacionTD'))">
	    		<option value="">Seleccione...</option>
	    		<?php 
	    		while($row=$rsSubtificacion->fetch(PDO::FETCH_ASSOC)){
	    			?>
	    			<option value="<?php echo $row['idGenSubTipificacion']?>"><?php echo $row['descripcion']?></option>
	    			<?php
	    		}
	    		?>
	</select>
	<?php
	exit();
}
/**
 * obtener combo para seleccionar el tipo
 */
if(isset($_REQUEST['subTipificacion'])){
	$tipoTipificacion = "SELECT idGenTipoTipificacion,descripcion FROM genTipoTipificacion WHERE idGenSubTipificacion = ".$_REQUEST['subTipificacion'];
	$rsTipoTipificacion = $conn->query($tipoTipificacion);
	?>
	<select name="idGenTipoTipificacion" id="idGenTipoTipificacion" class="inputSombra" style="width:200px" >
		<option value="">Seleccione...</option>
	    <?php 
	    while($row=$rsTipoTipificacion->fetch(PDO::FETCH_ASSOC)){
	    ?>
	    <option value="<?php echo $row['idGenTipoTipificacion']?>"><?php echo $row['descripcion']?></option>
	    <?php
	    }
	    ?>
	</select>
	<?php
}