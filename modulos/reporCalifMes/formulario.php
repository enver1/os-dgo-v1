<?php
session_start();
header('Content-Type: text/html; charset=UTF-8');
include '../../../clases/autoload.php';
include_once('../../../funciones/funcion_select.php');
$conn = DB::getConexionDB();
$dt = new DateTime('now', new DateTimeZone('America/Guayaquil'));
$fechaHoy = $dt->format('Y-m-d');
$anio = $dt->format('Y');
/*-------------------------------------------------*/
$idcampo = '';
$directorio = 'modulos/reporCalifMes'; // *** CAMBIAR ***
?>

<script>
  $(document).ready(function() {

  });

  function excelNotas() {
    var url = "modulos/reporCalifMes/notasExcel.php?anio=" + $("#anio").val();
    var l = screen.width;
    var t = screen.height;
    var opts = 'scrollbars=yes,toolbar=no,width=' + screen.width + ',height=' + screen.height + ',top=' + t + ' ,left=' + l;
    var name = 'Reporte Notas';

    if (validate_combo(anio, "Año") == false) {
      anio.focus();
      return false;
    } else {
      window.open(url, name, opts);
    }
  }
</script>

<form name="edita" id="edita" method="post">
  <fieldset>
    <legend><strong>Detalle Calificaciones Por Meses</strong></legend>
    <table width="100%" border="0">
      <tr>
        <td width="45%" align="right" class="etiqueta">A&ntilde;o:</td>
        <td>
          <?php
          generaComboAnio('anio', 0, 2013, '', 'style="width:150px"');
          ?>
        </td>
      </tr>

      <tr>

        <td><input type="hidden" name="id<?php echo $idcampo ?>" readonly="readonly" value="<?php echo isset($rowt['id' . $idcampo]) ? $rowt['id' . $idcampo] : '' ?>" /></td>

      </tr>

      <tr>
        <?php /*----------------------------------------------------*/ ?>
        <td colspan="2"><input type="hidden" name="opc" value="<?php echo $_GET['opc'] ?>" /></td>
      </tr>
      <?php //include_once('../../../funciones/botonera.php'); 
      ?>

    </table>
    <table width="100%">
      <tr>
        <td width="361" align="center">
          <div align="center">
            <input type="button" onclick="excelNotas()" class="Button" value="Descarga Excel" align="center" />
          </div>
        </td>
      </tr>
    </table>
  </fieldset>
</form>
<div align="center"></div>