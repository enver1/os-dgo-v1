<?php
session_start();
include '../../../funciones/db_connect.inc.php';
$tabla='hdrGrupResum'; // *** CAMBIAR *** Nombre de la Tabla
$idcampo=ucfirst($tabla); //Nombre del Id de la tabla
if($_GET['id']=='' or $_GET['id']==0)
	{
		echo '<script language="javascript"> alert("Registro vacio");</script>';
	}
else
	{
	
		delete($conn,$_GET['id'],$tabla);
	}
?>