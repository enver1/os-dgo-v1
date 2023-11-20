<?php
session_start();
header('Content-Type: text/html; charset=UTF-8');
include_once 'config.php';
include_once '../../../../clases/autoload.php';
include '../../../../funciones/db_connect.inc.php';
include_once '../../../../funciones/funcion_select.php';

$tgrid        = $directorio . '/grid.php'; // php para mostrar la grid
$tforma       = $directorio . '/formulario.php'; // php para mostrar el formulario en la parte superior
$tborra       = $directorio . '/borra.php'; // php para borrar un registro
$tgraba       = $directorio . '/graba.php'; // php para grabar un registro
$tprint       = $directorio . '/imprime.php'; // nombre del php que imprime los registros
$sqgrid       = sha1('procesosElectorales');
$FormComisios = new FormComisios;
$Comisios     = new Comisios;
$encriptar    = new Encriptar;
$opc          = strip_tags($_GET['opc']);
$Ntabla       = 'dgoComisios';
$idcampo      = ucfirst($Ntabla);
//$directorio   = 'modulos/procesosElectorales';

if (isset($_GET['c'])) {
    $sql  = "SELECT a.*,b.nomRecintoElec padre FROM " . $Ntabla . " a left outer join dgoReciElect b on b.idDgoReciElect=a.idDgoReciElect where a.id" . $idcampo . "='" . $_GET['c'] . "'";
    $rs   = $conn->query($sql);
    $rowt = $rs->fetch(PDO::FETCH_ASSOC);
}
/*
 * Aqui se incluye el formulario de edicion
 */
?>
<script type="text/javascript">
    $(function() {
        $('#idDgoProcElec').val($('#idProceso').val());
        $('#botonera').css('display', 'none');
    });
</script>
<script>
    $(document).ready(function() {

        $('#tapp').tree({
            onClick: function(node) {
                var node = $('#tapp').tree('getSelected');
                $('#paisDesc').attr('value', node.text);
                $('#paisCdg').attr('value', node.id);
                $('#isRecinto').attr('value', node.isRecinto);
                $("html, body").animate({
                    scrollTop: 0
                }, "slow");

            }
        });
    });
    //BORRAR BOTONERA

    function grabaregistroUserApp(c, d) {

        var targetURL = 'modulos/muestraresultados.php?page=1&grilla=<?php echo $tgrid ?>&opc=<?php echo $_GET['opc'] ?>&modl=<?php echo $sqgrid ?>';
        var $inputs = $('#edita :input');
        var values = {};
        $inputs.each(function() {
            values[this.name] = $(this).val();
        });
        /* Valida permisos y privilegios sobre la BDD*/
        var id = values[d];
        if (c == '2' && !(id == "" || id == "0" || typeof(id) == 'undefined')) {
            alert('No tiene permisos para Modificar Registros');
            return;
        }
        if (c == '3' && (id == "" || id == "0" || typeof(id) == 'undefined')) {
            alert('No tiene permisos para Insertar Nuevos Registros');
            return
        }
        if (validate(document.getElementById("edita"))) {
            var result = '';
            var $forma = $('html,body');
            var seleccionados = getChecked();
            var isRecinto = getCheckedNombre();
            $.ajax({
                type: "POST",
                url: "modulos/procesosElectorales/paso2/graba.php?&sele=" + seleccionados + "&isRecinto=" + isRecinto,
                data: values,
                success: function(response) {
                    result = response;

                    $("html, body").animate({
                        scrollTop: $forma.height()
                    }, "slow");
                }
            });
        }
        if (!(result == '' || typeof(result) == 'undefined')) {
            alert(result);
        }
        getregistro(0);
        getdata(1);
    }

    function getChecked() {
        var nodes = $('#tapp').tree('getChecked');
        var s = '';
        for (var i = 0; i < nodes.length; i++) {
            if (s != '') {
                s += ',';
            }
            s += nodes[i].id;
        }
        return s;
    }

    function getCheckedRecinto() {
        var nodes = $('#tapp').tree('getChecked');
        var s = '';
        for (var i = 0; i < nodes.length; i++) {
            if (s != '') {
                s += ',';
            }
            s += nodes[i].isRecinto;
        }
        return s;
    }

    function getCheckedNombre() {
        var nodes = $('#tapp').tree('getChecked');
        var s = '';
        for (var i = 0; i < nodes.length; i++) {
            if (s != '') {
                s += ',';
            }
            s += nodes[i].text;
        }
        return s;
    }
</script>
<table width="100%" align="center">
    </form align="center">
    </td>
    <tr>
        <td>
            <input type="hidden" readonly="readonly" size="5" name="paisCdg" id="paisCdg" value="<?php echo isset($rowt['idDgoTipoEje']) ? $rowt['idDgoTipoEje'] : '' ?>" class="inputSombra" style="width:50px" />
            <input type="hidden" readonly="readonly" size="5" name="isRecinto" id="isRecinto" value="<?php echo isset($rowt['isRecinto']) ? $rowt['isRecinto'] : '' ?>" class="inputSombra" style="width:50px" />
            <input type="<?php echo (isset($rowt['idDgoTipoEje']) and $rowt['idDgoTipoEje'] > 0) ? 'hidden' : 'hidden' ?>" id="paisDesc" name="paisDesc" value="<?php echo isset($rowt['padre']) ? $rowt['padre'] : '' ?>" size="48" class="inputSombra" style="width:280px" readonly="readonly" />
        </td>
    </tr>
    <td width="45%" valign="top">
        <div style=" overflow: scroll; height:300px">
            <ul id="tapp" class="easyui-tree" animate="true" style="font-size:10px" checkbox="true" onlyLeafCheck="false" url="<?php echo '../' . $directorioC ?>/tree_unidad_todo.php?id=<?php echo (isset($_GET['id']) ? $_GET['id'] : 0) ?>&buscado=<?php echo (isset($_GET['usuario']) ? $_GET['usuario'] : 0) ?>">
            </ul>
        </div>
    </td>
    </tr>
</table>
<?php
$FormComisios->getFormularioComisiosProceso($rowt, $Comisios->getIdCampoComisios(), $opc);
?>
<div style="margin: 0 auto;">
    <table width="100%" border="0">
        <tr>
            <td>
                <?php if (isset($_SESSION['privilegios']) and substr($_SESSION['privilegios'], 0, 1) == 1) { ?>
                    <input type="button" name="nuevo" onclick="getregistro(0)" value="Nuevo" class="boton_new" />
                <?php } else { ?>
                    &nbsp;
                <?php } ?>
            </td>
            <td>
                <?php /* De acuerdo a los privilegios ejecuta la funcion GRABAREGISTRO() y pasa el parametro 1, 2 o 3mas el nombre del id del campo*/
                if (isset($_SESSION['privilegios'])) {
                    switch (substr($_SESSION['privilegios'], 0, 2)) {
                        case '11': //SI Insert y SI Update
                            echo '<input type="button" name="enviar" onclick="grabaregistroUserApp(1,\'id' . $idcampo . '\')" value="Grabar"  class="boton_save" />';
                            break;
                        case '10': //SI Insert y NO Update
                            echo '<input type="button" name="enviar" onclick="grabaregistroUserApp(2,\'id' . $idcampo . '\')" value="Grabar"  class="boton_save" />';
                            break;
                        case '01': // NO Insert y SI Update
                            echo '<input type="button" name="enviar" onclick="grabaregistroUserApp(3,\'id' . $idcampo . '\')" value="Grabar"  class="boton_save" />';
                            break;
                        case '00': // NO Insert y NO Update
                            echo '&nbsp;';
                            break;
                    }
                } ?>
            </td>
        </tr>
    </table>
</div>