<script type="text/javascript">
    $(document).ready(function() {
        var value = $('#idTS').val();
        if (value != "") {
            $("#idIgpTSancion option[value=" + value + "]").attr("selected", true);
        }
    });
</script>
<input type="hidden" name="idTS" id="idTS" value="<?php

                                                    $ts = "";
                                                    if (isset($_GET['ts'])) {
                                                        $ts = $_GET['ts'];
                                                    }



                                                    echo $ts ?>" />

<?php


$codigo = $_GET['codigo'];

include_once '../../../clases/autoload.php';
include_once '../../../funciones/funcion_select.php';
include_once '../../../funciones/funciones_generales.php';
$conn = DB::getConexionDB();
$sqlV = "SELECT idDgoVisita FROM dgoVisita WHERE idDgoActUnidad='$codigo'";


$rs = $conn->query($sqlV);

if ($rowt = $rs->fetch(PDO::FETCH_ASSOC)) {
    $idDgoVisita = $rowt['idDgoVisita'];
} else {
    $idDgoVisita = 0;
}

echo '<input type="hidden" name="idDgoVisita"  id="idDgoVisita" value="' . $idDgoVisita . '" />';

$sql = "SELECT b.idDgoEjeProcSu, a.descDgoEje descripcion
FROM dgoEje a
INNER JOIN dgoEjeProcSu b ON a.idDgoEje=b.idDgoEje
INNER JOIN dgoActividad c ON b.idDgoEjeProcSu=c.idDgoEjeProcSu
INNER JOIN dgoInstrucci d ON c.idDgoActividad=d.idDgoActividad
INNER JOIN dgoActUniIns e ON d.idDgoInstrucci=e.idDgoInstrucci
INNER JOIN dgoActUnidad f ON e.idDgoActUnidad=f.idDgoActUnidad
WHERE f.idDgoActUnidad='$codigo' GROUP BY b.idDgoEjeProcSu ORDER BY 2";

$onclick = 'onchange="muestraDatos()"';
$nombretabla = 'dgoEjeProcSu';
$indice = 'idDgoEjeProcSu';
$title = 'Caracter&iacute;sticas del tipo de evidencia';
$valoractual = "";
if (isset($_GET['idc'])) {
    $valoractual = $_GET['idc'];
}



generaComboSimpleSQL($conn, $nombretabla, 'idDgoEjeProcSu', 'descripcion', $valoractual, $sql, $onclick, $estilo = 'width:250px', $clase = 'inputSombra', $lectura = '', $title);




?>