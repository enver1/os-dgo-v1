<?php
session_start();
include '../../../funciones/db_connect.inc.php';
include '../../../funciones/redirect.php';
$tabla='genDivPolitica';
if($_POST['id']=='' or $_POST['id']==0)
	{
		echo '<script language="javascript"> alert("Registro vacio");</script>';
	}
else
	{
		delete($conn,$_POST['id'],$tabla);
	}
?>