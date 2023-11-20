<?php
session_start();
include '../../../clases/autoload.php';
$conn = DB::getConexionDB();
include_once('config.php');
if ($_POST['id'] == '' or $_POST['id'] == 0) {
	echo '<script language="javascript"> alert("Registro vacio");</script>';
} else {
	delete($conn, $_POST['id'], 'genUnidadesGeoreferencial');
}
