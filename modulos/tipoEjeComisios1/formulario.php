<?php
session_start();
header('Content-Type: text/html; charset=UTF-8');
include_once '../../../clases/autoload.php';
include_once 'config.php';

$formTipoEjeComisios = new FormTipoEjeComisios;
$TipoEjeComisios     = new TipoEjeComisios;
$encriptar           = new Encriptar;
$opc                 = strip_tags($_GET['opc']);
$rowt                = array();
$idDgoTipoEje        = strip_tags($encriptar->getDesencriptar($_GET['c'], $_SESSION['usuarioAuditar']));

if ($idDgoTipoEje > 0) {
    $rowt = $TipoEjeComisios->getEditTipoEjeComisios($idDgoTipoEje);
}
$formTipoEjeComisios->getFormularioTipoEjeComisios($rowt, $TipoEjeComisios->getIdCampo(), $opc);
?>


<script>
    function buscaDatos(idDgoTipoEje) {

        $.ajax({
            type: 'GET',
            url: 'modulos/tipoEjeComisios/includes/buscaMedioTecnico.php',
            data: 'idDgoTipoEje=' + idDgoTipoEje,
            success: function(response) {
                result = response;
                if (result[0] = 1) {
                    $('#idPadre').val(result[1]);
                } else {
                    alert(result[1]);
                }
            }
        });
    }


    function cargaCmbEje(idTipoEje1, id) {
        $.post("modulos/tipoEjeComisios/includes/cmbMuestraEje.php", {
                idTipoEje1: idTipoEje1
            },
            function(resultado) {
                document.getElementById("idDgoTipoEje2").innerHTML = resultado;

                if (resultado == 0) {
                    $('#etTipoEje').css('display', 'none');
                    $('#idDgoTipoEje2').css('display', 'none');
                    $('#idDgoTipoEje2').val('');
                    $('#auxiliar').val('');
                    $('#idPadre').val(idTipoEje1);
                } else {
                    $('#etTipoEje').css('display', 'block');
                    $('#idDgoTipoEje2').css('display', 'block');
                    $('#auxiliar').val(idTipoEje1);
                    if (id > 0) {
                        $('#idDgoTipoEje2').val(id);
                    }
                    buscaDatos(idTipoEje1);





                }

            }
        );
    }
</script>
<script type="text/javascript">
    $(function() {
        var id = $('#idDgoTipoEje').val();
        var idT1 = $('#idPadre').val();
        var idT2 = $('#abuelito').val();

        if ((id == "" && idT1 == "" && idT2 == "")) {
            $('#etTipoEje').css('display', 'none');
            $('#idDgoTipoEje2').css('display', 'none');
        } else if ((id > 0 && idT1 == "" && idT2 == "")) {
            $('#etTipoEje').css('display', 'none');
            $('#idDgoTipoEje2').css('display', 'none');
        } else if ((id > 0 && idT1 > 0 && idT2 == "")) {
            $('#etTipoEje').css('display', 'none');
            $('#idDgoTipoEje2').css('display', 'none');

        } else if ((id > 0 && idT1 > 0 && idT2 > 0)) {

            $('#etTipoEje').css('display', 'block');
            $('#idDgoTipoEje2').css('display', 'block');
            $('#aux').val(idT2);
            cargaCmbEje(idT2, idT1);

        }
    });
</script>