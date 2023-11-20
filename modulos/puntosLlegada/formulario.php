<?php
session_start();
header('Content-Type: text/html; charset=UTF-8');

include_once '../../../clases/autoload.php';
include_once 'config.php';

$formPuntosLlegada = new FormPuntoLlegada;
$puntosLlegada     = new PuntosLlegada;

$dt          = new DateTime('now', new DateTimeZone('America/Guayaquil'));
$fechaHoy    = $dt->format('Y-m-d');
$opc         = strip_tags($_GET['opc']);
$idGoePunLleg = strip_tags($_GET['c']);
$rowt        = array();

if ($idGoePunLleg > 0) {
    $rowt = $puntosLlegada->getEditPuntosLlegada($idGoePunLleg);
}
$formPuntosLlegada->getFormularioPuntosLlegada($rowt, $idcampo, $opc);
?>
<script type="text/javascript">
    function buscaZSDCS() {
        var lati = $('#latitud').val();
        var longi = $('#longitud').val()
        $.ajax({
            type: 'GET',
            url: 'includes/maps/getSenplades.php',
            data: {
                latitud: lati,
                longitud: longi
            },
            success: function(response) {
                result = eval(response);
                if (result[2] > 0) {
                    var divpol = result[1] + ' (' + result[0] + ')';
                    // $('#senpladesDescripcion').val(divpol);
                    $('#idGenGeoSenplades').val(result[2]);
                }
            }
        });
    }
</script>