<?php
session_start();
include_once '../../../../../clases/autoload.php';
$AsignaPersonalElec     = new AsignaPersonalElec;
$formAsignaPersonalElec = new FormAsignaPersonalElec;
$encriptar              = new Encriptar;
$transaccion = new Transaccion;
$idDgoCreaOpReci = $_GET['idDgoCreaOpReci'];
$idUsuario       = $_SESSION['usuarioAuditar'];
$sql = $AsignaPersonalElec->getSqlAsignaPersonalElec($idDgoCreaOpReci);
$rowFL  = $transaccion->consultarAll($sql,);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>SIIPNE 3w</title>
  <link href="../../../../../css/siipne3.css" rel="stylesheet" type="text/css" />
  <script type="text/javascript" src="../../../../../js/jquery-3.5.1.min.js"></script>
  <script type="text/javascript" src="../../../../../js/datatables.min.js"></script>
  <link href="../../../../../js/datatables.min.css" rel="stylesheet" type="text/css" />
  <style>
    a.boton-unase-seleccionar {
      color: #252525;
      display: block;
      font: bold 11px Verdana, arial, sans-serif;
      margin-right: 6px;
      text-align: center;
      text-decoration: none;
      background: #d2d2d2;
      border: solid 1px #36F;
      border-radius: 7px 7px 7px 7px;
      -moz-border-radius: 7px 7px 7px 7px;
      -webkit-border-radius: 7px 7px 7px 7px;
    }

    a.boton-unase-seleccionar:hover {
      background: #69C;
      -webkit-box-shadow: 2px 2px 3px 0px rgba(0, 0, 0, 0.75);
      -moz-box-shadow: 2px 2px 3px 0px rgba(0, 0, 0, 0.75);
      box-shadow: 2px 2px 3px 0px rgba(0, 0, 0, 0.75);
    }
  </style>
</head>

<body>
  <div id="wraper">
    <div>
      <div class="warningmess">
        <p><strong>AYUDA: </strong> Personal Asignado al Recinto Electoral <strong> "<?= isset($rowFL[0]['nomRecintoElec']) ? $rowFL[0]['nomRecintoElec'] : "PERSONAL NO ASIGNADO" ?>"</strong></p>
      </div>
      <div id="content">
        <div id="content_top"></div>
        <div id="content_mid">
          <div id="contenido" style="width:95%">
            <table id='my-tbl' class="table1" style="width:100%;">
              <thead>
                <tr>
                  <th class="data-th">Ord.</th>
                  <th class="data-th">Nombre de Personal</th>
                  <th class="data-th">Estado</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $a      = "Seleccionar";
                $X      = 0;
                foreach ($rowFL as $key => $row) {
                  $X++;
                  echo "<tr class='data-tr' align='center' style=>";
                  echo "<td align=left>" . $X . "</td>";
                  echo "<td align=left>" . $row['personal'] . "</td>";
                  echo "<td align=left>" . $row['estado'] . "</td>";
                  echo "</tr>";
                } ?>
              </tbody>
            </table>
            <br />
          </div>
        </div>
      </div>
    </div>
  </div>
</body>

</html>
<script>
  $(document).ready(function() {
    $('#my-tbl').DataTable();
  });
</script>