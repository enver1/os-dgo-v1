<?php
session_start();
include_once '../../../../clases/autoload.php';
$conn = DB::getConexionDB();
$transaccion = new Transaccion;
$DgoInfOrdenServicio = new DgoInfOrdenServicio;
$ambitoGestionOrden      = new AmbitoGestionOrden;
$ip = $transaccion->getRealIP();
if (isset($_POST['id'])) {
    $idDgoInfOrdenServicio = $_POST['id'];
    $sql       = "UPDATE dgoControlInforme set procesado='S',fechaProcesado=now(),usuario=?,ip=?,fecha=now() 
    where idDgoInfOrdenServicio='" . $idDgoInfOrdenServicio . "'";
    $sentencia = $conn->prepare($sql);
    $i         = 0;
    $sentencia->bindParam(++$i, $_SESSION['usuarioAuditar']);
    $sentencia->bindParam(++$i, $ip);
    $sentencia->execute() or die('error');
    ///////////////////////INSERTA ORDINAL/////////////////////////////////////
    $dt              = new DateTime('now', new DateTimeZone('America/Guayaquil'));
    $fechaHoy        = $dt->format('Y-m-d');
    $anio = explode("-", $fechaHoy);
    $anioHoy = $anio[0];
    $datosUsuario =    $ambitoGestionOrden->getDatosUsuariosSenplades($_SESSION['usuarioAuditar']);
    $idGenGeoSenplades = $datosUsuario['idGenGeoSenplades'];
    $idGenPersona = $datosUsuario['idGenPersona'];
    $siglasDistrito = $datosUsuario['siglasD'];
    $idDgoInfOrdenServicio       = strip_tags($_POST['id']);
    $row = $DgoInfOrdenServicio->insertaOrdinal($idGenGeoSenplades, $idDgoInfOrdenServicio, $anioHoy, $siglasDistrito);
    /////////////////////////////MODIFICA ESTADO ORDEN/////////////////////////////////////////////////////
    $sql       = "UPDATE dgoInfOrdenServicio set estadoInforme='VALIDADA',usuario=?,ip=?,fecha=now() 
    where idDgoInfOrdenServicio='" . $idDgoInfOrdenServicio . "'";
    $sentencia = $conn->prepare($sql);
    $i         = 0;
    $sentencia->bindParam(++$i, $_SESSION['usuarioAuditar']);
    $sentencia->bindParam(++$i, $ip);
    $sentencia->execute() or die('error');

    echo json_encode(array('La Orden de Servicio ha sido creada con éxito', 0));
}
