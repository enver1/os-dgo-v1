<?php
session_start();
include '../../../funciones/db_connect.inc.php';
include_once('config.php');
if($_POST['id']=='' or $_POST['id']==0)
	{
		echo '<script language="javascript"> alert("Registro vacio");</script>';
	}
else
{
	$swf=false;
	foreach($formulario as $campos)
	{ 
		if($campos['tipo']=='file')
		{
			$swf=true;
			$campoImg=$campos['campoTabla'];
			$path=$campos['pathFile'];
		}
	}
	if($swf)
	{
		$sqlI="select ".$campoImg." from ".$tabla." where ".$idcampo."=".$_POST['id'];
		$rsI=$conn->query($sqlI);
		if($rowI=$rsI->fetch() and !empty($rowI[$campoImg]))
			unlink($path.$rowI[$campoImg]);
	}
	delete($conn,$_POST['id'],$tabla);
}
?>