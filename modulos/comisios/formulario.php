<?php
session_start();
header('Content-Type: text/html; charset=UTF-8');
include '../../../funciones/db_connect.inc.php';
include_once '../../../funciones/funcion_select.php';
include_once 'config.php';
include_once '../../../clases/autoload.php';


$encriptar         = new Encriptar;
$opc               = strip_tags($_GET['opc']);
$rowt              = array();
$idDgiParteDiario  = strip_tags($encriptar->getDesencriptar($_GET['c'], $_SESSION['usuarioAuditar']));
?>
<script type="text/javascript" src="../../../js/sha1.js"></script>
<script type="text/javascript">
function generaReporte() {
  var cedula = '0401';
  var data = {cedula:cedula};
  var url = 'modulos/comisios/imprimeDetallado.php';
  $.post(url, data,function (response) {
    console.log(response);

  });
}

function generaReporteGeneral()
{

  var url="modulos/comisios/imprimeRepoGeneral.php?fp=0";
}

 </script>
<form name="edita" id="edita" method="post">
  <fieldset>
  <legend><strong>Generar Reporte Parte Diario</strong></legend>
  <table width="100%" border="0">
    <tr>
      <td width="46%">
        <table>
           <tr>
            <?php
            ?>
          </tr>
        </table>
      </td>
  </tr>
  <tr>

 <?php /*----------------------------------------------------*/?>
    <td colspan="2" ><input type="hidden" name="opc" value="<?php echo $_GET['opc'] ?>" /></td>
  </tr>
  </table>
  <table width="100%">
    <tr >
        <td width="361" align="center">
        <div align="center">
          <input type="button" onclick="generaReporte()" class="Button" value="ACTUALIZA ID POLÍTICA" align="center" style="background-color:#0F6E9B;cursor:pointer;  ;width:180px; height:30px; color:#F9F9F9;border-radius: 0px 31px 31px 0px;-moz-border-radius: 0px 31px 31px 0px;-webkit-border-radius: 0px 31px 31px 0px;border: 1px solid #000000;"/>
        </div>
      </td>
             <td width="361" align="center">
        <div align="center">
          <input type="button" onclick="generaReporteGeneral()" class="Button" value="ACTUALIZA ID SENPLADES" align="center" style="background-color:#0F6E9B;cursor:pointer;  ;width:180px; height:30px; color:#F9F9F9;border-radius: 0px 31px 31px 0px;-moz-border-radius: 0px 31px 31px 0px;-webkit-border-radius: 0px 31px 31px 0px;border: 1px solid #000000;"/>
        </div>
      </td>
    </tr>

  </table>
  </fieldset>
</form>

<script type = "text/javascript">
$(function() {
  var esatdo="TI";
 verDispositivo(esatdo);


});
</script>