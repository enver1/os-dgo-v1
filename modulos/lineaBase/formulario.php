<?php
session_start();
header('Content-Type: text/html; charset=UTF-8');
include '../../../clases/autoload.php';
include_once('../../../funciones/funcion_select.php');
$dt = new DateTime('now', new DateTimeZone('America/Guayaquil'));
$conn = DB::getConexionDB();
$fechaHoy = $dt->format('Y-m-d');
$anio = $dt->format('Y');
/*-------------------------------------------------*/

$directorio = 'modulos/lineaBase'; // *** CAMBIAR ***
/*-------------------------------------------------*/
/*
* Aqui se incluye el formulario de edicion
*/

$combo = array(
  'tabla'       => 'genMes',
  'campoTabla'  => 'idGenMes',
  'campoValor'  => 'descMes',
  'soloLectura' => 'false',
  'ancho'       => '150'
)

?>

<script>
  $(document).ready(function() {

  });

  function excelLineaBase() {

    var anio = $("#anio").val();
    var mes = $("#idGenMes").val();

    var url = "modulos/lineaBase/lineaBaseExcel.php?anio=" + anio + "&mes=" + mes;
    var l = screen.width;
    var t = screen.height;
    var opts = 'scrollbars=yes,toolbar=no,width=' + screen.width + ',height=' + screen.height + ',top=' + t + ' ,left=' + l;
    var name = 'Reporte Linea Base';

    if (validate(document.getElementById("edita"))) {
      $.ajax({
        type: "POST",
        url: "modulos/notasCursantes/verificaDatos.php",
        data: "anio=" + anio,
        success: function(response) {

          result = JSON.parse(response);

          if (result[0]) {
            window.open(url, name, opts);
          } else {
            alert(result[1]);
          }
        }
      });
    }

  }
</script>

<form name="edita" id="edita" method="post">
  <fieldset style="border:solid 2px #666;">
    <legend><strong>Linea Base</strong></legend>
    <table width="100%" border="0">
      <tr>
        <td width="45%" align="right" class="etiqueta">A&ntilde;o:</td>
        <td width="50%">
          <?php
          generaComboAnio('anio', 0, 2013, '', 'style="width:150px"');
          ?>
        </td>
      </tr>
      <tr>
        <td width="45%" align="right" class="etiqueta">Mes:</td>
        <td width="50%">
          <?php
          generaComboSimple($conn, $combo['tabla'], $combo['campoTabla'], $combo['campoValor'], '', (empty($combo['ancho']) ? 'width:250px' : 'width:' . $combo['ancho'] . 'px'));
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
    </table>

    <table width="100%">
      <tr>
        <td width="361" align="center">
          <input type="button" onclick="excelLineaBase()" class="boton_new" value="Excel" align="center" />
        </td>
      </tr>
    </table>
  </fieldset>
</form>
<div align="center"></div>