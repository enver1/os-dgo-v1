<?php
if (isset($_SESSION['usuarioAuditar'])) {
    include_once('../clases/autoload.php');
    include_once('../funciones/funcion_select.php');
    include_once('../funciones/funciones_generales.php');
    $conn = DB::getConexionDB();
?>
    <script type="text/javascript" src="../js/jquery-3.5.1.min.js"></script>
    <script type="text/javascript" src="../js/jquery.easyui.min.js"></script>
    <script type="text/javascript">
        <?php    /* Llama a la funcion el momento de la carga de la hoja ONLOAD*/ ?>

        function muestraDatos() {
            getdata(0, 1);
        }

        function getdata(c, x) {
            var a = $('#idDgoProcSuper').val();
            var urlt = 'modulos/configActividad/grid.php?opc=' + a + '&c=' + c;
            $('#formulario').html('<p><img src="../funciones/paginacion/images/ajax-loader.gif" /></p>');
            $('#formulario').load(urlt);
            //	alert(x);
            setTimeout(function() {
                $('html, body').animate({
                    scrollTop: $('#goTo' + x).offset().top
                }, "slow")
            }, 500);
            //$("html, body").animate({ scrollTop: 0 }, "slow");

        }

        function getPregunta(d, c, x) {
            var a = $('#idDgoProcSuper').val();
            var urlt = 'modulos/configActividad/grid.php?opc=' + a + '&c=' + c + '&preg=' + d;
            $('#formulario').html('<p><img src="../funciones/paginacion/images/ajax-loader.gif" /></p>');
            $('#formulario').load(urlt);
            // 	$("html, body").animate({ scrollTop: 0 }, "slow");
            setTimeout(function() {
                $('html, body').animate({
                    scrollTop: $('#goTo' + x).offset().top
                }, "slow")
            }, 500);

        }

        function delPrueba(c) {
            var a = $('#idDgoProcSuper').val();
            si = confirm('Eliminar la Prueba');
            if (si == true) {
                $.ajax({
                    type: "POST",
                    url: "modulos/configActividad/actividad/borra.php",
                    data: "id=" + c,

                    success: function(response) {
                        result = response;
                        if (result.trim() != '') {
                            alert(result);
                        }
                        var urlt = 'modulos/configActividad/grid.php?opc=' + a + '&c=0';
                        $('#formulario').load(urlt);
                    }
                });
            }
        }

        function delPregunta(c, d) {
            var a = $('#idDgoProcSuper').val();
            si = confirm('Eliminar la Pregunta');
            if (si == true) {
                $.ajax({
                    type: "POST",
                    url: "modulos/configActividad/instruccion/borra.php",
                    data: "id=" + c,
                    success: function(response) {
                        result = response;
                        if (result.trim() != '') {
                            alert(result);
                        }
                        var urlt = 'modulos/configActividad/grid.php?opc=' + a + '&c=' + d;
                        $('#formulario').load(urlt);
                    }
                });
            }
        }

        function delRespuesta(c, d, e) {
            var a = $('#idDgoProcSuper').val();
            si = confirm('Eliminar la Respuesta');
            if (si == true) {
                $.ajax({
                    type: "POST",
                    url: "modulos/configActividad/respuestas/borra.php",
                    data: "id=" + c,

                    success: function(response) {
                        result = response;
                        if (result.trim() != '') {
                            alert(result);
                        }
                        var urlt = 'modulos/configActividad/grid.php?opc=' + a + '&c=' + d + '&preg=' + e;
                        $('#formulario').load(urlt);
                    }
                });
            }
        }
    </script>
    <div id="proceso">
        <table width="100%">
            <tr>
                <td class="etiqueta">Proceso de supervision</td>
                <td>
                    <?php
                    generaComboSimpleSQL(
                        $conn,
                        'dgoProcSuper',
                        'idDgoProcSuper',
                        'descripcion',
                        '',
                        'select idDgoProcSuper,descripcion from dgoProcSuper order by fechaInicio desc',
                        'onchange="muestraDatos()"',
                        'width:250px'
                    );
                    ?>
                </td>
            </tr>
        </table>
    </div>
    <div id='formulario'>
    </div>
<?php
} else
    header('Location: imprime.php');
?>