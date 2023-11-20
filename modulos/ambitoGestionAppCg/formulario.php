<?php
session_start();
include_once '../../../clases/autoload.php';
$formAmbitoGestionAppCg = new FormAmbitoGestionAppCg;
$AmbitoGestionAppCg         = new AmbitoGestionAppCg;
$encriptar            = new Encriptar;
$opc                  = strip_tags($_GET['opc']);
$idDgoAmbitoGestionAppCg     = strip_tags($encriptar->getDesencriptar($_GET['c'], $_SESSION['usuarioAuditar']));
$rowt                 = array();
if ($idDgoAmbitoGestionAppCg > 0) {
    $rowt = $AmbitoGestionAppCg->getEditAmbitoGestionAppCg($idDgoAmbitoGestionAppCg);
}
$formAmbitoGestionAppCg->getFormularioAmbitoGestionAppCg($rowt, $AmbitoGestionAppCg->getIdCampo(), $opc);
?>
<script>
    $(function() {
        $('#cedulaPersona').keypress(function(e) {
            if (e.which == 13) {
                buscaPersona(false);
            }
        });
    });

    function buscaPersona() {
        if ($('#cedulaPersona').val() == '') {
            Swal.fire(
                'Ingrese un Número de Cédula',
                'Ambito de Gestión Orden',
                'info'
            )
            limpiarR();
        } else {
            $.ajax({
                type: 'GET',
                url: 'modulos/ambitoGestionAppCg/includes/buscaCedulaCiu.php',
                data: 'cedula=' + $('#cedulaPersona').val(),
                success: function(response) {
                    result = JSON.parse(response);
                    if (result['codeResponse'] > 0) {
                        if (result['msj'] == 'SERVIDOR POLICIAL') {
                            $('#idGenPersona').val(result['datos']['idGenPersona']);
                            $('#nombrePersona').val(result['datos']['apenom']);
                            $('#usuario').val(result['datos']['idGenUsuario']);
                        } else {
                            Swal.fire(
                                'Persona No es Servidor Policial',
                                'Ambito de Gestión Orden',
                                'error'
                            )
                            limpiarR();
                        }

                    } else {
                        Swal.fire(
                            result['msj'],
                            'Ambito de Gestión Orden',
                            'info'
                        )
                        limpiarR();
                    }
                }
            });
        }

    }

    function limpiarR() {
        $('#idGenPersona').val('');
        $('#idGenUsuario').val('');
        $('#nombrePersona').val('');
        $('#cedulaPersona').val('');
    }
</script>