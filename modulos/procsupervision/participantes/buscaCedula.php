<?php
/*
		ESTA FUNCION PERMITE BUSCAR UNA PERSONA EN LA TABLA genPersona
		Y SI NO EXISTE BUSCA EN LA BASE DE DATOS DEL REGISTRO CIVIL
		Y CUANDO LA ENCUENTRA, INSERTA EL REGISTRO AUTOMATICAMENTE EN genPersona
		Author			Darwin Curipallo
		Actualización	Alberto Arias
*/
session_start();
include '../../../../clases/autoload.php';
$conn = DB::getConexionDB();
include_once('../../../../funciones/redirect.php');
include_once('../../../../funciones/funciones_generales.php');
include_once('../../../../funciones/funciones_ws.php');
$sNtabla = 'v_personal_pn';
$sql = "select idGenPersona from " . $sNtabla . " where idDgpTipoSituacion='A' and documento='" . $_POST['usuario'] . "' order by idDgpTipoSituacion limit 1";
//echo $sql;
$mensaje = 'PERSONA NO EXISTE ';
if (isset($_POST['usuario'])) {
	$rs = $conn->query($sql);
	if ($row = $rs->fetch(PDO::FETCH_ASSOC)) {
		$idGenPersona = $row['idGenPersona'];
	} else {
		$idGenPersona = 0;
	}

	if ($idGenPersona > 0) {

		$sql = "select idGenPersona,siglas,apenom from " . $sNtabla . " where idDgpTipoSituacion='A' and idGenPersona='" . $idGenPersona . "'";
		$rs = $conn->query($sql);
		if ($row = $rs->fetch(PDO::FETCH_ASSOC)) {
			$dt = new DateTime('now', new DateTimeZone('America/Guayaquil'));
			$hoy = $dt->format('Y-m-d');
			//$edad=tiempoTranscurrido($row['fechaNacimiento'],$hoy);
			$laedad = explode(',', $edad[1]);
			$anios = $laedad[0];
			$edad = mb_convert_encoding($edad[0], "UTF-8", "ISO-8859-1");
			$nombres = $row['siglas'] . ' ' . $row['apenom'];
			$respuesta = array(($row['idGenPersona']),
				$nombres,
				$row['documento'],
				$row['siglas']
			);

			echo json_encode($respuesta);
		}
	} else {
		echo json_encode(array(0, $mensaje, '', '', '', 0, '', '', '', ''));
	}
}
