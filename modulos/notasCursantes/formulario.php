<?php
session_start();
header('Content-Type: text/html; charset=UTF-8');
include '../../../clases/autoload.php';
include '../../../funciones/funciones_generales.php';
$conn = DB::getConexionDB();
$forma = new Forma;
$dt = new DateTime('now', new DateTimeZone('America/Guayaquil'));
$fechaHoy = $dt->format('Y-m-d');
$anio = $dt->format('Y');
$directorio = 'modulos/notasCursantes';

$formulario = array(
  array(
    'tipo'        => 'comboAnio',
    'etiqueta'    => 'Año:',
    'valorInicial' => '2017',
    'campoTabla'  => 'anio',
    'ancho'       => '300',
    'soloLectura' => 'true',
    'ayuda'       => '',
    'onclick'     => 'onclick="showFields(this.value)"'
  ),

  array(
    'tipo'        => 'comboSQL',
    'etiqueta'    => '<span id="eidGenGeoSenplades">Zonas:</span>',
    'tabla'       => 'genGeoSenplades',
    'campoTabla'  => 'idGenGeoSenplades',
    'ancho'       => '300',
    'sql'         => 'SELECT idGenGeoSenplades, descripcion FROM genGeoSenplades WHERE idGenTipoGeoSenplades = 1 AND gen_idGenGeoSenplades IS NOT NULL',
    'soloLectura' => 'false',
    'ayuda'       => '',
    'onclick'     => ''
  ),
);
?>
<form name="edita" id="edita" method="post">
  <fieldset>
    <legend><strong>Detalle Calificaciones Por Meses Cursantes</strong></legend>
    <table width="100%" border="0">
      <?php $forma->campoFormulario($conn, $formulario, array()); ?>
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
          <div align="center">
            <input type="button" onclick="excelNotas()" class="Button" value="Descarga Excel" align="center" />
          </div>
        </td>
      </tr>
    </table>
  </fieldset>
</form>
<div align="center"></div>