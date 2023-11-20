<?php
header("content-type: application/json; charset=utf-8");
session_start();
include '../../../clases/autoload.php';
include_once('../../../funciones/redirect.php');
include_once('../../../funciones/funciones_generales.php');
include_once('../../../funciones/funciones_ws.php');
$conn = DB::getConexionDB();
$sNtabla = 'genUsuario';
$mensaje = 'DOCUMENTO INGRESADO ES INCORRECTO.';
$documento = strip_tags(trim($_POST['usuario']));

if (!empty($documento) && is_numeric($documento) && strlen($documento) == 10) {
	$sql = "SELECT   	a.idGenUsuario,
						b.documento,
						CONCAT( IF ( ISNULL( b.siglas ), '', CONCAT( b.siglas, '. ' )), b.apenom ) siglasApenom,
						b.unidad,
						b.situacionPolicial,
						a.idGenPersona,
						em.email,
						tf.fono 
					FROM
						genUsuario a
						INNER JOIN v_personal_simple b ON a.idGenPersona = b.idGenPersona
						LEFT JOIN genTelefono tf ON tf.idGenPersona = a.idGenPersona 	AND tf.telefonoPrincipal = 'S'
						LEFT JOIN genEmail em ON em.idGenPersona = a.idGenPersona 	AND em.emailPrinc = 'S' 
					WHERE
						b.documento ='" . $documento . "'";

	$rs = $conn->query($sql);

	if ($row = $rs->fetch()) {
		$respuesta = $row;
	} else {
		$mensaje   = 'PERSONA NO EXISTE';
		$respuesta = array(0, '', $mensaje, '', '', 0, '', '', '', '');
	}
} else {
	$respuesta = array(0, '', $mensaje, '', '', 0, '', '', '', '');
}
ob_clean();
echo json_encode($respuesta);
