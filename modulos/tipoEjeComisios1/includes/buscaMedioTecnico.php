<?php
header("content-type: application/json; charset=utf-8");
session_start();
include '../../../../clases/autoload.php';
$conn = DB::getConexionDB();

if (isset($_GET['idDgoTipoEje'])) {
    $sql = "SELECT  a.idDgoTipoEje,
                    a.descripcion
                    FROM
                     dgoTipoEje a
                    WHERE a.idDgoTipoEje='{$_GET['idDgoTipoEje']}'";
    $mensaje = '';
    $rs      = $conn->query($sql);
    if ($row = $rs->fetch(PDO::FETCH_ASSOC)) {
        $respuesta = array(
            1,
            $row['idDgoTipoEje'],
            $row['descripcion'],

        );
        echo json_encode($respuesta);
    } else {
        echo json_encode(array(0, $mensaje));
    }
}
