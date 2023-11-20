<?php
session_start();
include_once '../../../../clases/autoload.php';
include_once '../../../../funciones/funcion_select.php';
$conn = DB::getConexionDB();
$transaccion = new Transaccion();
$ip = $transaccion->getRealIP();
$idDgoOrdenServicio = $_GET['idDgoOrdenServicio'];
$sqlC = "SELECT * FROM dgoControlOrden a WHERE a.verificado='S' AND a.idDgoOrdenServicio={$idDgoOrdenServicio}";
$rs1   = $conn->query($sqlC);
$rowt1 = $rs1->fetch();
if (!empty($rowt1)) {
    if ($rowt1['verificado'] == 'S' and $rowt1['procesado'] == 'N' and $rowt1['impreso'] == 'N') {
        $sql       = "UPDATE dgoControlOrden a set a.verificado='N',a.fechaVerificado=now(),a.usuario=?,ip=?,a.fecha=now() where idDgoOrdenServicio='" . $idDgoOrdenServicio . "'";
        $sentencia = $conn->prepare($sql);
        $i         = 0;
        $sentencia->bindParam(++$i, $_SESSION['usuarioAuditar']);
        $sentencia->bindParam(++$i, $ip);
        $sentencia->execute() or die('error');
    }
}
