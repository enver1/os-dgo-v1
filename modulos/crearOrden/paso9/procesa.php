<?php
session_start();
include_once '../../../../clases/autoload.php';
$conn = DB::getConexionDB();
$transaccion = new Transaccion;
$crearOrdenServicio = new CrearOrdenServicio;
$ambitoGestionOrden      = new AmbitoGestionOrden;
$ip = $transaccion->getRealIP();
if (isset($_POST['id'])) {
    $idDgoOrdenServicio = $_POST['id'];
    $sql       = "UPDATE dgoControlOrden set procesado='S',fechaProcesado=now(),usuario=?,ip=?,fecha=now() 
    where idDgoOrdenServicio='" . $idDgoOrdenServicio . "'";
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
    $idDgoOrdenServicio       = strip_tags($_POST['id']);
    $row = $crearOrdenServicio->insertaOrdinal($idGenGeoSenplades, $idDgoOrdenServicio, $anioHoy, $siglasDistrito);
    /////////////////////////////MODIFICA ESTADO ORDEN/////////////////////////////////////////////////////
    $sql       = "UPDATE dgoOrdenServicio set estadoOrden='VALIDADA',usuario=?,ip=?,fecha=now() 
    where idDgoOrdenServicio='" . $idDgoOrdenServicio . "'";
    $sentencia = $conn->prepare($sql);
    $i         = 0;
    $sentencia->bindParam(++$i, $_SESSION['usuarioAuditar']);
    $sentencia->bindParam(++$i, $ip);
    $sentencia->execute() or die('error');

    echo json_encode(array('La Orden de Servicio ha sido creada con éxito', 0));
}
