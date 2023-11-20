<?php
session_start();
header('Content-Type: text/html; charset=UTF-8');
include_once 'config.php';
include_once '../../../clases/autoload.php';
include_once '../../../funciones/funcion_select.php';

$tgrid            = $directorio . '/grid.php'; // php para mostrar la grid
$tforma           = $directorio . '/formulario.php'; // php para mostrar el formulario en la parte superior
$tborra           = $directorio . '/borra.php'; // php para borrar un registro
$tgraba           = $directorio . '/graba.php'; // php para grabar un registro
$tprint           = $directorio . '/imprime.php'; // nombre del php que imprime los registros
$sqgrid           = sha1('novedadesEje');
$FormNovedadesEje = new FormNovedadesEje;
$NovedadesEje     = new NovedadesEje;
$encriptar        = new Encriptar;
$opc              = strip_tags($_GET['opc']);
$Ntabla           = 'dgoNovedadesEje';
$idcampo          = ucfirst($Ntabla);
$rowt             = array();
$id               = strip_tags($encriptar->getDesencriptar($_GET['c'], $_SESSION['usuarioAuditar']));

if (isset($_GET['c'])) {
  $rowt = $NovedadesEje->getEditNovedadesEje($id);
}

?>
<script type="text/javascript">
  $(function() {
    // $('#idDgoProcElec').val($('#idProceso').val());
    $('#botonera').css('display', 'none');
  });
</script>
<script>
  $(document).ready(function() {

    $('#tapp').tree({
      onClick: function(node) {
        var node = $('#tapp').tree('getSelected');
        $('#paisDesc').attr('value', node.text);
        $('#paisCdg').attr('value', node.id);
        $("html, body").animate({
          scrollTop: 0
        }, "slow");

      }
    });
  });
  //BORRAR BOTONERA

  function grabaregistroUserApp(c, d) {

    var targetURL = 'modulos/muestraresultados.php?page=1&grilla=<?php echo $tgrid ?>&opc=<?php echo $_GET['opc'] ?>&modl=<?php echo $sqgrid ?>';
    var $inputs = $('#edita :input');
    var values = {};
    $inputs.each(function() {
      values[this.name] = $(this).val();
    });
    /* Valida permisos y privilegios sobre la BDD*/
    var id = values[d];
    if (c == '2' && !(id == "" || id == "0" || typeof(id) == 'undefined')) {
      alert('No tiene permisos para Modificar Registros');
      return;
    }
    if (c == '3' && (id == "" || id == "0" || typeof(id) == 'undefined')) {
      alert('No tiene permisos para Insertar Nuevos Registros');
      return
    }
    if (validate(document.getElementById("edita"))) {
      var result = '';
      var $forma = $('html,body');
      var seleccionados = getChecked();

      $.ajax({
        type: "POST",
        url: "modulos/novedadesEje/graba.php?&sele=" + seleccionados,
        data: values,
        success: function(response) {
          result = response;
          result = eval(response);
          alert(result[1]);
          if (result[0]) {
            getregistro(0);
            getdata(1);
          }
        }
      });
    }
  }

  function getChecked() {
    var nodes = $('#tapp').tree('getChecked');
    var s = '';
    for (var i = 0; i < nodes.length; i++) {
      if (s != '') {
        s += ',';
      }
      s += nodes[i].id;
    }
    return s;
  }



  function getEjeRecinto(resultado) {
    if (resultado > 1) {
      $('#etTipoEje').css('display', 'block');
      $('#idDgoTipoEje2').css('display', 'block');

    } else {
      $('#etTipoEje').css('display', 'none');
      $('#idDgoTipoEje2').css('display', 'none');
      $('#idDgoTipoEje2').val('');
      $('#etUnidad').css('display', 'none');
      $('#idDgoTipoEje').css('display', 'none');
      $('#idDgoTipoEje').val('');

    }
  }

  function getEjeRecinto1(resultado) {
    if (resultado > 0) {
      $('#etUnidad').css('display', 'block');
      $('#idDgoTipoEje').css('display', 'block');
    } else {
      $('#etUnidad').css('display', 'none');
      $('#idDgoTipoEje').css('display', 'none');
      $('#idDgoTipoEje').val('');

    }
  }

  function cargaCmbEje(idTipoEje1) {
    verificaEje(idTipoEje1);
    $.post("modulos/recintosElectorales/paso1/includes/cmbMuestraEje.php", {
        idTipoEje1: idTipoEje1
      },
      function(resultado) {
        document.getElementById("idDgoTipoEje2").innerHTML = resultado;
      }
    );
  }

  function verificaEje(idTipoEje1) {
    $.post("modulos/recintosElectorales/paso1/includes/cmbVerificaEje.php", {
        idTipoEje1: idTipoEje1
      },
      function(resultado) {
        if (resultado > 0) {
          $('#auxiliar').val('');
          $('#etTipoEje').css('display', 'block');
          $('#idDgoTipoEje2').css('display', 'block');

        } else {
          $('#etTipoEje').css('display', 'none');
          $('#idDgoTipoEje2').css('display', 'none');
          $('#idDgoTipoEje2').val('');
          $('#etUnidad').css('display', 'none');
          $('#idDgoTipoEje').css('display', 'none');
          $('#idDgoTipoEje').val('');
          $('#auxiliar').val(idTipoEje1);
        }
      }
    );
  }


  function cargaCmbEje1(idTipoEje1) {
    verificaEje1(idTipoEje1);
    $.post("modulos/recintosElectorales/paso1/includes/cmbMuestraEje.php", {
        idTipoEje1: idTipoEje1
      },
      function(resultado) {
        document.getElementById("idDgoTipoEje").innerHTML = resultado;

      }
    );
  }

  function verificaEje1(idTipoEje1) {
    $.post("modulos/recintosElectorales/paso1/includes/cmbVerificaEje.php", {
        idTipoEje1: idTipoEje1
      },
      function(resultado) {
        if (resultado > 0) {
          $('#auxiliar').val('');
          $('#etUnidad').css('display', 'block');
          $('#idDgoTipoEje').css('display', 'block');
        } else {
          $('#etUnidad').css('display', 'none');
          $('#idDgoTipoEje').css('display', 'none');
          $('#idDgoTipoEje').val('');
          $('#auxiliar').val(idTipoEje1);
        }
      }
    );
  }
</script>
<script type="text/javascript">
  $(function() {

    var id = $('#idDgoTipoEje').val();
    var id1 = $('#idDgoTipoEje1').val();
    var id2 = $('#idDgoTipoEje2').val();


    getEjeRecinto($('#idDgoTipoEje2').val());
    getEjeRecinto1($('#idDgoTipoEje').val());
    $('#idDgoT').val($('#idDgoT1').val());


    if ($('#idDgoNovedadesEje').val() > 0) {
      $('#etDescripcion').css('display', 'block');
      $('#descripcion').css('display', 'block');
      $('#etEstado').css('display', 'block');
      $('#idGenEstado').css('display', 'block');
    } else {
      $('#etDescripcion').css('display', 'none');
      $('#descripcion').css('display', 'none');
      $('#etEstado').css('display', 'none');
      $('#idGenEstado').css('display', 'none');
    }
    if (id2 == '') {
      $('#etTipoEje').css('display', 'block');
      $('#idDgoTipoEje2').css('display', 'block');
      $('#idDgoTipoEje2').val(id);

      $('#etUnidad').css('display', 'none');
      $('#idDgoTipoEje').css('display', 'none');
      $('#idDgoTipoEje').val('');
    }
    if ((id == '') && (id1 != '') && (id2 == '')) {

      $('#idDgoTipoEje1').val(id1);


      $('#etTipoEje').css('display', 'none');
      $('#idDgoTipoEje2').css('display', 'none');
      $('#idDgoTipoEje2').val('');

      $('#etUnidad').css('display', 'none');
      $('#idDgoTipoEje').css('display', 'none');
      $('#idDgoTipoEje').val('');
    }
    if ((id == '') && (id1 == '') && (id2 == '')) {

      $('#etTipoEje').css('display', 'none');
      $('#idDgoTipoEje2').css('display', 'none');
      $('#idDgoTipoEje2').val('');

      $('#etUnidad').css('display', 'none');
      $('#idDgoTipoEje').css('display', 'none');
      $('#idDgoTipoEje').val('');
    }


  });
</script>

</script>
<?php
$FormNovedadesEje->getFormularioNovedadesEje($rowt, $NovedadesEje->getIdCampoNovedadesEje(), $opc);
?>
<table width="100%" align="center">
  </form align="center">
  </td>
  <tr>
    <td>
      <input type="hidden" readonly="readonly" size="5" name="paisCdg" id="paisCdg" value="<?php echo isset($rowt['idDgoTipoEje']) ? $rowt['idDgoTipoEje'] : '' ?>" class="inputSombra" style="width:50px" />
      <input type="hidden" readonly="readonly" size="5" name="isRecinto" id="isRecinto" value="<?php echo isset($rowt['isRecinto']) ? $rowt['isRecinto'] : '' ?>" class="inputSombra" style="width:50px" />
      <input type="<?php echo (isset($rowt['idDgoTipoEje']) and $rowt['idDgoTipoEje'] > 0) ? 'hidden' : 'hidden' ?>" id="paisDesc" name="paisDesc" value="<?php echo isset($rowt['padre']) ? $rowt['padre'] : '' ?>" size="48" class="inputSombra" style="width:280px" readonly="readonly" />
    </td>
  </tr>
  <td width="45%" valign="top">
    <div style=" overflow: scroll; height:300px">
      <ul id="tapp" class="easyui-tree" animate="true" style="font-size:10px" checkbox="true" onlyLeafCheck="false" url="<?php echo '../' . $directorioC ?>/tree_unidad_todo.php?id=<?php echo (isset($_GET['id']) ? $_GET['id'] : 0) ?>&buscado=<?php echo (isset($_GET['usuario']) ? $_GET['usuario'] : 0) ?>">
      </ul>
    </div>
  </td>
  </tr>
</table>

<div style="margin: 0 auto;">
  <table width="100%" border="0">
    <tr>
      <td>
        <?php if (isset($_SESSION['privilegios']) and substr($_SESSION['privilegios'], 0, 1) == 1) { ?>
          <input type="button" name="nuevo" onclick="getregistro(0)" value="Nuevo" class="boton_new" />
        <?php } else { ?>
          &nbsp;
        <?php } ?>
      </td>
      <td>
        <?php /* De acuerdo a los privilegios ejecuta la funcion GRABAREGISTRO() y pasa el parametro 1, 2 o 3mas el nombre del id del campo*/
        if (isset($_SESSION['privilegios'])) {
          switch (substr($_SESSION['privilegios'], 0, 2)) {
            case '11': //SI Insert y SI Update
              echo '<input type="button" name="enviar" onclick="grabaregistroUserApp(1,\'id' . $idcampo . '\')" value="Grabar"  class="boton_save" />';
              break;
            case '10': //SI Insert y NO Update
              echo '<input type="button" name="enviar" onclick="grabaregistroUserApp(2,\'id' . $idcampo . '\')" value="Grabar"  class="boton_save" />';
              break;
            case '01': // NO Insert y SI Update
              echo '<input type="button" name="enviar" onclick="grabaregistroUserApp(3,\'id' . $idcampo . '\')" value="Grabar"  class="boton_save" />';
              break;
            case '00': // NO Insert y NO Update
              echo '&nbsp;';
              break;
          }
        } ?>
      </td>
    </tr>
  </table>
</div>