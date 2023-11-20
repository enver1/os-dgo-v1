<?php
session_start();
include_once '../../../../../clases/autoload.php';
$FormDgoTalentoHumano = new FormDgoTalentoHumano;
$dgoTalentoHumanoOrden     = new DgoTalentoHumanoOrden;
$encriptar       = new Encriptar;
$opc                  = strip_tags($_GET['opc']);
$idDgoTalentoHumanoOrden     = strip_tags($encriptar->getDesencriptar($_GET['c'], $_SESSION['usuarioAuditar']));
$rowt                 = array();
if ($idDgoTalentoHumanoOrden > 0) {
    $rowt = $dgoTalentoHumanoOrden->getEditDgoTalentoHumanoOrden($idDgoTalentoHumanoOrden);
}
$FormDgoTalentoHumano->getFormularioDgoTalentoHumano($rowt, $dgoTalentoHumanoOrden->getIdCampo(), $opc);
?>
<script type="text/javascript">
    $(function() {
        $('#idDgoOrdenServicio').val($('#idOrden').val());
    });
    $('#cedulaPersona').keypress(function(e) {
        if (e.which == 13) {
            buscaPolicia(false);
        }
    });

    function buscaPolicia() {
        if ($('#cedulaPersona').val() == '') {
            Swal.fire(
                'Ingrese un Número de Cédula',
                'Crear Orden de Servicio',
                'info'
            )
            limpiarJefe();
        } else {
            $.ajax({
                type: 'GET',
                url: 'modulos/crearOrden/paso1/includes/buscaCedulaCiu.php',
                data: 'cedula=' + $('#cedulaPersona').val(),
                success: function(response) {
                    result = JSON.parse(response);
                    if (result['codeResponse'] > 0) {
                        if (result['msj'] == 'SERVIDOR POLICIAL') {
                            $('#idGenPersona').val(result['datos']['idGenPersona']);
                            $('#nombrePersona').val(result['datos']['apenom']);
                            $('#idDgpGrado').val(result['datos']['idDgpGrado']);
                            $('#idDgpUnidad').val(result['datos']['idDgpUnidad']);
                            $('#unidad').val(result['datos']['unidad']);
                            $('#funcion').val(result['datos']['funcion']);

                        } else {
                            Swal.fire(
                                'Persona No es Servidor Policial',
                                'Crear Orden de Servicio',
                                'error'
                            )
                            limpiarJefe();
                        }
                    } else {
                        Swal.fire(
                            result['msj'],
                            'Crear Orden de Servicio',
                            'info'
                        )
                        limpiarJefe();
                    }
                }
            });
        }

    }

    function limpiar() {
        $('#idGenPersona').val('');
        $('#nombrePersona').val('');
        $('#cedulaPersona').val('');
        $('#idDgpGrado').val('');
        $('#idDgpUnidad').val('');
        $('#unidad').val('');
        $('#funcion').val('');
    }
</script>