<?php
include_once '../../../funciones/db_connect.inc.php';
include_once '../../../clases/autoload.php';

$formDetalleInfoAppDgscop = new FormDetalleInfoAppDgscop;
$DetalleInfoAppDgscop     = new DetalleInfoAppDgscop;
$encriptar = new Encriptar;
$opc       = strip_tags($_GET['opc']);
$idDgiDetalleInfoAppDgscop  = strip_tags($encriptar->getDesencriptar($_GET['c'], $_SESSION['usuarioAuditar']));
$rowt      = array();

if ($idDgiDetalleInfoAppDgscop > 0) {
    $rowt = $DetalleInfoAppDgscop->getEditDetalleInfoAppDgscop($idDgiDetalleInfoAppDgscop);
}
$formDetalleInfoAppDgscop->getFormularioDetalleInfoAppDgscop($rowt, $DetalleInfoAppDgscop->getIdCampo(), $opc);
?>

<script type="text/javascript">
$(function() {

    verOpcionPDF($('#filtro').val());

});

function cargaOpcionesUnidad(idDnaUnidadApp) {
    $.post("modulos/detalleInfoAppDgscop/includes/cmbMuestraOpcionUnidad.php", {
            idDnaUnidadApp: idDnaUnidadApp
        },
        function(resultado) {
            document.getElementById("idDnaInfoApp").innerHTML = resultado;

            $("#idDnaInfoAppHija").hide();
            $("#etUnidadHija").hide();

        }
    );
}


function cargaOpcionesUnidadHijas(dna_IdDnaInfoApp) {
    if (dna_IdDnaInfoApp != null) {

        $("#idDnaInfoAppHija").show();
        $("#etUnidadHija").show();

        $.post("modulos/detalleInfoAppDgscop/includes/cmbMuestraOpcionUnidadHijas.php", {
                dna_IdDnaInfoApp: dna_IdDnaInfoApp
            },
            function(resultado) {
                // document.getElementById("idDnaInfoApp").innerHTML = resultado;
                document.getElementById("idDnaInfoAppHija").innerHTML = resultado;
            }
        );
    }
}



function verOpcionPDF(resultado) {
    if (resultado == 'PDF') {
        $('#etAccion').css('display', 'none');
        $('#accion1').css('display', 'none');
        $('#accion1').val('');
        $('[name="imgAlb1"]').prop('disabled', false);
    } else {
        $('#etAccion').css('display', 'block');
        $('#accion1').css('display', 'block');
        $('[name="imgAlb1"]').prop('disabled', true);
    }
}
</script>