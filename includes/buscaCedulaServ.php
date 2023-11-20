<?php
header("content-type: application/json; charset=utf-8");
session_start();
include '../../clases/autoload.php';
include_once '../../funciones/redirect.php';
include_once '../../funciones/funciones_generales.php';
include_once '../../funciones/funciones_ws.php';
$conn = DB::getConexionDB();
$transaccion =  new Transaccion;
$sNtabla = 'v_persona_dgl';
$cedula  = $_GET['usuario'];
$sql     = "select idGenPersona from " . $sNtabla . " where documento='" . $_GET['usuario'] . "' order by idGenPersona limit 1";

$mensaje = 'PERSONA NO EXISTE ';

if (isset($_GET['usuario'])) {
    $rs = $conn->query($sql);
    if ($row = $rs->fetch(PDO::FETCH_ASSOC)) {
        $idGenPersona = $row['idGenPersona'];
    } else {

        if (is_null($row['idGenPersona'])) {
            $idGenPersona = 0;
        } else {
            if (validarCedula($_GET['usuario'])) {
                $idGenPersona = registroPersona($conn, $tipoDocumento = 'C', $cedula, realIP(), $gestor = 'mysql', 'web', $_SESSION['usuarioAuditar'], 'interna', $path = '../../', $ciudadano = 'N');
            } else {
                $idGenPersona = registroPersona($conn, $tipoDocumento = 'C', $cedula, realIP(), $gestor = 'mysql', 'web', $_SESSION['usuarioAuditar'], 'interna', $path = '../../../../', $ciudadano = 'N');
            }
        }
    }

    if ($idGenPersona > 0) {
        $sql = "SELECT  *,c.fechaDefuncion
                    FROM
                        v_persona_dgl a
                    LEFT JOIN v_personal_pn b ON b.idGenPersona = a.idGenPersona
                    INNER JOIN genPersona c ON c.idGenPersona=a.idGenPersona
                    WHERE
                        a.idGenPersona =" . $idGenPersona;

        $rs = $conn->query($sql);
        if ($row = $rs->fetch(PDO::FETCH_ASSOC)) {
            //if (is_null($row['fechaDefuncion'])) {
            if (is_null($row['siglas'])) {

                echo json_encode(array(0, 'EL CIUDADANO NO ES SERVIDOR POLICIAL', '', '', '', 0, '', '', '', ''));
            } else {

                if ($row['situacionPolicial'] == 'Activo') {
                    $dt        = new DateTime('now', new DateTimeZone('America/Guayaquil'));
                    $hoy       = $dt->format('Y-m-d');
                    $edad      = tiempoTranscurrido($row['fechaNacimiento'], $hoy);
                    $laedad    = explode(',', $edad[1]);
                    $anios     = $laedad[0];
                    $edad      = mb_convert_encoding($edad[0], "UTF-8", "ISO-8859-1");
                    $nombres   = $row['siglas'] . '.  ' . $row['apenom'];

                    $respuesta = array(($row['idGenUsuario']),
                        $nombres,
                        $anios,
                        $row['documento'],
                        $row['fechaNacimiento'],
                        $row['siglas'],
                        $row['grado'],
                        $row['situacionPolicial'],

                    );
                    echo json_encode($respuesta);
                } else {
                    echo json_encode(array(0, 'SERVIDOR POLICIAL CONSTA COMO BAJA', '', '', '', 0, '', '', '', ''));
                }
            }


            /*}else {echo json_encode(array(0, 'PERSONA CONSTA COMO FALLECIDA', '', '', '', 0, '', '', '', ''));}*/
        }
    } else {
        echo json_encode(array(0, $mensaje, '', '', '', 0, '', '', '', ''));
    }
}
