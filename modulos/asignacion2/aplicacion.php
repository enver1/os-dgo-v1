<?php
if (isset($_SESSION['usuarioAuditar'])) {
  include_once 'config.php';
  include_once '../clases/autoload.php';
  $Asignacion      = new Asignacion;
  $encriptar       = new Encriptar;
  $idGenPersona = 0;
  $sqltable        = $encriptar->getEncriptar($Asignacion->getSqlAsignacion($idGenPersona), $_SESSION['usuarioAuditar']);
  $tgrid           = $directorio . '/grid.php'; // php para mostrar la grid
  $tforma          = $directorio . '/formulario.php'; // php para mostrar el formulario en la parte superior
  $tborra          = $directorio . '/borra.php'; // php para borrar un registro
  $tgraba          = $directorio . '/graba.php'; // php para grabar un registro
  $tprint          = $directorio . '/imprime.php'; // nombre del php que imprime los registros
?>
  <div class="contenedor" style="width:100%">
    <div class="dbody">
      <table width="100%" border="0">
        <tr>
          <td style="vertical-align:top;">
            <div id='formulario'>
              <img src="../funciones/paginacion/images/ajax-loader.gif" />
            </div>
            <div id="grid-data" class="seccion-visita" style="display:none">
              <table id="my-tbl" border="0" style="border-radius: 3px;">
                <thead>
                  <th class="data-th">Código</th>
                  <th class="data-th">División Senplades</th>
                  <th class="data-th">Año</th>
                  <th class="data-th">Meses</th>
                  <th class="data-th">Acciones</th>
                </thead>
              </table>
            </div>
          </td>
        </tr>

      </table>
    </div>
    <div class="dfoot">
    </div>
  </div>
  <script>
    const tgrid = '<?= $tgrid ?>';
    const tborra = '<?= $tborra ?>';
  </script>
  <?php include_once '../js/ajaxuidGenerico.php'; // Este archivo contiene las funciones de ajax para update, insert, delete, y edit 
  ?>
  <script type="text/javascript" src="<?php echo '../' . $directorio ?>/validacion.js"></script>
<?php
} else {
  header('Location: indexSiipne.php');
}
?>