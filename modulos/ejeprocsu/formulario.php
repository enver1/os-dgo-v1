<?php
session_start();
header('Content-Type: text/html; charset=UTF-8');
include '../../../clases/autoload.php';
include_once('../../../funciones/funcion_select.php');
include_once('config.php');
$conn = DB::getConexionDB();
$encriptar            = new Encriptar;
$frm                  = new Form;
$opc                  = strip_tags($_GET['opc']);
$idcampoA             = strip_tags($encriptar->getDesencriptar($_GET['c'], $_SESSION['usuarioAuditar']));
$rowt = array();
/*-------------------------------------------------*/
if (isset($_GET['c']) && $_GET['c'] > 0) {
    $sql = "select * from " . $Ntabla . " where " . $idcampo . "='" . $idcampoA . "'";
    $rs = $conn->query($sql);
    $rowt = $rs->fetch(PDO::FETCH_ASSOC);
}
/* ==== Aqui se incluye el formulario de edicion */
$frm->getFormulario($formulario, $rowt, $idcampo, $opc);
