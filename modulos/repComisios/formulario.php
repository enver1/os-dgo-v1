<?php
session_start();
include_once '../../../clases/autoload.php';
header('Content-Type: text/html; charset=UTF-8');
include_once '../../../funciones/funcion_select.php';
include_once 'config.php';
$formRepPersonalComisios = new FormRepPersonalComisios;
//$texcel = '../'.$directorio . '/toExcel.php';
$opc             = strip_tags($_GET['opc']);
$rowt            = array();
$contenedor  = $directorio . '/contenedor.php';
$grid  = $directorio . '/grid.php';
$idcampo = 'idDgoCreaOpReci';
?>
<form name="edita" id="edita" method="post">
  <fieldset>
    <legend><strong>Búsqueda de Personal</strong></legend>
    <table width="100%" border="0">
      <tr>
        <td width="46%">
          <table>
            <?php
            $formRepPersonalComisios->getFormularioRepPersonalComisios($rowt, $idcampo, $opc);

            ?>
          </table>
        </td>
      </tr>
      <tr>

        <td colspan="2"><input type="hidden" name="opc" value="<?php echo $_GET['opc'] ?>" /></td>
      </tr>
    </table>
    <table width="100%">
      <tr>
        <td width="361" align="center">
          <div align="center">
            <input type="button" onclick="excelReporte()" class="Button" value="Exportar a Excel" align="center" style="background-color:#0F6E9B;cursor:pointer;  ;width:180px; height:30px; color:#F9F9F9;border-radius: 0px 31px 31px 0px;-moz-border-radius: 0px 31px 31px 0px;-webkit-border-radius: 0px 31px 31px 0px;border: 1px solid #000000;" />
          </div>
        </td>
      </tr>
    </table>
  </fieldset>
</form>


<script type="text/javascript">
  function excelReporte() {
    if ($('#fechaini').val() == '' || $('#fechafin').val() == '' || $('#idDgoProcElec').val() == '' || $('#tipo').val() == '') {
      alert('SELECCIONE UN VALOR EN TODOS LOS CAMPOS');
    } else {
      var fd = $('#fechaini').val();
      var fh = $('#fechafin').val();
      var id = $('#idDgoProcElec').val();
      var tipo = $('#tipo').val();
      var url = "modulos/repComisios/toExcel.php?fd=" + fd + "&fh=" + fh + "&id=" + id + "&tipo=" + tipo;
      var l = screen.width;
      var t = screen.height;
      var opts = 'scrollbars=yes,toolbar=no,width=' + screen.width + ',height=' + screen.height + ',top=' + t + ' ,left=' + l;
      var name = 'pdf';
      window.open(url, name, opts);
    }

  }

  $(function() {
    $('#botonera').css('display', 'none');
  });
</script>