<?php
session_start();
include '../../../funciones/db_connect.inc.php';
include_once('../../../funciones/funcion_select.php');
/*-------------------------------------------------*/
$tgraba='materias/graba.php'; // *** CAMBIAR *** nombre del php para insertar o actualizar un registro
$Ntabla='dneMateria'; // *** CAMBIAR *** Nombre de la Tabla
$directorio='modulos/materias'; // *** CAMBIAR ***
/*-------------------------------------------------*/
$idcampo=ucfirst($Ntabla); // Nombre del Id de la Tabla
if (isset($_GET['c']))
	{$sql="select * from ".$Ntabla." where id".$idcampo."='".$_GET['c']."'";
	$rs=$conn->query($sql);
	$rowt = $rs->fetch(PDO::FETCH_ASSOC);
	}
/*
* Aqui se incluye el formulario de edicion
*/
?>
<script type="text/javascript" src="<?php echo $directorio ?>/validacion.js"></script>
<form name="edita" id="edita" method="post">
  <table width="100%" border="0">
	<tr>
		<td>C&oacute;digo:</td>
		<td><input type="text" name="id<?php echo $idcampo ?>"  readonly="readonly" value="<?php echo isset($rowt['id'.$idcampo])?$rowt['id'.$idcampo]:'' ?>" class="inputSombra" style="width:80px"/></td>
	</tr>
  <tr>
<?php /*---------------------------------------------------*/
//  *** CAMBIAR ***  ?>
		<td>Descripci&oacute;n:</td>
		<td><input type="text" name="descripcion"  size="60" value="<?php echo isset($rowt['descripcion'])?$rowt['descripcion']:'' ?>" class="inputSombra" /></td>
	</tr>
  <tr>
		<td>Estado:</td>
		<td> <?php echo generaComboSimple($conn,'genEstado','idGenEstado','descripcion',isset($rowt['idGenEstado'])?$rowt['idGenEstado']:''); ?>
		</td>
	</tr>
  <tr>
		<td>Tipo Prueba:</td>
		<td><?php echo generaComboSimple($conn,'dneTipoPrueba','idDneTipoPrueba','descripcion',isset($rowt['idDneTipoPrueba'])?$rowt['idDneTipoPrueba']:''); ?></td>
	</tr>
  <tr>
 <?php /*----------------------------------------------------*/?>
		<td colspan="2" ><hr /><input type="hidden" name="opc" value="<?php echo $_GET['opc'] ?>" /></td>
	</tr>
<?php include_once('../../../funciones/botonera.php'); ?>
</form>
