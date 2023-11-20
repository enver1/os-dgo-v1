<?php
session_start();
include_once '../../../clases/autoload.php';

$formRegistroAspectoAppCg  = new FormRegistroAspectoAppCg;
$RegistroAspectoAppCg      = new RegistroAspectoAppCg;
$encriptar       = new Encriptar;
$opc             = strip_tags($_GET['opc']);
$idDgiRegistroAspectoAppCg = strip_tags($encriptar->getDesencriptar($_GET['c'], $_SESSION['usuarioAuditar']));
$rowt            = array();
$dt              = new DateTime('now', new DateTimeZone('America/Guayaquil'));
$verificaUsuario        = $RegistroAspectoAppCg->getVerificaUsuarioAppCg($_SESSION['usuarioAuditar']);

$idGenPersonaJefe = $verificaUsuario['idGenPersonaJefe'];
$idCgAmbitoGestionAppCg = $verificaUsuario['idCgAmbitoGestionAppCg'];
$idDgpGradoSanciona = $verificaUsuario['siglas'];
$fechaHoy = $dt->format('Y-m-d h:i:s');
if ($idDgiRegistroAspectoAppCg > 0) {
    $rowt = $RegistroAspectoAppCg->getEditRegistroAspectoAppCg($idDgiRegistroAspectoAppCg);
}
$formRegistroAspectoAppCg->getFormularioRegistroAspectoAppCg($rowt, $RegistroAspectoAppCg->getIdCampo(), $opc);
?>
<script>
    $(function() {
        $('#fechaRegistro').val('<?php echo $fechaHoy ?>');

        $('#idCgAmbitoGestionAppCg').val('<?php echo $idCgAmbitoGestionAppCg ?>');
        $('#idGenPersonaJefe').val('<?php echo $idGenPersonaJefe ?>');
        $('#idDgpGradoSanciona').val('<?php echo $idDgpGradoSanciona ?>');
    });
    $("#cedulaPersona").keypress(function(e) {
        if (e.which == 13) {
            document.getElementById("bidGenPersona").click()
            buscaPolicia();
        }
    });

    $('#cedulaPersona').on('input', function() {
        this.value = this.value.replace(/[^0-9]/g, '');
        if (this.value.length > 10) this.value = this.value.slice(0, 10);

    });
    $("#cedulaPersonaJefe").keypress(function(e) {
        if (e.which == 13) {
            document.getElementById("bidGenPersonaJefe").click()
            buscaJefe();
        }
    });

    $('#cedulaPersonaJefe').on('input', function() {
        this.value = this.value.replace(/[^0-9]/g, '');
        if (this.value.length > 10) this.value = this.value.slice(0, 10);

    });


    function buscaJefe() {
        if ($('#cedulaPersonaJefe').val() == '') {
            Swal.fire(
                'Ingrese un Número de Cédula',
                'Registro Aspectos',
                'info'
            )
            limpiarJefe();
        } else {
            $.ajax({
                type: 'GET',
                url: 'modulos/registroAppCg/includes/buscaCedulaCiu.php',
                data: 'cedula=' + $('#cedulaPersonaJefe').val(),
                success: function(response) {
                    result = JSON.parse(response);
                    if (result['codeResponse'] > 0) {
                        if (result['msj'] == 'SERVIDOR POLICIAL') {
                            if (result['datos']['idCgAmbitoGestionAppCg'] > 0) {
                                $('#idGenPersonaJefe').val(result['datos']['idGenPersona']);
                                $('#nombrePersonaJefe').val(result['datos']['apenom']);
                                $('#idCgAmbitoGestionAppCg').val(result['datos']['idCgAmbitoGestionAppCg']);
                                $('#idDgpGradoSanciona').val(result['datos']['idDgpGrado']);

                            } else {
                                Swal.fire(
                                    'El Servidor Polcial No esta registrado en la APP',
                                    'Registro Aspectos',
                                    'error'
                                )
                                limpiarJefe();
                            }

                        } else {
                            Swal.fire(
                                'La Persona no es Servidor Polcial',
                                'Registro Aspectos',
                                'error'
                            )
                            limpiarJefe();
                        }
                    } else {
                        Swal.fire(
                            result['msj'],
                            'Registro Aspectos',
                            'info'
                        )
                        limpiarJefe();
                    }
                }
            });
        }

    }

    function buscaPolicia() {
        if ($('#cedulaPersona').val() == '') {
            Swal.fire(
                'Ingrese un Número de Cédula',
                'Registro Aspectos',
                'info'
            )
            limpiarJefe();
        } else {
            $.ajax({
                type: 'GET',
                url: 'modulos/registroAppCg/includes/buscaCedulaCiu.php',
                data: 'cedula=' + $('#cedulaPersona').val(),
                success: function(response) {
                    result = JSON.parse(response);
                    if (result['codeResponse'] > 0) {
                        if (result['msj'] == 'SERVIDOR POLICIAL') {
                            $('#idGenPersona').val(result['datos']['idGenPersona']);
                            $('#nombrePersona').val(result['datos']['apenom']);
                            $('#idDgpGrado').val(result['datos']['idDgpGrado']);
                        } else {
                            Swal.fire(
                                'La Persona no es Servidor Polcial',
                                'Registro Aspectos',
                                'error'
                            )
                            limpiar();
                        }
                    } else {
                        Swal.fire(
                            result['msj'],
                            'Registro Aspectos',
                            'info'
                        )
                        limpiar();
                    }
                }
            });
        }

    }

    function limpiarJefe() {
        $('#idGenPersonaJefe').val('');
        $('#nombrePersonaJefe').val('');
        $('#cedulaPersonaJefe').val('');
        $('#idCgAmbitoGestionAppCg').val('');
        $('#idDgpGradoSanciona').val('');
    }

    function limpiar() {
        $('#idGenPersona').val('');
        $('#nombrePersona').val('');
        $('#cedulaPersona').val('');
        $('#idDgpGrado').val('');
    }

    function cargaCmbAspectos(idCgTipoAspecto) {
        $.post("modulos/registroAppCg/includes/cargaCmbAspectos.php", {
                idCgTipoAspecto: idCgTipoAspecto
            },
            function(resultado) {
                document.getElementById("idCgTipoAspecto1").innerHTML = resultado;
            }
        );
    }

    function cargaCmbDetalleAspectos(idCgTipoAspecto) {
        $.post("modulos/registroAppCg/includes/cargaCmbDetalleAspectos.php", {
                idCgTipoAspecto: idCgTipoAspecto
            },
            function(resultado) {
                document.getElementById("idCgTipoAspecto").innerHTML = resultado;
            }
        );
    }
</script>