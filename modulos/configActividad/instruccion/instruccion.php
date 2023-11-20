<?php
session_start();
include '../../../../clases/autoload.php';
$conn = DB::getConexionDB();
include_once('../../../../funciones/funcion_select.php');
include_once('../../../../funciones/funciones_generales.php');
include_once('validacion.php');
$idcampo = 'idDgoInstrucci';
$formulario = array(
    /*2=>array(
	'tipo'=>'comboSQL',
	'etiqueta'=>'Tipo Pregunta',
	'tabla'=>'genEncTPregu',
	'campoTabla'=>'idGenEncTPregu',
	'ancho'=>'300',
	'sql'=>'select idGenEncTPregu,descripcion from genEncTPregu order by 1',
	'soloLectura'=>'false',
	'onclick'=>''),*/
    3 => array(
        'tipo' => 'textArea',
        'etiqueta' => 'Descripcion',
        'campoTabla' => 'descDgoInstrucci',
        'maxChar' => '400',
        'ancho' => '500',
        'alto' => '100',
        'soloLectura' => 'false'
    ),
);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <title>Instrucciones</title>
    <meta http-equiv="Content-Type" content="text/html;charset=iso-8859-1" />
    <link rel="stylesheet" href="../../../../css/siipne3.css" type="text/css" media="screen" />
    <?php

    $dt = new DateTime('now', new DateTimeZone('America/Guayaquil'));
    $fechaHoy = $dt->format('Y-m-d');
    $idcampo = 'idDgoInstrucci';
    $Ntabla = 'dgoInstrucci';
    $sql = "select idDgoProcSuper,descDgoActividad from dgoActividad a,dgoEjeProcSu b where a.idDgoEjeProcSu=b.idDgoEjeProcSu and a.idDgoActividad='" . $_GET['prue'] . "'";
    $rs = $conn->query($sql);
    $procs = NULL;
    $acti = '';
    //echo $sql;
    if ($rowQ = $rs->fetch()) {
        $procs = $rowQ['idDgoProcSuper'];
        $acti = $rowQ['descDgoActividad'];
    }
    /*-------------------------------------------------*/
    if (isset($_GET['cod'])) {
        $sql = "select a.* from " . $Ntabla . " a where " . $idcampo . "='" . $_GET['cod'] . "'";
        $rs = $conn->query($sql);
        $rowt = $rs->fetch(PDO::FETCH_ASSOC);
    }
    /* ==== Aqui se incluye el formulario de edicion */
    ?>
    <script type="text/javascript" src="../../../../js/jquery-3.5.1.min.js"></script>
    <script type="text/javascript" src="../../../../js/validaciones.js"></script>

    <script>
        function max(txarea, longo, id) {
            total = longo;
            tam = txarea.value.length;
            str = "";
            str = str + tam;
            document.getElementById('Dig' + id).innerHTML = str;
            document.getElementById('Res' + id).innerHTML = total - str;
            if (tam > total) {
                aux = txarea.value;
                txarea.value = aux.substring(0, total);
                document.getElementById('Dig' + id).innerHTML = totaldocument.getElementById('Res' + id).innerHTML = 0
            }
        }

        function grabaregistro(c, d) {

            /* Aqui campos del formulario */
            var $inputs = $('#edita :input');
            var values = {};
            $inputs.each(function() {
                if (this.type == 'checkbox') {
                    values[this.name] = (this.checked ? "1" : "0");
                } else {
                    values[this.name] = $(this).val();
                }
            });

            var id = values[d];
            if (c == '2' && !(id == "" || id == "0" || typeof(id) == 'undefined')) {
                alert('No tiene permisos para Modificar Registros');
                return;
            }
            if (c == '3' && (id == "" || id == "0" || typeof(id) == 'undefined')) {
                alert('No tiene permisos para Insertar Nuevos Registros');
                return
            }
            /*    */
            if (validate(document.getElementById("edita"))) {

                var result = '';
                var $forma = $('html,body');
                $.ajax({
                    type: "POST",
                    url: "graba.php",
                    data: values,
                    //  async: false,
                    success: function(response) {
                        result = response;
                        if (result.trim() != '')
                            alert(result);
                        else {
                            var urlt = '../grid.php?opc=' + $('#idDgoProcSuper').val() + '&c=' + $(
                                '#idDgoActividad').val() + '&preg=' + $('#idDgoInstrucci').val();
                            //$('#formulario',parent.parent.window.document).html('<p>HEY</p>');
                            $('#formulario', parent.parent.window.document).load(urlt);
                            alert('Registro Actualizado');
                            parent.parent.GB_hide();
                        }
                    }
                });
            }
        }
    </script>
    <div id="header" style="margin:0 auto"></div>
    <div id="navigation" style="margin:0 auto;font-family:Verdana, Geneva, sans-serif;height:40px"></div>
    <div id="contenido">
        <?php echo '<div class="col3" style="width:800px"><strong>Actividad:</strong> ' . $acti . '</div>'; ?>

        <form name="edita" id="edita" method="post">
            <table width="100%" border="0">
                <tr>
                    <td class="etiqueta">C&oacute;digo:</td>
                    <td>
                        <input type="text" name="<?php echo $idcampo ?>" readonly="readonly" id="<?php echo $idcampo ?>" value="<?php echo isset($rowt[$idcampo]) ? $rowt[$idcampo] : '' ?>" class="inputSombra" style="width:150px" />
                        <input type="hidden" name="fechaHoy" value="<?php echo $fechaHoy ?>">
                        <input type="hidden" name="idDgoActividad" id="idDgoActividad" value="<?php echo $_GET['prue'] ?>">
                        <input type="hidden" name="idDgoProcSuper" id="idDgoProcSuper" value="<?php echo $procs ?>">

                    </td>
                </tr>
                <?php /*==================//  *** CAMBIAR *** // ===========================*/
                foreach ($formulario as $campos) {
                ?>
                    <tr>
                        <td class="etiqueta"><?php echo (($campos['tipo'] == 'hidden') ? '' : $campos['etiqueta']) ?></td>
                        <td>
                            <?php
                            switch ($campos['tipo']) {
                                    /* Campo tipo Input Text*/
                                case 'text': ?>
                                    <input type="text" name="<?php echo $campos['campoTabla'] ?>" } id="<?php echo $campos['campoTabla'] ?>" style=" <?php echo empty($campos['ancho']) ? '' : 'width:' . $campos['ancho'] . 'px' ?>
                <?php echo empty($campos['align']) ? '' : ';text-align:' . $campos['align'] ?> " <?php echo empty($campos['maxChar']) ? '' : 'maxlength="' . $campos['maxChar'] . '"' ?> value="<?php echo isset($rowt[$campos['campoTabla']]) ? $rowt[$campos['campoTabla']] : '' ?>" class="inputSombra" <?php echo $campos['soloLectura'] == 'true' ? 'readonly="readonly"' : '' ?> />
                                <?php break;
                                    /* Campo tipo Hidden Text*/
                                case 'hidden': ?>
                                    <input type="hidden" name="<?php echo $campos['campoTabla'] ?>" value="<?php echo isset($rowt[$campos['campoTabla']]) ? $rowt[$campos['campoTabla']] : '' ?>" />
                                <?php break;
                                    /* Campo tipo Select Option*/
                                case 'combo':
                                    generaComboSimple(
                                        $conn,
                                        $campos['tabla'],
                                        $campos['campoTabla'],
                                        $campos['campoValor'],
                                        isset($rowt[$campos['campoTabla']]) ? $rowt[$campos['campoTabla']] : '',
                                        (empty($campos['ancho']) ? 'width:250px' : 'width:' . $campos['ancho'] . 'px')
                                    ) ?>
                                <?php break;
                                    /* Campo tipo Select Option con arreglo de valores*/
                                case 'comboArreglo':
                                    generaComboArreglo(
                                        $campos['campoTabla'],
                                        $campos['arreglo'],
                                        isset($rowt[$campos['campoTabla']]) ? $rowt[$campos['campoTabla']] : '',
                                        (empty($campos['ancho']) ? 'width:250px' : 'width:' . $campos['ancho'] . 'px')
                                    ) ?>
                                <?php break;
                                    /* Campo tipo Input Fecha*/
                                case 'date': ?>
                                    <input type="text" name="<?php echo $campos['campoTabla'] ?>" id="<?php echo $campos['campoTabla'] ?>" <?php echo empty($campos['ancho']) ? '' : 'style="width:' . $campos['ancho'] . 'px"' ?> <?php echo empty($campos['maxChar']) ? '' : 'maxlength="' . $campos['maxChar'] . '"' ?> value="<?php echo isset($rowt[$campos['campoTabla']]) ? $rowt[$campos['campoTabla']] : '' ?>" class="inputSombra" <?php echo $campos['soloLectura'] == 'true' ? 'readonly="readonly"' : '' ?> />
                                    <input type="button" value="" onclick="displayCalendar(document.forms[0].<?php echo $campos['campoTabla']  ?>,'yyyy-mm-dd',this)" class="calendario" />
                                <?php break;
                                    /* Campo tipo textArea*/
                                case 'textArea': ?>
                                    <textarea name="<?php echo $campos['campoTabla'] ?>" onKeyUp="max(this,<?php echo $campos['maxChar'] ?>,'<?php echo $campos['campoTabla'] ?>')" onKeyPress="max(this,<?php echo $campos['maxChar'] ?>,'<?php echo $campos['campoTabla'] ?>')" class="inputSombra" style="height:<?php echo $campos['alto'] ?>px;
             width:<?php echo $campos['ancho'] ?>px;
            font-family:Verdana;font-size:12px" <?php echo $campos['soloLectura'] == 'true' ? 'readonly="readonly"' : '' ?>><?php echo isset($rowt[$campos['campoTabla']]) ? $rowt[$campos['campoTabla']] : '' ?></textarea>
                        </td>
                    </tr>
                    <?php if (!empty($campos['maxChar'])) { ?>
                        <tr>
                            <td></td>
                            <td>
                                <font id="Dig<?php echo $campos['campoTabla'] ?>" color="red">0</font> Caracteres digitados /
                                Restan
                                <font id="Res<?php echo $campos['campoTabla'] ?>" color="red"><?php echo $campos['maxChar'] ?>
                                </font>
                            <?php }
                                    break;
                                    /* Campo tipo Select Option con instruccion SQL*/
                                case 'comboSQL':
                                    generaComboSimpleSQL(
                                        $conn,
                                        $campos['tabla'],
                                        $campos['campoTabla'],
                                        'descripcion',
                                        isset($rowt[$campos['campoTabla']]) ? $rowt[$campos['campoTabla']] : '',
                                        $campos['sql'],
                                        $campos['onclick'],
                                        (empty($campos['ancho']) ? 'width:250px' : 'width:' . $campos['ancho'] . 'px')
                                    ) ?>
                        <?php break;
                                    /* Campo tipo Select CheckBox con instruccion SQL*/
                                case 'check':
                                    generaCheckSQL($conn, $campos['campoTabla'], $campos['sql'], isset($rowt[$campos['campoTabla']]) ? $rowt[$campos['campoTabla']] : '', 5, $campos['campoTabla'], $campos['campoValor']) ?>
                        <?php break;
                                    /* Campo tipo Select RabioButton con instruccion SQL*/
                                case 'radio':
                                    generaRadioSQL($conn, $campos['campoTabla'], $campos['campoValor'], isset($rowt[$campos['campoTabla']]) ? $rowt[$campos['campoTabla']] : '', $campos['sql'], $campos['onclick'], $campos['soloLectura']) ?>
                            <?php break;
                                    /* Campo tipo Arbol*/
                                case 'arbol':
                                    if ($campos['tabla'] == 'dgpUnidad' or $campos['tabla'] == 'genDivPolitica') {
                                        switch ($campos['tabla']) {
                                            case 'dgpUnidad': ?>
                                        <table>
                                            <tr>
                                                <td>
                                                    <input type="hidden" name="idDgpUnidad" id="idDgpUnidad" value="<?php echo isset($rowt[$campos['campoTabla']]) ? $rowt[$campos['campoTabla']] : '' ?>" />
                                                    <input type="text" name="unidadDescripcion" id="unidadDescripcion" value="<?php echo isset($rowt[$campos['campoValor']]) ? $rowt[$campos['campoValor']] : '' ?>" class="inputSombra" readonly="readonly" />
                                                </td>
                                                <td><a href="../../funciones/arbolUnidades.php?id=0" class="button" onclick="return GB_showPage('U N I D A D E S', this.href)"><span>Unidades</span></a>
                                                </td>
                                            </tr>
                                        </table>
                                    <?php break;
                                            case 'genDivPolitica': ?>
                                        <table>
                                            <tr>
                                                <td>
                                                    <input type="hidden" name="idGenDivPolitica" id="idGenDivPolitica" value="<?php echo isset($rowt[$campos['campoTabla']]) ? $rowt[$campos['campoTabla']] : '' ?>" />
                                                    <input type="text" name="divPoliticaDescripcion" id="divPoliticaDescripcion" value="<?php echo isset($rowt[$campos['campoTabla']]) ? $rowt[$campos['campoTabla']] : '' ?>" class="inputSombra" readonly="readonly" />
                                                </td>
                                                <td><a href="../../funciones/arbolPaises.php?id=0" class="button" onclick="return GB_showPage('DIVISION GEOGRAFICA', this.href)"><span>Lugares</span></a>
                                                </td>
                                            </tr>
                                        </table>
                                <?php break;
                                        }
                                    } else {
                                        echo '<span class="texto_red">Solo permite arboles para las tablas dgpUnidad y genDivPolitica</span>'; ?>

                            <?php }
                                    break;
                                case 'file':
                            ?>
                            <?php if (!empty($rowt[$campos['campoTabla']])) { ?>
                                <a href="<?php echo  is_null($campos['pathFile'] . $rowt[$campos['campoTabla']]) ? 'javascript:void(0);' : $campos['pathFile'] . $rowt[$campos['campoTabla']] ?>" class="button" id="ololo" title="Certificado" onclick="return GB_showPage('<?php echo $campos['etiqueta'] ?>', this.href)"><span><img src="../../../imagenes/pdf_icon.gif" alt="" border="0" />&nbsp;Ver
                                        <?php echo $campos['etiqueta'] ?></span></a>
                            <?php } ?>
                            <input type="file" name="myfile" id="myfile" size="40" />
                            <input type="hidden" name="<?php echo $campos['campoTabla'] ?>" id="<?php echo $campos['campoTabla'] ?>" value="<?php echo isset($rowt[$campos['campoTabla']]) ? $rowt[$campos['campoTabla']] : '' ?>" />
                            <input type="hidden" name="pathFile" value="<?php echo $campos['pathFile'] ?>" />
                            <input type="hidden" name="fileSize" value="<?php echo $campos['fileSize'] ?>" />
                            <input type="hidden" name="fileTypes" value="<?php echo $campos['fileTypes'] ?>" />
                            <input type="hidden" name="campoTablaValida" value="<?php echo $campos['campoTablaValida'] ?>" />
                            <input type="hidden" name="campoEtiqueta" value="<?php echo $campos['etiqueta'] ?>" />
                        <?php break;
                                default:
                                    echo '<span class="texto_red">Tipo de campo no definido en el Framework 2.0</span>';
                                    break;

                        ?>
                    <?php } ?>
                            </td>
                        </tr>
                    <?php } ?>





                    <?php
                    /*============================================================================================*/ ?>
                    <tr>
                        <td colspan="2">
                            <hr /><input type="hidden" name="opc" value="<?php echo isset($_GET['opc']) ? $_GET['opc'] : '' ?>" />
                        </td>
                    </tr>
            </table>
            <?php
            $swf = false;
            foreach ($formulario as $campos) {
                if ($campos['tipo'] == 'file')
                    $swf = true;
            }
            if ($swf) {
                //            idCampo nuevo graba impri file	
                echo botonera($idcampo, false, true, false, true);
            } else
                echo botonera($idcampo, false, true, false, false);
            ?>
        </form>
    </div>