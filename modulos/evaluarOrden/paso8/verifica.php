<?php
session_start();
header('Content-Type: text/html; charset=UTF-8');
include_once '../../../../clases/autoload.php';
$conn = DB::getConexionDB();
$transaccion = new Transaccion();
$ip = $transaccion->getRealIP();
$DgoInfOrdenServicio = new DgoInfOrdenServicio;
$mensaje      = '';
$idDgoInfOrdenServicio  = strip_tags($_POST['id']);

if (!empty($idDgoInfOrdenServicio)) {
    $dato     = true;

    $sqltP2   = $DgoInfOrdenServicio->verificaAntecedente($idDgoInfOrdenServicio);

    if (!empty($sqltP2)) {
    } else {
        $mensaje .= "<p style='color:#ff0000'>Verifique el  Paso 2. Antecedentes: NO Existe Registro de Antecedentes</p>";
        $dato = false;
    }
    $sqltAr2 = $DgoInfOrdenServicio->verificaFuerzasPropias($idDgoInfOrdenServicio);
    if (!empty($sqltAr2)) {
    } else {
        $mensaje .= "<p style='color:#ff0000'>Verifique en el Paso 3.1. Talento Humano: NO Existe Registro de Talento Humano</p>";
        $dato = false;
    }
    $sqltAr4 = $DgoInfOrdenServicio->verificaMediosLogísticos($idDgoInfOrdenServicio);
    if (!empty($sqltAr4)) {
    } else {
        $mensaje .= "<p style='color:#ff0000'>Verifique en el Paso 3.2. Medios Logísticos: NO Existe Registro de Medios Logísticos</p>";
        $dato = false;
    }
    $sqltAr = $DgoInfOrdenServicio->verificaOperaciones($idDgoInfOrdenServicio);
    if (!empty($sqltAr)) {
    } else {
        $mensaje .= "<p style='color:#ff0000'>Verifique en el Paso 3.3 Operaciones: NO Existe Registro de Operaciones Realizadas</p>";
        $dato = false;
    }
    $sqltAr1 = $DgoInfOrdenServicio->verificaEvaluacion($idDgoInfOrdenServicio);
    if (!empty($sqltAr1)) {
    } else {
        $mensaje .= "<p style='color:#ff0000'>Verifique en el Paso 4. Evaluación: NO Existe Registro de Evaluación</p>";
        $dato = false;
    }
    $sqltAr5 = $DgoInfOrdenServicio->verificaOportunidades($idDgoInfOrdenServicio);
    if (!empty($sqltAr5)) {
    } else {
        $mensaje .= "<p style='color:#ff0000'>Verifique en el Paso 5. Oportunidades: NO Existe Registro de Oportunidades de Mejora</p>";
        $dato = false;
    }

    $sqltAr7 = $DgoInfOrdenServicio->verificaEjemplares($idDgoInfOrdenServicio);
    if (!empty($sqltAr7)) {
    } else {
        $mensaje .= "<p style='color:#ff0000'>Verifique en el Paso 6. Ejemplares: NO Existe Registro de Ejemplares</p>";
        $dato = false;
    }
    $sqltAr8 = $DgoInfOrdenServicio->verificaAnexos($idDgoInfOrdenServicio);
    if (!empty($sqltAr8)) {
    } else {
        $mensaje .= "<p style='color:#ff0000'>Verifique en el Paso 7. Anexos: NO Existe Registro de Anexos</p>";
        $dato = false;
    }

    /*fin de la verificacion de los participantes*/
    if ($dato) {
        $sql = "UPDATE dgoControlInforme set verificado='S',fechaVerificado=now(),usuario=?,ip=?,fecha=now() where idDgoInfOrdenServicio='" . $idDgoInfOrdenServicio . "'";
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
