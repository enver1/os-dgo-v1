<?php
session_start();
include_once '../../../clases/autoload.php';
if (isset($_SESSION['usuarioAuditar'])) {
  header('Pragma: no-cache');
  header('Cache-Control: no-store, no-cache, must-revalidate');

  // Create instance of TableData class
  $Asignacion = new Asignacion;
  $table_data = new DataTable();
  $idGenPersona = (int)strip_tags($_GET['idGenPersona']);
  $table = "({$Asignacion->getSqlAsignacion($idGenPersona)}) temp";
  $extra_colum = array('modificacion' => false, 'eliminar' => false);
  if (isset($_SESSION['privilegios']) && substr($_SESSION['privilegios'], 1, 1) == 1) {
    $extra_colum['modificacion'] = true;
  }
  if (isset($_SESSION['privilegios']) && substr($_SESSION['privilegios'], 2, 1) == 1) {
    $extra_colum['eliminar'] = true;
  }
  $table_data->get($table, 'idDgoAsignacion', array('idDgoAsignacion', 'anio', 'descripcion', 'meses'), $extra_colum);
} else {
  header('Location: indexSiipne.php');
}
