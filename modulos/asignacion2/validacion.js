$(function () {
  //getdata(0);
  $("#anio").val($("#anioActal").val());
});

function getdata(c) {
  let idGenPersona = $("#idGenPersona").val() > 0 ? $("#idGenPersona").val() : 0;
  $("#my-tbl").DataTable({
    destroy: true,
    responsive: true,
    processing: true,
    serverSide: true,
    pageLength: 10,
    autoWidth: false,
    language: {
      url: "../js/DataTables-1.10.21/language/Spanish.json",
    },
    sAjaxSource: `../${tgrid}?idGenPersona=${idGenPersona}`,
    columnDefs: [
      { width: 200, targets: 3 },
      { width: 200, targets: 4 },
    ],
    order: [[1, "desc"]],
    columns: [
      { data: "idDgoAsignacion" },
      { data: "descripcion" },
      { data: "meses" },
      { data: "anio" },
      {
        data: "modificacion",
        render: function (data, type, row, meta) {
          let btn = "";
          if (data) {
            btn += `<a href="javascript:void(0)" onclick="getregistro(${row["idDgoAsignacion"]})"><img src="../imagenes/btnEditar.png" width="20" height="20" title="Editar"></a>`;
          }
          if (row["eliminar"]) {
            btn += `<a href="javascript:void(0)" onclick="delregistro(${row["idDgoAsignacion"]})"><img src="../imagenes/btnEliminar.png" width="20" height="20" title="Eliminar"></a>`;
          }
          return btn;
        },
      },
    ],

    initComplete: function () {
      $("#dtListado").DataTable().columns.adjust().draw();
    },
  });
}

function buscaCursante() {
  if ($("#cedula").val() == "") {
  } else {
    $.ajax({
      type: "GET",
      url: "modulos/asignacion/includes/buscaCedula.php",
      data: "usuario=" + $("#cedula").val(),
      success: function (response) {
        result = response;
        if (result[0] > 0) {
          $("#idGenUsuario").val(result["idGenUsuario"]);
          $("#usuario").val(result["idGenUsuario"]);
          $("#apenom").val(result["siglasApenom"]);
          $("#email").val(result["email"]);
          $("#fono").val(result["fono"]);
          $("#idGenPersona").val(result["idGenPersona"]);
          $("#persona").val(result["idGenPersona"]);
          var id = $("#idGenUsuario").val();
          if (id > 0) {
            $(".seccion-visita").css("display", "block");
          } else {
            $(".seccion-visita").css("display", "none");
          }
          getdata();
        } else {
          $("#idGenUsuario").val("");
          $("#persona").val("");
          $("#apenom").val(result[2]);
          $("#email").val("");
          $("#fono").val("");
        }
      },
    });
  }
}

function validate_tipoSenplades(campoNivelSenplades, nivelSenplades, mensaje) {
  if (campoNivelSenplades.value != nivelSenplades && campoNivelSenplades.value != "") {
    return true;
  } else {
    alert(mensaje);
    return false;
  }
}

function validate(thisform) {
  with (thisform) {
    if (validate_enteros(idGenPersona, "Cursante", null, null) == false) {
      idGenPersona.focus();
      return false;
    }

    if (validate_enteros(idGenGeoSenplades, "Distribucion Senplades", null, null) == false) {
      idGenGeoSenplades.focus();
      return false;
    }

    // if (validate_combo(meses, "Meses") == false) {
    //   meses.focus();
    //   return false;
    // }

    if (validate_tipoSenplades(senplades, 0, "**No existe tipo nivel Senplades**") == false) {
      senplades.focus();
      return false;
    }
  }
  return true;
}
function limpiarCampos() {
  $("#cursante").val("");
  $("#persona").val(0);
  $("#cedula").val("");
  $("#email").val("");
  $("#fono").val("");
  getregistro(0);
  getdata(1);
}
