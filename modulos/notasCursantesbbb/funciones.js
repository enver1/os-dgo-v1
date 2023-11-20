$('#anio').on('change', function() {
  if (this.value>=2021) {
    $('#eidGenGeoSenplades').css('display','none');
    $('#idGenGeoSenplades').css('display','none');
    $('#eidGenGeoSenplades').val('');
  } else {
    $('#eidGenGeoSenplades').css('display','block');
    $('#idGenGeoSenplades').css('display','block');
  }
});

function excelNotas() {
  var ok = true;
  var anio = $("#anio").val();
  var geo = $("#idGenGeoSenplades").val();
  var url = "modulos/notasCursantes/notasExcel.php?anio=" + anio + "&geo=" + geo;
  var l = screen.width;
  var t = screen.height;
  var opts = 'scrollbars=yes,toolbar=no,width=' + screen.width + ',height=' + screen.height + ',top=' + t + ' ,left=' + l;
  var name = 'Reporte Notas';

  if (validate_combo(document.getElementById('anio'), 'Año') == false) {
    document.getElementById('anio').focus();
    ok = false;
    return;
  }

  if (anio<=2020) {
    if (validate_combo(document.getElementById('idGenGeoSenplades'), 'Zona') == false) {
      document.getElementById('idGenGeoSenplades').focus();
      ok = false;
      return;
    }
  }

  if (ok) {
    $.ajax({
      type: "POST",
      url: "modulos/notasCursantes/verificaDatos.php",
      data: "anio=" + anio,
      success: function(response) {

        result = JSON.parse(response);

        if (result[0]) {
          window.open(url, name, opts);
        } else {
          alert(result[1]);
        }

      }
    });
  }
}
