<?php
/* via ajax recibe el nodo seleccionado y busca al siguiente inferior y lo devuelve en un arreglo tipo JSON
	NOTA: esto funciona siempre y cuando el orden de los id sean iguales jerarquicamente  
*/
include '../../../funciones/db_connect.inc.php';
	$sql="select idGenTipoGeoSenplades,descripcion from genTipoGeoSenplades where idGenTipoGeoSenplades>'".$_POST['variable']."' order by idGenTipoGeoSenplades limit 1";
	$mens='No hay Tipo Inferior a este';

$rs=$conn->query($sql);
if($rowp=$rs->fetch())
	{

	$tt=stripslashes($rowp['descripcion']);
	$p = array('/á/','/é/','/í/','/ó/','/ú/','/Á/','/É/','/Í/','/Ó/','/Ú/','/à/','/è/','/ì/','/ò/','/ù/','/ñ/','/Ñ/');
  	$r = array('a','e','i','o','u','A','E','I','O','U','a','e','i','o','u','n','N');
  	$x=preg_replace($p, $r, $tt);
	$fila=array(iconv("UTF-8", "ISO-8859-1//IGNORE",$x),$rowp['idGenTipoGeoSenplades']);
	echo json_encode($fila);
	}
else
	{
	$mens=array($mens,0);
	echo json_encode($mens);
	}
?>