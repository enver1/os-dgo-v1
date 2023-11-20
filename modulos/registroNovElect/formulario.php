<?php
session_start();
header('Content-Type: text/html; charset=UTF-8');
include_once '../../../clases/autoload.php';
include_once 'config.php';

$formRegistroNovElec = new FormRegistroNovElec;
$RegistroNovElec     = new RegistroNovElec;
$encriptar           = new Encriptar;
$opc                 = strip_tags($_GET['opc']);
$rowt                = array();
$idDgoReciElect      = strip_tags($encriptar->getDesencriptar($_GET['c'], $_SESSION['usuarioAuditar']));

if ($idDgoReciElect > 0) {
  $rowt = $RegistroNovElec->getEditRegistroNovElec($idDgoReciElect);
}
$formRegistroNovElec->getFormularioRegistroNovElec($rowt, $RegistroNovElec->getIdCampoRegistroNovElec(), $opc);
?>
<script type="text/javascript">
  function cargaCmbRecintos(idGenGeoSenplaades) {
    $.post("modulos/registroNovElect/includes/cmbMuestraDispositivo.php", {
        idGenGeoSenplaades: idGenGeoSenplaades
      },
      function(resultado) {
        document.getElementById("idDgoReciElect").innerHTML = resultado;


      }
    );
  }

  function cargaJefe(idDgoReciElect) {
    $.post("modulos/registroNovElect/includes/cmbCargaJefe.php", {
        idDgoReciElect: idDgoReciElect
      },
      function(resultado) {
        document.getElementById("jefe").innerHTML = resultado;
        var porciones = resultado.split('|');
        $('#jefe').val(porciones[0]);
        $('#idOperativo').val(porciones[1]);
        $('#idDgoPerAsigOpe').val(porciones[2]);

      }
    );
  }

  function cargaCmbTipoNovedades(idDgoNovedadesElect) {
    var id1 = $('#idDgoTipoE').val();
    var id2 = $('#idDgoTipoE2').val();
    var id3 = $('#idDgoTipoE1').val();
    var id = 0;
    if (id1 != "") {
      id = $('#idDgoTipoE').val();
    } else if (id2 != "") {
      id = $('#idDgoTipoE2').val();
    } else if (id3 != "") {
      id = $('#idDgoTipoE1').val();
    }
    $.post("modulos/registroNovElect/includes/cmbMuestraNovedades.php", {
        idDgoNovedadesElect: idDgoNovedadesElect,
        id: id
      },
      function(resultado) {
        document.getElementById("idDgoNovedadesElect").innerHTML = resultado;
        verCampos(0);

      }
    );
  }

  function cargaCmbDelitosnovedades(idDgoNovedadesElect) {
    var id1 = $('#idDgoTipoE').val();
    var id2 = $('#idDgoTipoE2').val();
    var id3 = $('#idDgoTipoE1').val();
    var id = 0;
    if (id1 != "") {
      id = $('#idDgoTipoE').val();
    } else if (id2 != "") {
      id = $('#idDgoTipoE2').val();
    } else if (id3 != "") {
      id = $('#idDgoTipoE1').val();
    }
    $.post("modulos/registroNovElect/includes/cmbNovedadesHijasDelitos.php", {
        idDgoNovedadesElect: idDgoNovedadesElect,
        id: id
      },
      function(resultado) {
        document.getElementById("idDgoNovedadesElect1").innerHTML = resultado;
        //  verCampos(0);

      }
    );
  }

  function verCampos(novedad) {

    if ((novedad >= 10 && novedad <= 13) || (novedad >= 24 && novedad <= 27)) {
      $('#etDocumento').css('display', 'block');
      $('#documento').css('display', 'block');

      $('#etCedula').css('display', 'none');
      $('#cedula').css('display', 'none');

      $('#etBoleta').text('Número de Citación');
      $('#etBoleta').css('display', 'block');
      $('#boleta').css('display', 'block');
      $('#etLider').css('display', 'none');
      $('#lider').css('display', 'none');

      $('#imagen').css('display', 'none');
      $('#myfile').css('display', 'none');
      $('#etImagen').css('display', 'none');

    } else if ((novedad >= 6 && novedad <= 9)) {
      $('#etDocumento').css('display', 'block');
      $('#documento').css('display', 'block');

      $('#etCedula').css('display', 'none');
      $('#cedula').css('display', 'none');

      $('#etBoleta').text('Número de Cédula');
      $('#etBoleta').css('display', 'none');
      $('#boleta').css('display', 'none');

      $('#etLider').css('display', 'none');
      $('#lider').css('display', 'none');


      $('#imagen').css('display', 'none');
      $('#myfile').css('display', 'none');
      $('#etImagen').css('display', 'none');

    } else if ((novedad >= 14 && novedad <= 16)) {
      $('#etDispositivoHijo').css('display', 'block');
      $('#idDgoNovedadesElect1').css('display', 'block');

      $('#tidGenPersonaD').css('display', 'block');

      $('#etDocumento').css('display', 'none');
      $('#documento').css('display', 'none');

      $('#etCedula').css('display', 'none');
      $('#cedula').css('display', 'none');

      $('#etBoleta').text('Número de Boleta');
      $('#etBoleta').css('display', 'block');
      $('#boleta').css('display', 'block');
      $('#etLider').css('display', 'none');
      $('#lider').css('display', 'none');

      $('#imagen').css('display', 'none');
      $('#myfile').css('display', 'none');
      $('#etImagen').css('display', 'none');



      cargaCmbDelitosnovedades(novedad);

    } else if ((novedad == 19)) {
      $('#etCedula').css('display', 'block');
      $('#cedula').css('display', 'block');
      $('#etCedula').text('Hora Instlación (00:00)');

      $('#etDocumento').css('display', 'none');
      $('#documento').css('display', 'none');

      $('#etBoleta').css('display', 'none');
      $('#boleta').css('display', 'none');

      $('#imagen').css('display', 'block');
      $('#myfile').css('display', 'block');
      $('#etImagen').css('display', 'block');

      $('#etLider').css('display', 'none');
      $('#lider').css('display', 'none');
    } else if ((novedad == 20)) {
      $('#etCedula').css('display', 'block');
      $('#cedula').css('display', 'block');
      $('#etCedula').text('Motivo Cierre');

      $('#etDocumento').css('display', 'none');
      $('#documento').css('display', 'none');

      $('#etBoleta').css('display', 'none');
      $('#boleta').css('display', 'none');

      $('#imagen').css('display', 'block');
      $('#myfile').css('display', 'block');
      $('#etImagen').css('display', 'block');

      $('#etLider').css('display', 'none');
      $('#lider').css('display', 'none');
    } else if ((novedad == 21)) {
      $('#etCedula').css('display', 'block');
      $('#cedula').css('display', 'block');
      $('#etCedula').text('Cédula Servidor Policial');

      $('#etDocumento').css('display', 'none');
      $('#documento').css('display', 'none');

      $('#etBoleta').css('display', 'none');
      $('#boleta').css('display', 'none');

      $('#imagen').css('display', 'block');
      $('#myfile').css('display', 'block');
      $('#etImagen').css('display', 'block');

      $('#etLider').css('display', 'none');
      $('#lider').css('display', 'none');
    } else if ((novedad >= 22 && novedad <= 23)) {
      $('#etCedula').css('display', 'block');
      $('#cedula').css('display', 'block');
      $('#etCedula').text('Número de Manifestantes');

      $('#etDocumento').css('display', 'none');
      $('#documento').css('display', 'none');

      $('#etBoleta').css('display', 'block');
      $('#boleta').css('display', 'block');
      $('#etBoleta').text('Organización');

      $('#imagen').css('display', 'block');
      $('#myfile').css('display', 'block');
      $('#etImagen').css('display', 'block');

      $('#etLider').css('display', 'block');
      $('#lider').css('display', 'block');
      $('#etLider').text('Lider Organización');
    } else if ((novedad == 28)) {
      $('#etCedula').css('display', 'block');
      $('#cedula').css('display', 'block');
      $('#etCedula').text('Número de Manifestantes');

      $('#etDocumento').css('display', 'none');
      $('#documento').css('display', 'none');

      $('#etBoleta').css('display', 'block');
      $('#boleta').css('display', 'block');
      $('#etBoleta').text('Organización');

      $('#imagen').css('display', 'block');
      $('#myfile').css('display', 'block');
      $('#etImagen').css('display', 'block');

      $('#etLider').css('display', 'block');
      $('#lider').css('display', 'block');
      $('#etLider').text('Lider Organización');
    } else if ((novedad == 29)) {
      $('#etCedula').css('display', 'none');
      $('#cedula').css('display', 'none');

      $('#etDocumento').css('display', 'none');
      $('#documento').css('display', 'none');

      $('#etBoleta').css('display', 'none');
      $('#boleta').css('display', 'none');

      $('#imagen').css('display', 'block');
      $('#myfile').css('display', 'block');
      $('#etImagen').css('display', 'block');


      $('#etLider').css('display', 'none');
      $('#lider').css('display', 'none');
    } else if ((novedad == 30)) {
      $('#etDocumento').css('display', 'block');
      $('#documento').css('display', 'block');
      $('#etDocumento').text('Cédula Persona');

      $('#etCedula').css('display', 'none');
      $('#cedula').css('display', 'none');

      $('#etBoleta').css('display', 'block');
      $('#boleta').css('display', 'block');
      $('#etBoleta').text('Número Celular');

      $('#imagen').css('display', 'block');
      $('#myfile').css('display', 'block');
      $('#etImagen').css('display', 'block');


      $('#etLider').css('display', 'none');
      $('#lider').css('display', 'none');
    } else if ((novedad == 32)) {

      $('#etDocumento').css('display', 'none');
      $('#documento').css('display', 'none');

      $('#etCedula').css('display', 'block');
      $('#cedula').css('display', 'block');
      $('#etCedula').text('Numérico:');

      $('#etBoleta').css('display', 'none');
      $('#boleta').css('display', 'none');

      $('#imagen').css('display', 'none');
      $('#myfile').css('display', 'none');
      $('#etImagen').css('display', 'none');

      $('#etLider').css('display', 'none');
      $('#lider').css('display', 'none');
    } else if ((novedad == 33)) {

      $('#etCedula').css('display', 'block');
      $('#cedula').css('display', 'block');
      $('#etCedula').text('Numerico de Personal');

      $('#etDocumento').css('display', 'none');
      $('#documento').css('display', 'none');

      $('#etBoleta').css('display', 'none');
      $('#boleta').css('display', 'none');

      $('#imagen').css('display', 'block');
      $('#myfile').css('display', 'block');
      $('#etImagen').css('display', 'block');


      $('#etLider').css('display', 'none');
      $('#lider').css('display', 'none');
    } else if ((novedad >= 34 && novedad <= 37)) {
      $('#etCedula').css('display', 'block');
      $('#cedula').css('display', 'block');
      $('#etCedula').text('Número de Manifestantes');

      $('#etDocumento').css('display', 'none');
      $('#documento').css('display', 'none');

      $('#etBoleta').css('display', 'block');
      $('#boleta').css('display', 'block');
      $('#etBoleta').text('Organización');

      $('#imagen').css('display', 'block');
      $('#myfile').css('display', 'block');
      $('#etImagen').css('display', 'block');

      $('#etLider').css('display', 'block');
      $('#lider').css('display', 'block');
      $('#etLider').text('Lider Organización');
    } else if ((novedad >= 17 && novedad <= 18)) {
      $('#etCedula').css('display', 'none');
      $('#cedula').css('display', 'none');
      $('#etDocumento').css('display', 'none');
      $('#documento').css('display', 'none');
      $('#etBoleta').css('display', 'none');
      $('#boleta').css('display', 'none');

      $('#imagen').css('display', 'none');
      $('#myfile').css('display', 'none');
      $('#etImagen').css('display', 'none');

      $('#etLider').css('display', 'none');
      $('#lider').css('display', 'none');
    } else if ((novedad == 41)) {
      $('#etCedula').css('display', 'block');
      $('#cedula').css('display', 'block');
      $('#etCedula').text('Función:');

      $('#etDocumento').css('display', 'none');
      $('#documento').css('display', 'none');

      $('#etBoleta').css('display', 'block');
      $('#boleta').css('display', 'block');
      $('#etBoleta').text('Nombres:');

      $('#imagen').css('display', 'none');
      $('#myfile').css('display', 'none');
      $('#etImagen').css('display', 'none');

      $('#etLider').css('display', 'none');
      $('#lider').css('display', 'none');


    } else if ((novedad == 42)) {
      $('#etCedula').css('display', 'block');
      $('#cedula').css('display', 'block');
      $('#etCedula').text('Nombres Instalación:');

      $('#etDocumento').css('display', 'none');
      $('#documento').css('display', 'none');

      $('#etBoleta').css('display', 'block');
      $('#boleta').css('display', 'block');
      $('#etBoleta').text('Descripción:');

      $('#imagen').css('display', 'block');
      $('#myfile').css('display', 'block');
      $('#etImagen').css('display', 'block');
      $('#etImagen').text('Foto:');
      $('#etLider').css('display', 'none');
      $('#lider').css('display', 'none');

    } else if ((novedad == 43)) {
      $('#etCedula').css('display', 'block');
      $('#cedula').css('display', 'block');
      $('#etCedula').text('Dirección:');

      $('#etDocumento').css('display', 'none');
      $('#documento').css('display', 'none');

      $('#etBoleta').css('display', 'block');
      $('#boleta').css('display', 'block');
      $('#etBoleta').text('Descripción:');

      $('#imagen').css('display', 'block');
      $('#myfile').css('display', 'block');
      $('#etImagen').css('display', 'block');

      $('#etLider').css('display', 'none');
      $('#lider').css('display', 'none');

    } else if ((novedad == 44)) {
      $('#etCedula').css('display', 'block');
      $('#cedula').css('display', 'block');
      $('#etCedula').text('Unidad:');

      $('#etDocumento').css('display', 'none');
      $('#documento').css('display', 'none');

      $('#etBoleta').css('display', 'none');
      $('#boleta').css('display', 'none');


      $('#imagen').css('display', 'none');
      $('#myfile').css('display', 'none');
      $('#etImagen').css('display', 'none');

      $('#etLider').css('display', 'none');
      $('#lider').css('display', 'none');

    } else if ((novedad == 45 || novedad == 46)) {

      $('#etDocumento').css('display', 'none');
      $('#documento').css('display', 'none');

      $('#etCedula').css('display', 'block');
      $('#cedula').css('display', 'block');
      $('#etCedula').text('Nombres:');

      $('#etBoleta').css('display', 'block');
      $('#boleta').css('display', 'block');
      $('#etBoleta').text('Cargo/Función:');

      $('#imagen').css('display', 'none');
      $('#myfile').css('display', 'none');
      $('#etImagen').css('display', 'none');

      $('#etLider').css('display', 'block');
      $('#lider').css('display', 'block');
      $('#etLider').text('Grado (Opcional):');

    } else if ((novedad == 47)) {

      $('#etDocumento').css('display', 'none');
      $('#documento').css('display', 'none');

      $('#etCedula').css('display', 'block');
      $('#cedula').css('display', 'block');
      $('#etCedula').text('Nombres:');

      $('#etBoleta').css('display', 'block');
      $('#boleta').css('display', 'block');
      $('#etBoleta').text('Medio de Comunicación:');

      $('#imagen').css('display', 'none');
      $('#myfile').css('display', 'none');
      $('#etImagen').css('display', 'none');

      $('#etLider').css('display', 'none');
      $('#lider').css('display', 'none');
    } else if ((novedad >= 49 && novedad <= 53)) {

      $('#etDocumento').css('display', 'none');
      $('#documento').css('display', 'none');

      $('#etCedula').css('display', 'block');
      $('#cedula').css('display', 'block');
      $('#etCedula').text('Numérico:');

      $('#etBoleta').css('display', 'none');
      $('#boleta').css('display', 'none');

      $('#imagen').css('display', 'none');
      $('#myfile').css('display', 'none');
      $('#etImagen').css('display', 'none');

      $('#etLider').css('display', 'none');
      $('#lider').css('display', 'none');
    } else if ((novedad >= 54 && novedad <= 55)) {

      $('#etDocumento').css('display', 'none');
      $('#documento').css('display', 'none');

      $('#etCedula').css('display', 'block');
      $('#cedula').css('display', 'block');
      $('#etCedula').text('Hora(00:00):');

      $('#etBoleta').css('display', 'none');
      $('#boleta').css('display', 'none');

      $('#imagen').css('display', 'none');
      $('#myfile').css('display', 'none');
      $('#etImagen').css('display', 'none');

      $('#etLider').css('display', 'none');
      $('#lider').css('display', 'none');
    } else {
      $('#etCedula').css('display', 'none');
      $('#cedula').css('display', 'none');
      $('#etDocumento').css('display', 'none');
      $('#documento').css('display', 'none');
      $('#etBoleta').css('display', 'none');
      $('#boleta').css('display', 'none');

      $('#imagen').css('display', 'none');
      $('#myfile').css('display', 'none');
      $('#etImagen').css('display', 'none');

      $('#etLider').css('display', 'none');
      $('#lider').css('display', 'none');
      $('#etDispositivoHijo').css('display', 'none');
      $('#idDgoNovedadesElect1').css('display', 'none');

      $('#tidGenPersonaD').css('display', 'none');

    }
  }
</script>
<script type="text/javascript">
  $(function() {
    verCampos($('#idDgoNovedadesElect').val());

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

  function buscaConductorB() {
    if ($('#cedulaPersonaD').val() == '') {
      Swal.fire(
        'Ingrese un Número de Cédula',
        'Registro de Novedades',
        'info'
      )
      limpiarR();
    } else {
      $.ajax({
        type: 'GET',
        url: 'modulos/verificacionPer/includes/buscaCedulaCiu.php',
        data: 'cedula=' + $('#cedulaPersonaD').val(),
        success: function(response) {
          result = JSON.parse(response);
          if (result['codeResponse'] > 0) {
            $('#nombrePersonaD').val(result['datos']['apenom']);
            $('#idGenPersonaD').val(result['datos']['idGenPersona']);
          } else {
            Swal.fire(
              result['-------??' + 'msj'],
              'Registro de Novedades',
              'info'
            )
            $('#idGenPersonaD').val('');
            $('#nombrePersonaD').val('');
            $('#cedulaPersonaD').val('');

          }
        }
      });
    }

  }


  function buscaConductor() {
    if ($('#cedulaPersonaC').val() == '') {
      Swal.fire(
        'Ingrese un Número de Cédula',
        'Registro de Novedades',
        'info'
      )
      limpiarR();
    } else {
      $.ajax({
        type: 'GET',
        url: 'modulos/verificacionPer/includes/buscaCedulaCiu.php',
        data: 'cedula=' + $('#cedulaPersonaC').val(),
        success: function(response) {
          result = JSON.parse(response);
          if (result['codeResponse'] > 0) {
            $('#nombrePersonaC').val(result['datos']['apenom']);
            $('#idGenPersona').val(result['datos']['idGenPersona']);
            buscaDatosConductor(result['datos']['idGenPersona']);
          } else {
            Swal.fire(
              result['-------??' + 'msj'],
              'Registro de Novedades',
              'info'
            )
            $('#idGenPersona').val('');
            $('#nombrePersonaC').val('');
            $('#cedulaPersonaC').val('');

          }
        }
      });
    }

  }

  function buscaConductor1() {
    if ($('#cedulaPersonaC').val() == '') {
      $('#nombrePersonaC').val('');
      $('#idGenPersona').val('');
      alert('EL CAMPO CÉDULA NO PUEDE ESTAR EN BLANCO');
    } else {
      var str = $('#cedulaPersonaC').val();
      var n = str.length;
      if (n != 10) {
        $('#nombrePersonaC').val('');
        $('#idGenPersona').val('');
        $('#cedulaPersonaC').val('');
        alert('LA CEDULA INGRESADA NO ES VALIDA');
      } else {
        $.ajax({
          type: 'GET',
          url: 'includes/buscaCedula.php',
          data: 'usuario=' + $('#cedulaPersonaC').val(),
          success: function(response) {
            result = response;
            if (result[0] > 0) {
              $('#nombrePersonaC').val(result[1]);
              $('#idGenPersona').val(result[0]);
              buscaDatosConductor((result[0]));
            } else {
              $('#idGenPersona').val('');
              $('#nombrePersonaC').val(result[1]);
            }
          }
        });
      }
    }
  }

  function buscaDatosConductor(idGenPersona) {
    $.post("modulos/registroNovElect/includes/buscaDatosConductor.php", {
        idGenPersona: idGenPersona
      },
      function(resultado) {
        $datos = resultado.split("|");
        var idT = $datos[0];
        var idT1 = $datos[1];
        var idT2 = $datos[2];
        if ($datos[3] == '') {
          // $('#descProcElecc').val('El Recinto o Unidad se encuentra Cerrado');
          Swal.fire(
            'El Operativo en esta Unidad o Recinto ha Finalizado',
            'No Puede Registrar Novedades',
            'info'
          )
          die();
        } else {
          $('#descProcElecc').val($datos[3]);
        }
        $('#jefe').val($datos[4]);
        $('#unidad').val($datos[9]);
        $('#idOperativo').val($datos[8]);
        $('#idDgoPerAsigOpe').val($datos[10]);
        // $('#latitud').val($datos[11]);
        // $('#longitud').val($datos[12]);

        if (idT != "") {
          $('#etTipoEje').css('display', 'block');
          $('#idDgoTipoEje2').css('display', 'block');

          $('#etUnidad').css('display', 'block');
          $('#idDgoTipoEje').css('display', 'block');

          $('#idDgoTipoEje').val($datos[7]);
          $('#idDgoTipoEje2').val($datos[6]);
          $('#idDgoTipoEje1').val($datos[5]);

          $('#idDgoTipoE').val($datos[2]);
          $('#idDgoTipoE2').val($datos[1]);
          $('#idDgoTipoE1').val($datos[0]);

        } else if (idT1 != "") {
          $('#etTipoEje').css('display', 'block');
          $('#idDgoTipoEje2').css('display', 'block');
          $('#idDgoTipoEje2').val($datos[7]);
          $('#idDgoTipoE2').val($datos[0]);

          $('#etUnidad').css('display', 'none');
          $('#idDgoTipoEje').css('display', 'none');
          $('#idDgoTipoEje1').val($datos[6]);
          $('#idDgoTipoE').val();
          $('#idDgoTipoEje').val();
          $('#idDgoTipoE1').val($datos[2]);

        } else if (idT2 != "") {
          $('#etUnidad').css('display', 'none');
          $('#idDgoTipoEje').css('display', 'none');
          $('#etTipoEje').css('display', 'none');
          $('#idDgoTipoEje2').css('display', 'none');
          $('#idDgoTipoEje').val();
          $('#idDgoTipoEje2').val();
          $('#idDgoTipoE').val();
          $('#idDgoTipoE2').val();

          $('#idDgoTipoEje1').val($datos[7]);
          $('#idDgoTipoE1').val($datos[2]);
        }

      }
    );
  }

  function buscaDatosConductorEditar(idDgoNovReciElec) {
    if (idDgoNovReciElec > 0) {
      $.post("modulos/registroNovElect/includes/buscaDatosConductorEditar.php", {
          idDgoNovReciElec: idDgoNovReciElec
        },
        function(resultado) {

          $datos = resultado.split("|");
          var idT = $datos[0];
          var idT1 = $datos[1];
          var idT2 = $datos[2];

          $('#descProcElecc').val($datos[3]);
          $('#jefe').val($datos[4]);

          $('#unidad').val($datos[9]);
          $('#idOperativo').val($datos[8]);
          $('#idDgoPerAsigOpe').val($datos[10]);
          if (idT != "") {
            $('#etTipoEje').css('display', 'block');
            $('#idDgoTipoEje2').css('display', 'block');
            $('#etUnidad').css('display', 'block');
            $('#idDgoTipoEje').css('display', 'block');

            $('#idDgoTipoEje').val($datos[7]);
            $('#idDgoTipoEje2').val($datos[6]);
            $('#idDgoTipoEje1').val($datos[5]);


            $('#idDgoTipoE').val($datos[2]);
            $('#idDgoTipoE2').val($datos[1]);
            $('#idDgoTipoE1').val($datos[0]);

          } else if (idT1 != "") {
            $('#etTipoEje').css('display', 'block');
            $('#idDgoTipoEje2').css('display', 'block');
            $('#idDgoTipoEje2').val($datos[7]);
            $('#idDgoTipoE2').val($datos[0]);
            $('#etUnidad').css('display', 'none');
            $('#idDgoTipoEje').css('display', 'none');
            $('#idDgoTipoEje1').val($datos[6]);
            $('#idDgoTipoE').val();
            $('#idDgoTipoEje').val();
            $('#idDgoTipoE1').val($datos[2]);
          } else if (idT2 != "") {
            $('#etUnidad').css('display', 'none');
            $('#idDgoTipoEje').css('display', 'none');
            $('#etTipoEje').css('display', 'none');
            $('#idDgoTipoEje2').css('display', 'none');
            $('#idDgoTipoEje').val();
            $('#idDgoTipoEje2').val();
            $('#idDgoTipoE').val();
            $('#idDgoTipoE2').val();
            $('#idDgoTipoEje1').val($datos[7]);
            $('#idDgoTipoE1').val($datos[2]);
          }
        }
      );
    }

  }




  function limpiarR() {
    $('#idGenPersona').val('');
    $('#nombrePersonaC').val('');
    $('#cedulaPersonaC').val('');
    $('#idOperativo').val('');
    $('#idDgoTipoEje').val('');
    $('#idDgoTipoEje1').val('');
    $('#idDgoTipoEje2').val('');

    $('#unidad').val('');
    $('#jefe').val('');
    $('#descProcElecc').val('');
  }

  function limpiarD() {
    $('#idGenPersonaD').val('');
    $('#nombrePersonaD').val('');
    $('#cedulaPersonaD').val('');
  }
</script>
<script type="text/javascript">
  $(function() {
    getEjeRecinto1($('#idDgoTipoEje').val());
    getEjeRecinto($('#idDgoTipoEje2').val());
    buscaDatosConductorEditar($('#idDgoNovReciElec').val())
  });


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