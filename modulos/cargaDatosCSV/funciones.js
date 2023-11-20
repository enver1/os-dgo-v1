function getFormulario(c) {
  var urlt = `${tforma}?opc=${opc}&c=${c}`;
  $("#formulario").html('<p><img src="../funciones/paginacion/images/ajax-loader.gif" /></p>');
  $("#formulario").load(urlt);
  $("html, body").animate({
    scrollTop: 0,
  }, "slow");
}

function getData() {
  var urlt = `${tgrid}?opc=${opc}`;
  $('#my-tbl').DataTable({
    ajax: urlt,
    language: {
      "url": "../../../../js/DataTables-1.10.21/language/Spanish.json"
    },
    columns: [{
      "data": "anio"
    }, {
      "data": "descMes"
    }, {
      "data": "identificador"
    }, {
      "data": "total"
    }]
  });
}

function cargaDatos() {
  if (validate(document.getElementById("edita"))) {
    notificacionLoading();
    setTimeout(function() {
      enviarData();
    }, 500);
  }
}

function enviarData() {
  let $inputs = $("#edita :input");
  let form_data = new FormData();
  $inputs.each(function() {
    if (this.type == "file") {
      form_data.append([this.name], $(this).prop("files")[0]);
    } else {
      form_data.append([this.name], $(this).val());
    }
  });
  $.ajax({
    url: tgraba,
    dataType: "text",
    cache: false,
    contentType: false,
    processData: false,
    data: form_data,
    type: "POST",
    //async: false,
    success: function(response) {
      result = JSON.parse(response);
      $("#dialog-loading").dialog("close");
      if (result['success']) {
        console.log('true');
        $("#dialog-text").html(`<p class="texto_azul">${result.message}</p>`);
        getFormulario(0);
        $('#my-tbl').DataTable().ajax.reload();
      } else {
        $("#dialog-text").html(`<p class="texto_red">${result.message}</p>`);
      }
      notificacion();
    },
  });
}

function notificacionLoading() {
  $("#dialog-loading").dialog({
    resizable: false,
    height: "auto",
    width: 400,
    modal: true,
    closeOnEscape: false,
    draggable: false,
    open: function(event, ui) {
      $(this).parent().children().children(".ui-dialog-titlebar-close").hide();
    },
    position: {
      my: "center",
      at: "center",
      of : $("#contenido"),
    },
  });
}

function notificacion() {
  $("#dialog-confirm").dialog({
    resizable: false,
    height: "auto",
    width: 400,
    modal: true,
    closeOnEscape: false,
    draggable: false,
    open: function(event, ui) {
      $(this).parent().children().children(".ui-dialog-titlebar-close").hide();
    },
    position: {
      my: "center",
      at: "center",
      of : $("#contenido"),
    },
    buttons: {
      OK: function() {
        $(this).dialog("close");
      },
    },
  });
}

function validate(thisform) {
  with(thisform) {
    if (validate_combo(cedula, 'Año') == false) {
      cedula.focus();
      return false;
    }
    if (validate_combo(numerico, 'Mes') == false) {
      numerico.focus();
      return false;
    }
    if (validate_combo(numerico1, 'Tipo') == false) {
      numerico1.focus();
      return false;
    }
    if (validate_requiredmax(separador, 'Separador de Campos', 1) == false) {
      separador.focus();
      return false;
    }
    if (validate_requiredmax(filasCabecera, 'Nro. de filas de cabecera', 1) == false) {
      filasCabecera.focus();
      return false;
    }
    if (validate_enteros(filasCabecera, 'Nro. de filas de cabecera', 1, 1) == false) {
      filasCabecera.focus();
      return false;
    }
    if (validate_required(myfile, 'Archivo de Datos ') == false) {
      myfile.focus();
      return false;
    }
  }
  return true;
}