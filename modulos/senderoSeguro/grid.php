<?php
session_start();
header('Content-Type: text/html; charset=UTF-8');

include_once '../../../clases/autoload.php';

$senderoSeguro = new SenderoSeguro;

$fecha = strip_tags($_POST['fecha']);
$idPuntoLlegada = strip_tags($_POST['idPuntoLlegada']);


$datosAlertas = $senderoSeguro->getConsultarTodasAlertasActivas();
$datosRutaTodas = $senderoSeguro->getConsultarTodasRutasActivas();


$totalRutasActivas = sizeof($datosRutaTodas);
$totalAlertas = sizeof($datosAlertas);
$rutas = 0;
$rutasRecorridas = 0;
$alertas = 0;


if ($idPuntoLlegada == 0) { // se consulta todas las rutas
  $datosRuta = $senderoSeguro->getConsultarRutasPorFecha($fecha);
} else if ($idPuntoLlegada == -1) { // si es -1 msotramos todas las rutas activas

  $datosRuta = $datosRutaTodas;
} else if ($idPuntoLlegada == -2) { // si es -2 msotramos todas las alertas activas

  $datosRuta = $datosAlertas;
} else { // se consulta segun el punto de llegada
  $datosRuta = $senderoSeguro->getConsultarRutasPorFechaPuntoLlegada($fecha, $idPuntoLlegada);
}

$gridS = array(
  'Apellidos y Nombres' => 'nombre',
  'Fecha ' => 'fechaCreacion',
  'Destino ' => 'puntoLlegada',
  'Estado Ruta ' => 'estado'
);
?>
<hr>



<table>
    <tr>
        <td> <span style="background-color:#9CF;border:solid 1px #444;padding:2px 5px;font-size:9px">&nbsp;
            </span> <b id="rutas">Rutas </b>
        </td>
        <td>
            <div id="divRutas"> <b> </b></div>
        </td>

        <td> <span style="background-color:#A8DCC1;border:solid 1px #444;padding:2px 5px;font-size:9px">&nbsp;
            </span> <b id="rutasRecorridas">Rutas Recorridas</b>
        </td>
        <td>
            <div> </div>
        </td>


        <td> <span style="background-color:#DCA8A8;border:solid 1px #444;padding:2px 5px;font-size:9px">&nbsp;
            </span> <b id="alertasGrid">Alertas</b>
        </td>
        <td>
            <div> </div>
        </td>
    </tr>

</table>



<div id='map' name='map' style=" overflow: scroll; height:400px">
    <table id='my-tbl'>
        <tr>


            <td class="data-th"></td>




            <?php foreach ($gridS as $campos => $valor) { ?>
            <td class="data-th"><?php echo $campos ?></td>
            <?php } ?>
            <td class="data-th">VER</td>

        </tr>
        <?php
    //loop por cada registro tomando los campos delarreglo $gridS
    foreach ($datosRuta as $key => $row) {


      $idRutaDetalle = $row['idGoeRutaDetalle'];
      $idAlerta = $row['idGoeAlerta'];

      $estilo = "";

      if ($idAlerta > 0) {
        $estilo = 'style="background-color:#DCA8A8"';

        $alertas = $alertas + 1;
      } else if ($idRutaDetalle > 0) {
        $estilo = 'style="background-color:#A8DCC1"';

        $rutasRecorridas = $rutasRecorridas + 1;
      } else {
        $estilo = 'style="background-color:#9CF"';
        $rutas = $rutas + 1;
      }


      $idUser = $row['idGoeUsuReg'];
      $idRuta = $row['idGoeRutas'];
      $estado = $row['estado'];


      echo "<tr class='data-tr' align='center' >";
      echo '<td><spane id="s' . $idRuta . '" style="color:#ffffff;padding:5px;font-weight:bold;border-radius: 0px 15px 15px 0px;-moz-border-radius: 0px 15px 15px 0px;-webkit-border-radius: 0px 15px 15px 0px;">&nbsp;</spane></td>';
      echo '<td ' . $estilo . '   >' . $row['nombre'] . '  <a href="javascript:void(0);" onclick="cargarDatosUser(' . $idUser . ',' . $idRuta . ')">Datos</a></td>';
      echo '<td ' . $estilo . '>' . $row['fechaCreacion'] . '</td>';
      echo '<td ' . $estilo . '>' . $row['puntoLlegada'] . '</td>';

      $estado = $row['estado'];
      if ($estado == 'S') {
        $estado = "Activa";
      }
      echo '<td ' . $estilo . '>' . $estado . '</td>';



      if (isset($_SESSION['privilegios']) and substr($_SESSION['privilegios'], 1, 1) == 1) {
        $actualizarMapa = 'NO';

        echo '<td ' . $estilo . '   ><a href="javascript:void(0);" onclick="cargarMapa(' . $idRuta . ')">Ruta</a></td>';


        //echo '<td ' . $estilo . '><a href="javascript:void(0);" onclick="generarReporte(' . "12". ')">Reporte</a></td>';
      } else {
        echo '<td ' . $estilo . '>&nbsp;</td><td ' . $estilo . '>&nbsp;</td>';
      }

      echo "</tr>";
    }

    echo "<script type='text/javascript' charset='utf-8' async defer>  
document.getElementById('numAlertas').textContent=" . $totalAlertas . ";   
document.getElementById('numRutasActivas').textContent=" . $totalRutasActivas . ";
document.getElementById('rutas').textContent=" . $rutas . "+' Rutas';
document.getElementById('rutasRecorridas').textContent=" . $rutasRecorridas . "+' Rutas Recorridas';
document.getElementById('alertasGrid').textContent=" . $alertas . "+' Alertas';
</script>";

    ?>
    </table>
</div>
<?php

?>