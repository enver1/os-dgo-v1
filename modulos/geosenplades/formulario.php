<?php
session_start();
header('Content-Type: text/html; charset=UTF-8');
include '../../../funciones/db_connect.inc.php';
include_once('../../../funciones/funcion_select.php');
include_once('validacion.php');
$tgraba = 'geosenplades/graba.php'; // nombre del php para insertar o actualizar un registro
$Ntabla = 'genGeoSenplades';

/*-------------------------------------------------*/
$idcampo = ucfirst($Ntabla);
$directorio = 'modulos/geosenplades';
if (isset($_GET['c'])) {
    $sql = "select a.*,b.descripcion padre, b.siglasGeoSenplades siglasPadre,c.descripcion tipoDescripcion from " . $Ntabla;
    $sql .= " a left outer join genGeoSenplades b on b.idGenGeoSenplades=a.gen_idGenGeoSenplades left outer join genTipoGeoSenplades ";
    $sql .= "c on a.idGenTipoGeoSenplades=c.idGenTipoGeoSenplades where a.id" . $idcampo . "='" . $_GET['c'] . "'";
    $rs = $conn->query($sql);
    $rowt = $rs->fetch(PDO::FETCH_ASSOC);
    $siglaTotal = isset($rowt['siglasGeoSenplades']) ? $rowt['siglasGeoSenplades'] : '';
    $siglaPadre = isset($rowt['siglasPadre']) ? $rowt['siglasPadre'] : '';
    $siglaHijo = str_replace($siglaPadre . "-", "", $siglaTotal);
}
/*
* Aqui se incluye el formulario de edicion
*/
?>

<script>
$(document).ready(function() {
    $('#tpais').tree({
        onClick: function(node) {
            var node = $('#tpais').tree('getSelected');

            var siglaHijo = node.attributes[0];
            var codigoSenplades = node.attributes[1];
            var TipoGeoSenplades = node.attributes[2];
            var siglaPadre = node.attributes[3];

            $('#paisDesc').attr('value', node.text);
            $('#paisCdg').attr('value', node.id);

            $('#siglasParte1').attr('value', siglaHijo);
            /* Aniadido por Alberto Arias 20-Feb-2014  Envia el id del nodo seleccionado al php que busca id y descripcion del tipo inferior*/
            var variable_post = TipoGeoSenplades;
            $.post("modulos/geosenplades/buscatipoinferior.php", {
                variable: variable_post
            }, function(data) {
                var codigo = data[1];
                var detalle = data[0];
                $("#tipo").attr('value', codigo);
                $("#tipodesc").attr('value', detalle);
            }, "json");
            /*------------------------------------*/
            $("html, body").animate({
                scrollTop: 0
            }, "slow");
        }
    });
});
</script>
<table width="100%" border="0">
    <tr>
        <td width="55%">
            <table width="100%" border="0">
                <tr>
                    <td width="55%">
                        <form name="edita" id="edita" method="post">
                            <table width="100%" border="0">
                                <tr>
                                    <td width="20%">C&oacute;digo:</td>
                                    <td width="80%">
                                        <input type="text" name="id<?php echo $idcampo ?>" readonly="readonly"
                                            value="<?php echo isset($rowt['id' . $idcampo]) ? $rowt['id' . $idcampo] : '' ?>"
                                            class="inputSombra" style="width:80px" />
                                    </td>
                                </tr>
                                <tr>
                                    <td>Descripci&oacute;n:</td>
                                    <td><input type="text" name="descripcion" size="60"
                                            value="<?php echo isset($rowt['descripcion']) ? $rowt['descripcion'] : '' ?>"
                                            class="inputSombra" /></td>
                                </tr>
                                <tr>
                                    <td>Depende de:</td>
                                    <td><input type="hidden" readonly="readonly" size="5" name="paisCdg" id="paisCdg"
                                            value="<?php echo isset($rowt['gen_idGenGeoSenplades']) ? $rowt['gen_idGenGeoSenplades'] : '' ?>" />
                                        <input type="text" id="paisDesc" name="paisDesc"
                                            value="<?php echo isset($rowt['padre']) ? $rowt['padre'] : '' ?>"
                                            class="inputSombra" style="width:355px" />->
                                    </td>
                                </tr>
                                <tr>
                                    <td>Tipo Division:</td>
                                    <td>
                                        <input type="hidden" name="tipo" id="tipo" size="2"
                                            value="<?php echo isset($rowt['idGenTipoGeoSenplades']) ? $rowt['idGenTipoGeoSenplades'] : '' ?>" />
                                        <input type="text" name="tipodesc" id="tipodesc" size="30" readonly="readonly"
                                            value="<?php echo isset($rowt['tipoDescripcion']) ? $rowt['tipoDescripcion'] : '' ?>"
                                            class="inputSombra" style="width:200px" />
                                    </td>
                                </tr>
                                <tr>
                                    <td>Siglas:</td>
                                    <td>
                                        <input type="text" id="siglasParte1" name="siglasParte1" size="30"
                                            readonly="readonly"
                                            value="<?php echo isset($rowt['siglasPadre']) ? $rowt['siglasPadre'] : '' ?>"
                                            style="border:none;color:#900; font-size:10px;" />
                                        <input type="text" name="siglasGeoSenplades" id="siglasGeoSenplades" size="40"
                                            value="<?php echo isset($siglaHijo) ? $siglaHijo : '' ?>"
                                            class="inputSombra" />
                                    </td>
                                </tr>
                                <tr>
                                    <td>Codificaci&oacute;n Senplades:</td>
                                    <td><input type="text" name="codigoSenplades" id="codigoSenplades" size="60"
                                            value="<?php echo isset($rowt['codigoSenplades']) ? $rowt['codigoSenplades'] : '' ?>"
                                            class="inputSombra" /></td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <hr /><input type="hidden" name="opc" value="<?php echo $_GET['opc'] ?>" />
                                    </td>
                                </tr>
                            </table>
                            <?php include_once('../../../funciones/botonera.php'); ?>
                        </form>
                    </td>
                    <td width="45%">
                        <div style=" overflow: scroll; height:250px">
                            <ul id="tpais" class="easyui-tree" animate="true" style="font-size:10px"
                                url="<?php echo $directorio ?>/tree_unidad_todo.php?id=<?php echo (isset($_GET['id']) ? $_GET['id'] : 0) ?>">
                            </ul>
                        </div>
                    </td>
                </tr>
            </table>