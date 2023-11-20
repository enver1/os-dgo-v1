<?php
if (isset($_SESSION['usuarioAuditar'])) {
  include 'config.php';

  $tgrid  = $directorio . '/grid.php'; // php para mostrar la grid
  $tforma = $directorio . '/formulario.php'; // php para mostrar el formulario en la parte superior
  $tborra = $directorio . '/borra.php'; // php para borrar un registro
  $tgraba = $directorio . '/graba.php'; // php para grabar un registro
  $tprint = $directorio . '/imprime.php'; // nombre del php que imprime los registros
  ?>
  <!--link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script-->
  <link rel="stylesheet" href="/js/jquery-ui/jquery-ui.css">
  <script src="/js/jquery-ui/jquery-ui.js"></script>
  <div id="dialog-loading" title="Notificación!" style="display: none;">
    <p>Espere un momento por favor...</p>
    <img src="../funciones/paginacion/images/ajax-loader.gif" />
  </div>
  <div id="dialog-confirm" title="Notificación!" style="display: none;">
    <div id="dialog-text">
    </div>
  </div>
  <div id='formulario'>
    <img src="../funciones/paginacion/images/ajax-loader.gif" />
  </div>
  <div id='retrieved-data' style="width:99%">
    <table id="my-tbl" class="display compact hover dataTable no-footer" style="width:100%" cellspacing="0">
      <thead>
        <tr>
          <th class="data-th">Año</th>
          <th class="data-th">Mes</th>
          <th class="data-th">Tipo</th>
          <th class="data-th">Total</th>
        </tr>
      </thead>
      <tbody id="load-data"></tbody>
    </table>
  </div>
  <script type="text/javascript">
    const opc = '<?=$_GET['opc']?>';
    const tforma = '<?=$tforma?>';
    const tgraba = '<?=$tgraba?>';
    const tgrid = '<?=$tgrid?>';
    $(function() {
      getFormulario(0);
      getData();
      //$("#my-tbl").DataTable();
    });
  </script>
  <script type="text/javascript" src="<?=$directorio?>/funciones.js"></script>
<?php
} else {
  header('Location: imprime.php');
}
?>