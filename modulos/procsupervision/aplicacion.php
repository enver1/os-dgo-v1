<?php
if (isset($_SESSION['usuarioAuditar'])) {
    include_once('../clases/autoload.php');
    include_once('../funciones/funcion_select.php');
    include_once('../funciones/funciones_generales.php');
    $conn = DB::getConexionDB();
?>
    <script type="text/javascript" src="../js/jquery.easyui.min.js"></script>
    <script type="text/javascript" src="../../../js/sha1.js"></script>
    <script type="text/javascript">
        <?php    /* Llama a la funcion el momento de la carga de la hoja ONLOAD*/ ?>
        /*Funcion carga los tipos de sancion segun la clase*/
        function muestraEjes() {
            var u = $('#idDgoActUnidad').val();
            if (u != "") {
                var targetURL = 'modulos/procsupervision/ejes.php?codigo=' + u;
                $('#muestra-ejes').html('<p><img src="../../../funciones/paginacion/images/ajax-loader.gif" /></p>');
                $('#muestra-ejes').load(targetURL).hide().fadeIn('slow');
            }
        }

        function muestraDatos() {
            getdata(0);
        }

        function getdata(c) {
            var a = $('#idDgoEjeProcSu').val();
            var b = $('#idDgoActUnidad').val();
            var vst = $('#idDgoVisita').val();

            var urleje = 'modulos/procsupervision/detalleEje.php?a=' + a;
            $('#detalleEje').html('<p><img src="../funciones/paginacion/images/ajax-loader.gif" /></p>');
            $('#detalleEje').load(urleje);

            var urlt = 'modulos/procsupervision/grid.php?a=' + a + '&b=' + b + '&vst=' + vst;
            $('#formulario').html('<p><img src="../funciones/paginacion/images/ajax-loader.gif" /></p>');
            $('#formulario').load(urlt);
            $("html, body").animate({
                scrollTop: 0
            }, "slow");

        }

        function getPregunta(d, c) {
            var a = $('#idDgoProcSuper').val();
            var urlt = 'modulos/configActividad/grid.php?opc=' + a + '&c=' + c + '&preg=' + d;
            $('#formulario').html('<p><img src="../funciones/paginacion/images/ajax-loader.gif" /></p>');
            $('#formulario').load(urlt);
            $("html, body").animate({
                scrollTop: 0
            }, "slow");

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

        function abrirVntParticipantes() {

            var u = $('#idDgoActUnidad').val();
            var eje = $('#idDgoEjeProcSu').val();
            var vst = $('#idDgoVisita').val();

            if (eje != '' && u != '') {
                var urlParticipantes = '../../operaciones/modulos/procsupervision/participantes/aplicacion.php?vst=' + vst +
                    '&eje=' + eje;
                return GB_showPage('PARTICIPANTES', urlParticipantes);
            } else {
                alert('DEBE SELECCIONAR UNA UNIDAD Y UN EJE');
            }

        }
    </script>
    <div id="proceso">
        <table width="100%">
            <tr>
                <td class="etiqueta">Unidad:</td>
                <td>
                    <?php
                    $sqlU = "SELECT
										c.idDgoActUnidad ,d.nomenclatura descripcion
									FROM
										dgoVisita a,
										v_usuario b,
										dgoActUnidad c,
										dgpUnidad d,
										dgoProcSuper e
									WHERE
										a.idGenPersona = b.idGenPersona
									AND a.idDgoActUnidad=c.idDgoActUnidad
									AND c.idDgpUnidad=d.idDgpUnidad 
									AND c.idDgoProcSuper=e.idDgoProcSuper AND e.idGenEstado=1 
									AND b.idGenUsuario = '" . $_SESSION['usuarioAuditar'] . "'";
                    generaComboSimpleSQL(
                        $conn,
                        'dgoActUnidad',
                        'idDgoActUnidad',
                        'descripcion',
                        '',
                        $sqlU,
                        'onchange="muestraEjes()"',
                        'width:250px'
                    );
                    ?>
                </td>
                <td>





                </td>
            </tr>









            <tr>
                <td class="etiqueta">Eje:</td>
                <td>
                    <span class="titulows" id="muestra-ejes" title="">
                        <select disabled="disabled" name="idDgoEjeProcSu" id="idDgoEjeProcSu" class="inputSombra" style="width:250px">
                            <option value="0">Selecciona opci&oacute;n...</option>
                        </select>
                    </span>
                </td>
                <!--<td><a href="modulos/procsupervision/participantes/aplicacion.php" class="button" onclick="return GB_showPage('PARTICIPANTES', this.href)"><span>Participantes</span></a></td>-->
                </td>
                <td><a href=# id="parti" class="button" onClick="abrirVntParticipantes()"><span>Participantes</span></a>
                </td>
            </tr>
        </table>
    </div>
    <div id='detalleEje'>
    </div>
    <div id='formulario'>
    </div>


















<?php




} else
    header('Location: imprime.php');
?>