<?php
session_start();
include_once '../../../../clases/autoload.php';
$formDgoInfOrdenServicio = new FormDgoInfOrdenServicio;
$DgoInfOrdenServicio     = new DgoInfOrdenServicio;
$ambitoGestionOrden     = new AmbitoGestionOrden;
$encriptar       = new Encriptar;
$dt              = new DateTime('now', new DateTimeZone('America/Guayaquil'));
$fechaHoy        = $dt->format('Y-m-d');
$anio = explode("-", $fechaHoy);
$anioHoy = $anio[0];
$datosUsuario =    $ambitoGestionOrden->getDatosUsuariosSenplades($_SESSION['usuarioAuditar']);
$idGenGeoSenplades = $datosUsuario['idGenGeoSenplades'];
$idGenPersona = $datosUsuario['idGenPersona'];
$siglasDistrito = $datosUsuario['siglasD'];
$spElabora = $datosUsuario['spElabora'];
$opc                  = strip_tags($_GET['opc']);
$idDgoInfOrdenServicio     = strip_tags($encriptar->getDesencriptar($_GET['c'], $_SESSION['usuarioAuditar']));
$rowt                 = array();
if ($idDgoInfOrdenServicio > 0) {
    $rowt = $DgoInfOrdenServicio->getEditDgoInfOrdenServicio($idDgoInfOrdenServicio);
}
$formDgoInfOrdenServicio->getFormularioDgoInfOrdenServicio($rowt, $DgoInfOrdenServicio->getIdCampo(), $opc);
?>
<script>
    function imprimir(idDgoOrden) {
        var idDgoInfOrdenServicio = idDgoOrden;
        var url = "modulos/evaluarOrden/paso1/includes/fratListEjemplares.php?id=" + idDgoInfOrdenServicio;
        var l = screen.width;
        var t = screen.height;
        var opts = 'scrollbars=yes,toolbar=no,width=' + screen.width + ',height=' + screen.height + ',top=' + t + ' ,left=' + l;
        var name = 'pdf';
        window.open(url, name, opts);

    }

    function validate_hora(hora) {
        if (hora != undefined && hora.value != "") {
            if (!/^[0-9]{2}:[0-9]{2}$/.test(hora.value)) {
                alert("formato de Hora no valido (hh:mm)");
                return false;
            }
            var horas = parseInt(hora.value.substring(0, 2), 10);
            var minus = parseInt(hora.value.substring(3, 5), 10);
            if (horas > 23 || minus > 59) {
                alert("Hora introducida erronea");
                return false;
            }
            return true;
        } else {
            alert("Hora introducida erronea");
            return false;
        }
    }

    function getFormatoHora() {
        $("#horaInforme").mask("99:99");

    }
    $(function() {
        getFormatoHora();
        $('#cedulaPersonaR').keypress(function(e) {
            if (e.which == 13) {
                buscaResponsableInforme(false);
            }
        });
        $('#cedulaPersonaComandante').keypress(function(e) {
            if (e.which == 13) {
                buscaComandante(false);
            }
        });
    });


    function buscaResponsableInforme() {
        if ($('#cedulaPersonaR').val() == '') {
            Swal.fire(
                'Ingrese un Número de Cédula',
                'Evaluar Orden de Servicio',
                'info'
            )
            limpiarResponsable();
        } else {
            $.ajax({
                type: 'GET',
                url: 'modulos/evaluarOrden/paso1/includes/buscaCedulaCiu.php',
                data: 'cedula=' + $('#cedulaPersonaR').val(),
                success: function(response) {
                    result = JSON.parse(response);
                    if (result['codeResponse'] > 0) {
                        if (result['msj'] == 'SERVIDOR POLICIAL') {
                            $('#idGenPersonaResponsable').val(result['datos']['idGenPersona']);
                            $('#nombrePersonaR').val(result['datos']['apenom']);
                            $('#responsableInforme').val(result['datos']['apenom']);
                        } else {
                            Swal.fire(
                                'Persona No es Servidor Policial',
                                'Evaluar Orden de Servicio',
                                'error'
                            )
                            limpiarResponsable();
                        }
                    } else {
                        Swal.fire(
                            result['msj'],
                            'Evaluar Orden de Servicio',
                            'info'
                        )
                        limpiarResponsable();
                    }
                }
            });
        }

    }

    function limpiarResponsable() {
        $('#idGenPersonaResponsable').val('');
        $('#nombrePersonaR').val('');
        $('#cedulaPersonaR').val('');
        $('#responsableInforme').val('');
    }

    function limpiarComandante() {
        $('#idGenPersonaComandante').val('');
        $('#nombrePersonaComandante').val('');
        $('#cedulaPersonaComandante').val('');
        $('#comandanteUnidad').val('');
    }

    function buscaComandante() {
        if ($('#cedulaPersonaComandante').val() == '') {
            Swal.fire(
                'Ingrese un Número de Cédula',
                'Evaluar Orden de Servicio',
                'info'
            )
            limpiarComandante();
        } else {
            $.ajax({
                type: 'GET',
                url: 'modulos/evaluarOrden/paso1/includes/buscaCedulaCiu.php',
                data: 'cedula=' + $('#cedulaPersonaComandante').val(),
                success: function(response) {
                    result = JSON.parse(response);
                    if (result['codeResponse'] > 0) {
                        if (result['msj'] == 'SERVIDOR POLICIAL') {
                            $('#idGenPersonaComandante').val(result['datos']['idGenPersona']);
                            $('#nombrePersonaComandante').val(result['datos']['apenom']);
                            $('#comandanteUnidad').val(result['datos']['apenom'])
                        } else {
                            Swal.fire(
                                'Persona No es Servidor Policial',
                                'Evaluar Orden de Servicio',
                                'error'
                            )
                            limpiarComandante();
                        }


                    } else {
                        Swal.fire(
                            result['msj'],
                            'Evaluar Orden de Servicio',
                            'info'
                        )
                        limpiarComandante();
                    }
                }
            });
        }

    }
</script>

<script type="text/javascript">
    $(function() {
        $('#idOrden').val($('#idDgoInfOrdenServicio').val());

    });
</script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#idGenGeoSenplades').val(<?php echo $idGenGeoSenplades ?>);
        $('#idGenPersonaElabora').val(<?php echo $idGenPersona ?>);
        $('#nombreElabora').val("<?php echo $spElabora ?>");
        $('#siglasDistrito').val("<?php echo $siglasDistrito ?>");
        $('#anio').val("<?php echo $anioHoy ?>");
        $('#fechaH').val(<?php echo "'" . $fechaHoy . "'" ?>);
    });
</script>