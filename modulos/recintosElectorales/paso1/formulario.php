<?php
session_start();
header('Content-Type: text/html; charset=UTF-8');
include_once '../../../../clases/autoload.php';
include_once 'config.php';

$formRecintoElectoral = new FormRecintoElectoral;
$RecintoElectoral     = new RecintoElectoral;
$encriptar            = new Encriptar;
$opc                  = strip_tags($_GET['opc']);
$rowt                 = array();
$idDgoReciElect       = strip_tags($encriptar->getDesencriptar($_GET['c'], $_SESSION['usuarioAuditar']));

if ($idDgoReciElect > 0) {
  $rowt = $RecintoElectoral->getEditRecintoElectoral($idDgoReciElect);
}
$formRecintoElectoral->getFormularioRecintoElectoral($rowt, $RecintoElectoral->getIdCampoRecintoElectoral(), $opc);
?>

<script type="text/javascript">
  function buscaZSDCS() {
    var lati = $('#latitud').val();
    var longi = $('#longitud').val()
    $.ajax({
      type: 'GET',
      url: 'includes/maps/getSenplades.php',
      data: {
        latitud: lati,
        longitud: longi
      },
      success: function(response) {
        result = eval(response);
        if (result[2] > 0) {
          var divpol = result[1] + ' (' + result[0] + ')';
          $('#senpladesDescripcion').val(divpol);
          $('#idGenGeoSenplades').val(result[2]);
        }
      }
    });
  }
</script>
<script type="text/javascript">
  $(function() {
    $('#idRecinto').val($('#idDgoReciElect').val());
  });
</script>

<script type="text/javascript">
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
    var idT = $('#idDgoTipoEje').val();
    var idT1 = $('#idDgoTipoEje1').val();
    var idT2 = $('#idDgoTipoEje2').val();

    getEjeRecinto1($('#idDgoTipoEje').val());
    getEjeRecinto($('#idDgoTipoEje2').val());
    $('#idDgoT').val($('#idDgoT1').val());

    if ((idT2 == "" && idT1 > 1)) {
      $('#idDgoTipoEje1').val(idT1);
      $('#etTipoEje').css('display', 'block');
      $('#idDgoTipoEje2').css('display', 'block');
      $('#idDgoTipoEje2').val(idT);

      $('#etUnidad').css('display', 'none');
      $('#idDgoTipoEje').css('display', 'none');
      $('#idDgoTipoEje').val('');
    }



  });
</script>