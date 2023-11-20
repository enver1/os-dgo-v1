<?php
session_start();
header('Content-Type: text/html; charset=UTF-8');
include '../../../funciones/db_connect.inc.php';
include_once '../../../funciones/funcion_select.php';
include_once 'config.php';

$texcel = $directorio . '/toExcel.php';
$contenedor  = $directorio . '/contenedor.php';
$grid  = $directorio . '/grid.php';
?>
<script type="text/javascript" src="../../../js/sha1.js"></script>
<script type="text/javascript">
  function excelReporte() {
    var fd = $('#fechaini').val();
    var fh = $('#fechafin').val();
    var gs = $('#idGenGeoSenplades').val();

    if (fd == "" || fh == "" || gs == "") {
      alert('SELECCIONE: Fecha Inicio / Fecha Fin');
    } else {
      var f = $('#forma1').val();
      var url = "modulos/<?php echo $texcel ?>?fd=" + fd + "&fh=" + fh + "&gs=" + gs;
      var l = screen.width;
      var t = screen.height;
      var opts = 'scrollbars=yes,toolbar=no,width=' + screen.width + ',height=' + screen.height + ',top=' + t + ' ,left=' + l;
      var name = 'pdf';
      window.open(url, name, opts);
    }
  }
</script>

<form name="edita" id="edita" method="post">
  <fieldset>
    <legend><strong>Búsqueda Registros</strong></legend>
    <table width="100%" border="0">
      <tr>
        <td width="46%">
          <table>
            <tr>
              <td class="etiqueta">Fecha Desde:</td>
              <td>
                <input type="text" name="fechaini" id="fechaini" size="12" style="width:100px" class="inputSombra" readonly="readonly" />
                <input type="button" value="" onclick="displayCalendar(document.edita.fechaini,'yyyy-mm-dd',this)" class="calendario" />
              </td>
            </tr>
            <tr>
              <td class="etiqueta">Fecha Hasta:</td>
              <td>
                <input type="text" name="fechafin" id="fechafin" size="12" style="width:100px" class="inputSombra" readonly="readonly" />
                <input type="button" value="" onclick="displayCalendar(document.edita.fechafin,'yyyy-mm-dd',this)" class="calendario" />
              </td>
            </tr>
          </table>
        </td>
      </tr>
      <tr>

        <?php /*----------------------------------------------------*/ ?>
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