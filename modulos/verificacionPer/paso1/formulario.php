<?php
session_start();
header('Content-Type: text/html; charset=UTF-8');
include_once '../../../../clases/autoload.php';
include_once 'config.php';

$formCrearOperativoReci = new FormCrearOperativoReci;
$CrearOperativoReci     = new CrearOperativoReci;
$encriptar              = new Encriptar;
$opc                    = strip_tags($_GET['opc']);
$rowt                   = array();
$idDgoReciElect         = strip_tags($encriptar->getDesencriptar($_GET['c'], $_SESSION['usuarioAuditar']));

if ($idDgoReciElect > 0) {
    $rowt = $CrearOperativoReci->getEditCrearOperativoReci($idDgoReciElect);
}
$formCrearOperativoReci->getFormularioCrearOperativoReci($rowt, $CrearOperativoReci->getIdCampoCrearOperativoReci(), $opc);
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
                    $('#senpladesDescripcion').val(divpol);
                    $('#idGenGeoSenplades').val(result[2]);
                    var id = $('#idDgoProcElec').val();
                    cargaCmbRecintos(result[2], id);
                }
            }
        });
    }

    function buscaConductor() {
        if ($('#cedulaPersonaC').val() == '') {
            Swal.fire(
                'Ingrese un Número de Cédula',
                'Crear Operativo',
                'info'
            )
            limpiarR();
        } else {
            $.ajax({
                type: 'GET',
                url: 'modulos/verificacionPer/includes/buscaCedulaCiu.php',
                data: 'cedula=' + $('#cedulaPersonaC').val(),
                success: function(response) {
                    result = JSON.parse(response);
                    if (result['codeResponse'] > 0) {
                        if (result['msj'] == 'SERVIDOR POLICIAL') {
                            $('#nombrePersonaC').val(result['datos']['apenom']);
                            $('#idGenPersona').val(result['datos']['idGenPersona']);
                        } else {
                            Swal.fire(
                                'Persona No es Servidor Policial',
                                'Crear Operativo',
                                'error'
                            )
                            limpiarR();
                        }
                    } else {
                        Swal.fire(
                            result['msj'],
                            'Crear Operativo',
                            'info'
                        )
                        $('#idGenPersona').val('');
                        $('#nombrePersonaC').val('');
                        $('#cedulaPersonaC').val('');

                    }
                }
            });
        }

    }

    function buscaConductor1() {
        if ($('#cedulaPersonaC').val() == '') {
            $('#nombrePersonaC').val('EL CAMPO CÉDULA NO PUEDE ESTAR EN BLANCO');
            $('#idGenPersona').val('');
            $('#cedulaPersonaC').val('');
        } else {
            var str = $('#cedulaPersonaC').val();
            var n = str.length;
            if (n != 10) {
                Swal.fire(
                    'Ingrese un Número de Cédula',
                    'Crear Orden de Servicio',
                    'info'
                )
                $('#nombrePersonaC').val('LA CEDULA INGRESADA NO ES VALIDA');
                $('#idGenPersona').val('');
                $('#cedulaPersonaC').val('');
            } else {
                $.ajax({
                    type: 'GET',
                    url: 'includes/buscaCedula.php',
                    data: 'usuario=' + $('#cedulaPersonaC').val(),
                    success: function(response) {
                        result = response;
                        if (result[0] > 0) {
                            $('#nombrePersonaC').val(result[1]);
                            $('#idGenPersona').val(result[0]);
                        } else {
                            $('#idGenPersona').val('');
                            $('#nombrePersonaC').val(result[1]);
                            $('#cedulaPersonaC').val('');
                        }
                    }
                });
            }
        }
    }

    function limpiarR() {
        $('#idGenPersona').val('');
        $('#nombrePersonaC').val('');
        $('#cedulaPersonaC').val('');
    }


    function getLatitudLongitud(idDgoReciElect) {
        var idDgoProcElec = $('#idDgoProcElec').val();
        $.post("modulos/verificacionPer/paso1/includes/getLatitudLongitud.php", {
                idDgoReciElect: idDgoReciElect,
                idDgoProcElec: idDgoProcElec
            },
            function(resultado) {
                $posicion = resultado.split("|");
                $('#latitud').val($posicion[0]);
                $('#longitud').val($posicion[1]);
                $('#idDgoComisios').val($posicion[2]);


            }
        );
    }

    function cargaCmbRecintos(idGenGeoSenplaades, idDgoProcElec) {
        $.post("modulos/verificacionPer/includes/cmbMuestraDispositivo.php", {
                idGenGeoSenplaades: idGenGeoSenplaades,
                idDgoProcElec: idDgoProcElec
            },
            function(resultado) {
                document.getElementById("idDgoReciElect").innerHTML = resultado;

            }
        );

    }

    function cargaCmbRecintosPorEje(idDgoTipoEje) {
        var idDgoProcElec = $('#idDgoProcElec').val();
        $.post("modulos/verificacionPer/paso1/includes/cmbUnidadRecinto.php", {
                idDgoTipoEje: idDgoTipoEje,
                idDgoProcElec: idDgoProcElec
            },
            function(resultado) {
                document.getElementById("idDgoReciElect").innerHTML = resultado;

            }
        );

    }

    function cargaCmbEje(idTipoEje1) {
        verificaEje(idTipoEje1);
        $.post("modulos/recintosElectorales/paso1/includes/cmbMuestraEje.php", {
                idTipoEje1: idTipoEje1
            },
            function(resultado) {
                document.getElementById("idDgoTipoEje2").innerHTML = resultado;
                document.getElementById("idDgoTipoEje").innerHTML = 'SELECCIONE';

            }
        );
    }

    function verificaEje(idTipoEje1) {

        if (idTipoEje1 == 1) {
            getVizualizaComponentes();
            cargaCmbRecintos(0);
        } else {
            ocultaComponenetes();
        }
        $.post("modulos/recintosElectorales/paso1/includes/cmbVerificaEje.php", {
                idTipoEje1: idTipoEje1
            },
            function(resultado) {
                if (resultado > 0) {
                    $('#auxiliar').val('');
                    if (idTipoEje1 > 1) {
                        cargaCmbRecintosPorEje(idTipoEje1);
                    }
                    getEjeRecinto(resultado);

                    $('#etUnidad').css('display', 'none');
                    $('#idDgoTipoEje').css('display', 'none');

                } else {
                    if (idTipoEje1 == 1) {
                        getVizualizaComponentes();
                        cargaCmbRecintos(0);
                    } else {
                        ocultaComponenetes();
                    }
                    getEjeRecinto(resultado);
                    getEjeRecinto1(resultado);
                    $('#auxiliar').val(idTipoEje1);


                }
            }
        );
    }


    function cargaCmbEje1(idTipoEje1) {
        verificaEje1(idTipoEje1);
        $.post("modulos/recintosElectorales/paso1/includes/cmbMuestraEje.php", {
                idTipoEje1: idTipoEje1
            },
            function(resultado) {
                document.getElementById("idDgoTipoEje").innerHTML = resultado;

            }
        );
    }

    function verificaEje1(idTipoEje1) {
        $.post("modulos/recintosElectorales/paso1/includes/cmbVerificaEje.php", {
                idTipoEje1: idTipoEje1
            },
            function(resultado) {
                if (resultado > 0) {
                    getEjeRecinto1(resultado);
                    $('#auxiliar').val('');
                } else {

                    $('#etUnidad').css('display', 'none');
                    $('#idDgoTipoEje').css('display', 'none');
                    $('#idDgoTipoEje').val('');
                    cargaCmbRecintosPorEje(idTipoEje1);
                    $('#auxiliar').val(idTipoEje1);
                }
            }
        );
    }

    function getEjeRecinto(resultado) {

        if (resultado > 0) {
            $('#etTipoEje').css('display', 'block');
            $('#idDgoTipoEje2').css('display', 'block');

        } else {
            $('#etTipoEje').css('display', 'none');
            $('#idDgoTipoEje2').css('display', 'none');
            $('#idDgoTipoEje2').val('');
        }
    }

    function getEjeRecinto1(resultado) {

        if (resultado > 0) {
            $('#etUnidad').css('display', 'block');
            $('#idDgoTipoEje').css('display', 'block');

        } else {
            $('#etUnidad').css('display', 'none');
            $('#idDgoTipoEje').css('display', 'none');
            $('#idDgoTipoEje').val('');
        }
    }

    function getSenplades(resultado) {
        if (resultado > 0) {
            $('#etLatitud').css('display', 'block');
            $('#latitud').css('display', 'block');
            $('#etLongitud').css('display', 'block');
            $('#longitud').css('display', 'block');
            $('#etDist').css('display', 'block');
            $('#idGenGeoSenplades').css('display', 'block');
            $('#senpladesDescripcion').css('display', 'block');
            $('#t987').css('display', 'block');

        } else {
            $('#etLatitud').css('display', 'none');
            $('#latitud').css('display', 'none');
            $('#etLongitud').css('display', 'none');
            $('#longitud').css('display', 'none');
            $('#etDist').css('display', 'none');
            $('#idGenGeoSenplades').css('display', 'none');
            $('#senpladesDescripcion').css('display', 'none');
            $('#t987').css('display', 'none');


        }
    }

    function getVizualizaComponentes() {

        $('#etLatitud').css('display', 'block');
        $('#latitud').css('display', 'block');
        $('#etLongitud').css('display', 'block');
        $('#longitud').css('display', 'block');
        $('#etDist').css('display', 'block');
        $('#idGenGeoSenplades').css('display', 'block');
        $('#senpladesDescripcion').css('display', 'block');
        $('#t987').css('display', 'block');
    }

    function ocultaComponenetes() {

        $('#etLatitud').css('display', 'none');
        $('#latitud').css('display', 'none');
        $('#etLongitud').css('display', 'none');
        $('#longitud').css('display', 'none');
        $('#etDist').css('display', 'none');
        $('#idGenGeoSenplades').css('display', 'none');
        $('#senpladesDescripcion').css('display', 'none');
        $('#t987').css('display', 'none');
        $('#latitud').val('');
        $('#longitud').val('');
        $('#idGenGeoSenplades').val('');
        $('#senpladesDescripcion').val('');
        cargaCmbRecintos(0);

    }


    function verificaEstado(idDgoCreaOpReci) {
        $('#finalizado').val('');
        $.post("modulos/verificacionPer/paso1/includes/verificaFinalizado.php", {
                idDgoCreaOpReci: idDgoCreaOpReci
            },
            function(resultado) {
                if (resultado > 0) {
                    $('#finalizado').val(resultado);
                } else {
                    $('#finalizado').val(0);
                }


            }
        );
    }
</script>
<script type="text/javascript">
    $(function() {
        verificaEstado($('#idDgoCreaOpReci').val());

        $('#idJefe').val($('#idDgoCreaOpReci').val());
        $('#est').val($('#estado').val());
        $('#idDgoProcE').val($('#idDgoProcElec').val());
        var id = $('#idDgoTipoEje').val();
        var id1 = $('#idDgoTipoEje1').val();
        var id2 = $('#idDgoTipoEje2').val();

        getSenplades($('#idDgoTipoEje1').val());
        getEjeRecinto($('#idDgoTipoEje2').val());
        getEjeRecinto1($('#idDgoTipoEje').val());
        if (id2 == '') {
            $('#etTipoEje').css('display', 'block');
            $('#idDgoTipoEje2').css('display', 'block');
            $('#idDgoTipoEje2').val(id);
            $('#auxiliar').val(id);
            $('#etUnidad').css('display', 'none');
            $('#idDgoTipoEje').css('display', 'none');
            $('#idDgoTipoEje').val('');
        }
        if ((id == '') && (id1 != '') && (id2 == '')) {

            $('#idDgoTipoEje1').val(id1);
            $('#auxiliar').val(id1);

            $('#etTipoEje').css('display', 'none');
            $('#idDgoTipoEje2').css('display', 'none');
            $('#idDgoTipoEje2').val('');

            $('#etUnidad').css('display', 'none');
            $('#idDgoTipoEje').css('display', 'none');
            $('#idDgoTipoEje').val('');
        }
        if ((id == '') && (id1 == '') && (id2 == '')) {

            $('#etTipoEje').css('display', 'none');
            $('#idDgoTipoEje2').css('display', 'none');
            $('#idDgoTipoEje2').val('');

            $('#etUnidad').css('display', 'none');
            $('#idDgoTipoEje').css('display', 'none');
            $('#idDgoTipoEje').val('');
            $('#auxiliar').val('');
        }

        $('#lat').val($('#latitud').val());
        $('#long').val($('#longitud').val());
        $('#idRElec').val($('#idRecintoElec').val());


    });
</script>