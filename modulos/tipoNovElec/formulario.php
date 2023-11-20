<?php
session_start();
header('Content-Type: text/html; charset=UTF-8');
include_once '../../../clases/autoload.php';
include_once 'config.php';

$formNovedadesElect = new FormNovedadesElect;
$novedadesElect     = new NovedadesElect;
$encriptar      = new Encriptar;
$opc            = strip_tags($_GET['opc']);
$rowt           = array();
$idDgoNovedadesElect   = strip_tags($encriptar->getDesencriptar($_GET['c'], $_SESSION['usuarioAuditar']));
$directorioArbol  = '../' . $directorio . '/includes/treeViewTipoNovedad.php';
if ($idDgoNovedadesElect > 0) {
    $rowt = $novedadesElect->getEditNovedadesElect($idDgoNovedadesElect);
}
$formNovedadesElect->getForma($rowt, $novedadesElect->getIdCampo(), $opc, $directorioArbol, 'Accion/Detalle/Descripción', '', '220');
?>
<script type="text/javascript">
    $(document).ready(function() {
        $('#botonera').hide();
        $('#taplicacion').tree({
            onClick: function(node) {
                var node = $('#taplicacion').tree('getSelected');
                getregistro(node.attributes[1]);

            }
        });

    });

    function getregistroN(c) {

        $('#dgo_idDgoNovedadesElect').val($('#idDgoNovedadesElect').val());
        $('#descripcionPadre').val($('#descripcion').val());
        $('#idDgoNovedadesElect').val('');
        $('#descripcion').val('');

    }
</script>
<fieldset id="botonera" style=" width:96%;border: 1px solid ;border-color: #dedad9;border-radius: 5px;">
    <table width="100%" border="0">
        <tr>
            <td>
                <center>
                    <?php if (isset($_SESSION['privilegios']) && substr($_SESSION['privilegios'], 0, 1) == 1) { ?>
                        <input type="button" name="nuevo" onclick="getregistroN(0)" value="Nuevo" class="boton_new" />
                    <?php } else { ?>
                        &nbsp;
                    <?php } ?>
                </center>
            </td>
            <td>
                <center>
                    <?php /* De acuerdo a los privilegios ejecuta la funcion GRABAREGISTRO() y pasa el parametro 1, 2 o 3mas el nombre del id del campo*/
                    if (isset($_SESSION['privilegios'])) {
                        switch (substr($_SESSION['privilegios'], 0, 2)) {
                            case '11': //SI Insert y SI Update
                                echo '<input type="button" name="enviar" onclick="grabaregistro(1,\'id' . $novedadesElect->getIdCampo() . '\')" value="Grabar"  class="boton_save" />';
                                break;
                            case '10'; //SI Insert y NO Update
                                echo '<input type="button" name="enviar" onclick="grabaregistro(2,\'id' . $novedadesElect->getIdCampo() . '\')" value="Grabar"  class="boton_save" />';
                                break;
                            case '01'; // NO Insert y SI Update
                                echo '<input type="button" name="enviar" onclick="grabaregistro(3,\'id' . $novedadesElect->getIdCampo() . '\')" value="Grabar"  class="boton_save" />';
                                break;
                            case '00'; // NO Insert y NO Update
                                echo '&nbsp;';
                                break;
                        }
                    } ?>
                </center>
            </td>
            <td>
                <center><input type="button" name="imprimir" onclick="imprimirdata()" value="Imprimir" class="boton_print" /></center>
            </td>
        </tr>
    </table>
</fieldset>
<!--<hr>-->