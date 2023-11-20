<?php
session_start();
include '../../../funciones/db_connect.inc.php';
$tabla='genEstVehi'; // *** CAMBIAR *** Nombre de la Tabla
$idcampo=ucfirst($tabla); //Nombre del Id de la tabla
if($_POST['id']=='' or $_POST['id']==0)
	{
		echo '<script language="javascript"> alert("Registro vacio");</script>';
	}
else
	{
		delete($conn,$_POST['id'],$tabla);
	}
?>