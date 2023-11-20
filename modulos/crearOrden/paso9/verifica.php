<?php
session_start();
header('Content-Type: text/html; charset=UTF-8');
include_once '../../../../clases/autoload.php';
$conn = DB::getConexionDB();
$transaccion = new Transaccion();
$ip = $transaccion->getRealIP();
$crearOrdenServicio = new CrearOrdenServicio;
$mensaje      = '';
$idDgoOrdenServicio  = strip_tags($_POST['id']);

if (!empty($idDgoOrdenServicio)) {
    $dato     = true;

    $sqltP2   = $crearOrdenServicio->verificaAntecedente($idDgoOrdenServicio);

    if (!empty($sqltP2)) {
    } else {
        $mensaje .= "<p style='color:#ff0000'>Verifique el  Paso 2. Antecedentes: NO Existe Registro de Antecedentes</p>";
        $dato = false;
    }

    $sqltAr = $crearOrdenServicio->verificaMision($idDgoOrdenServicio);
    if (!empty($sqltAr)) {
    } else {
        $mensaje .= "<p style='color:#ff0000'>Verifique en el Paso 3. Misión: NO Existe Registro de Misión</p>";
        $dato = false;
    }

    $sqltAr1 = $crearOrdenServicio->verificaInstrucciones($idDgoOrdenServicio, "G");
    if (!empty($sqltAr1)) {
    } else {
        $mensaje .= "<p style='color:#ff0000'>Verifique en el Paso 4. Instrucciones Generales: NO Existe Registro de Instrucciones Generales</p>";
        $dato = false;
    }
    $sqltAr5 = $crearOrdenServicio->verificaInstrucciones($idDgoOrdenServicio, "P");
    if (!empty($sqltAr5)) {
    } else {
        $mensaje .= "<p style='color:#ff0000'>Verifique en el Paso 5. Instrucciones Generales: NO Existe Registro de Instrucciones Generales</p>";
        $dato = false;
    }

    // $sqltAr2 = $crearOrdenServicio->verificaFuerzasPropias($idDgoOrdenServicio);
    // if (!empty($sqltAr2)) {
    // } else {
    //     $mensaje .= "<p style='color:#ff0000'>Verifique en el Paso 6.1. Talento Humano: NO Existe Registro de Talento Humano</p>";
    //     $dato = false;
    // }
    $sqltAr3 = $crearOrdenServicio->verificaFuerzasAgregadas($idDgoOrdenServicio);
    if (!empty($sqltAr3)) {
    } else {
        $mensaje .= "<p style='color:#ff0000'>Verifique en el Paso 6.2. Agregaciones: NO Existe Registro de Agregaciones</p>";
        $dato = false;
    }
    $sqltAr4 = $crearOrdenServicio->verificaMediosLogísticos($idDgoOrdenServicio);
    if (!empty($sqltAr4)) {
    } else {
        $mensaje .= "<p style='color:#ff0000'>Verifique en el Paso 6.3. Medios Logísticos: NO Existe Registro de Medios Logísticos</p>";
        $dato = false;
    }
    $sqltAr7 = $crearOrdenServicio->verificaEjemplares($idDgoOrdenServicio);
    if (!empty($sqltAr7)) {
    } else {
        $mensaje .= "<p style='color:#ff0000'>Verifique en el Paso 7. Ejemplares: NO Existe Registro de Ejemplares</p>";
        $dato = false;
    }
    $sqltAr8 = $crearOrdenServicio->verificaAnexos($idDgoOrdenServicio);
    if (!empty($sqltAr8)) {
    } else {
        $mensaje .= "<p style='color:#ff0000'>Verifique en el Paso 8. Anexos: NO Existe Registro de Anexos</p>";
        $dato = false;
    }

    /*fin de la verificacion de los participantes*/
    if ($dato) {
        $sql = "UPDATE dgoControlOrden set verificado='S',fechaVerificado=now(),usuario=?,ip=?,fecha=now() where idDgoOrdenServicio='" . $idDgoOrdenServicio . "'";
        $sentencia = $conn->prepare($sql);
        $i         = 0;
        $sentencia->bindParam(++$i, $_SESSION['usuarioAuditar']);
        $sentencia->bindParam(++$i, $ip);
        $sentencia->execute() or die('error');
        $mensaje .= "<div class='okmess'><p style='color:#333;font-size:18px'>VERIFICACI&Oacute;N REALIZADA EXITOSAMENTE</p></div>";
    } else {
        $mensaje .= "<div class='errormess'><p style='color:#333;font-size:18px'>FALL&Oacute; LA VERIFICACI&Oacute;N</p></div>";
    }
    echo '' . $mensaje;
}
