<?php
session_start();
include_once 'config.php';
include_once '../../../clases/autoload.php';
$tipoTipificacion = new TipoTipificacion();
$form             = new FormTipoTipificacion();
$encriptar        = new Encriptar();

$opc  = $_GET['opc'];
$rowt = array();

$id              = strip_tags($encriptar->getDesencriptar($_GET['c'], $_SESSION['usuarioAuditar']));
$directorioArbol = '../' . $directorio . '/includes/treeView.php';

if ($id > 0) {
    $rowt = $tipoTipificacion->getEditTipoTipificacion($id);
}
$form->getFormaArbol($rowt, $tipoTipificacion->getIdCampo(), $opc, $directorioArbol, 'CAT&Aacute;LOGOS', '', '220');
?>

<script type="text/javascript">
    $(document).ready(function () {
        $('#botonera').css('display','none')
        $('#taplicacion').tree({
            onClick: function (node) {
                var node = $('#taplicacion').tree('getSelected');
                getregistro(node.attributes[1]);
            }
        });
       // $('#siglas').attr('readonly', 'readonly');
    });

    function getregistroN(c) {
        $('#gen_idGenTipoTipificacion').val($('#idGenTipoTipificacion').val());
        $('#descripcionPadre').val($('#descripcion').val());

        $('#idGenTipoTipificacion').val('');
        $('#descripcion').val('');
        $('#siglas').val('');
        $('#detalle').val('');
      
    }


    function limpioArbol(c) {
        if (c == 'idGenTipoTipificacion') {
            $('#idGenTipoTipificacion').val('');
            $('#descripcion').val('');
            $('#siglas').val('');
            $('#detalle').val('');
        }

    }
</script>
<table width="100%" border="0">
    <tr>
        <td>
            <?php if (isset($_SESSION['privilegios']) and substr($_SESSION['privilegios'], 0, 1) == 1) {?>
                <input type="button" name="nuevo" onclick="getregistroN(0)"
                       value="Nuevo" class="boton_new" />
                   <?php } else {?>
                &nbsp;
            <?php }?>
        </td>
        <td>
            <?php
/* De acuerdo a los privilegios ejecuta la funcion GRABAREGISTRO() y pasa el parametro 1, 2 o 3mas el descripcion del id del campo */
if (isset($_SESSION['privilegios'])) {
    switch (substr($_SESSION['privilegios'], 0, 2)) {
        case '11': // SI Insert y SI Update
            echo '<input type="button" name="enviar" onclick="grabaregistro(1,\'id' . $tipoTipificacion->getIdCampo() . '\')" value="Grabar"  class="boton_save" />';
            break;
        case '10': // SI Insert y NO Update
            echo '<input type="button" name="enviar" onclick="grabaregistro(2,\'id' . $tipoTipificacion->getIdCampo() . '\')" value="Grabar"  class="boton_save" />';
            break;
        case '01': // NO Insert y SI Update
            echo '<input type="button" name="enviar" onclick="grabaregistro(3,\'id' . $tipoTipificacion->getIdCampo() . '\')" value="Grabar"  class="boton_save" />';
            break;
        case '00': // NO Insert y NO Update
            echo '&nbsp;';
            break;
    }
}
?>
        </td>
 
    </tr>
</table>

