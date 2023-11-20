<?php
include_once('../../../clases/autoload.php');
$conn = DB::getConexionDB();
?>
<table border="0" cellspacing="0" cellpadding="0" style="900px">
  <?php
  $sql = "SELECT a.idDgoProcSuper,a.descripcion,fechaInicio,fechaFinal,b.descripcion estado,a.idGenEstado,
          group_concat(ej.descDgoEje,' ') ejes
          from dgoProcSuper a
          join genEstado b on a.idGenEstado=b.idGenEstado 
          left join dgoEjeProcSu eps on a.idDgoProcSuper=eps.idDgoProcSuper
          left join dgoEje ej on eps.idDgoEje=ej.idDgoEje
          group by a.idDgoProcSuper
          order by fechaInicio,a.idDgoProcSuper desc limit 25";
  $rsB = $conn->query($sql);
  $i = 1;
  echo '	<tr>';
  while ($rowB = $rsB->fetch()) {
    $ancho = 100;
    if ($rowB['idGenEstado'] == 1)
      $fofo = '#090';
    else
      $fofo = '#c00';
  ?>
    <td class="marco">
      <div id="f1_container">
        <div id="f1_card" class="shadow">
          <div class="front face">
            <p style="text-align:center"><img src="../../../imagenes/escudofinal.png" style="width:80px;height:90px" /></p>
            <br>&nbsp;<span style="background-color:<?php echo $fofo ?>;padding:5px;border:solid 1px #888">&nbsp;&nbsp;</span><br>
            <p><span style="font-size:14px"><?php echo $rowB['descripcion'] ?></span></p>
            <span style="margin-left:10px;font-size:12px;font-weight:bold"><?php echo $rowB['fechaInicio'] ?></span>
          </div>
          <div class="back face center">
            <a href="javascript:void(0)" onClick="entrar('<?php echo $rowB['idDgoProcSuper'] ?>')" class="barra">
              <p style="font-weight:bold"><?php echo $rowB['descripcion'] ?></p>
              <p>
                <hr /><span style="font-weight:bold">Inicia:</span><?php echo $rowB['fechaInicio'] ?>
                <br /><span style="font-weight:bold">Termina:</span> <?php echo $rowB['fechaFinal'] ?>
                <br /><span style="font-weight:bold">Estado:</span> <?php echo $rowB['estado'] ?>
                <br /><span style="font-weight:bold">Ejes:</span> <span style="font-size:8px"><?php echo $rowB['ejes'] ?></span>
              </p>
            </a>
          </div>
        </div>
      </div>
    </td>
  <?php
    if ($i > 4) {
      $i = 0;
      echo '</tr><tr>';
    }
    $i++;
  }
  echo '</tr>';
  ?>
</table>