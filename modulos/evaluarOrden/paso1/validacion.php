<script>
  function validate(thisform) {
    with(thisform) {
      if (validate_combo(idDgoTipoCalificacion, "Tipo Calificación") == false) {
        idDgoTipoCalificacion.focus();
        return false;
      }
      if (
        validate_required(cedulaPersonaR, "Cédula del Responsable Informe") == false
      ) {
        cedulaPersonaR.focus();
        return false;
      }

      if (
        validate_required(nombrePersonaR, "Nombre Responsable Informe") == false
      ) {
        nombrePersonaR.focus();
        return false;
      }
      if (validate_required(cedulaPersonaComandante, "Cédula Jefe del Comandante") == false) {
        cedulaPersonaComandante.focus();
        return false;
      }

      if (
        validate_required(nombrePersonaComandante, "Nombre Jefe Comandante") ==
        false
      ) {
        nombrePersonaComandante.focus();
        return false;
      }
      if (validate_required(idGenDivPolitica, "División Política") == false) {
        divPoliticaDescripcion.focus();
        return false;
      }
      if (validate_required(nombreInforme, "Nombre del Informe") == false) {
        nombreInforme.focus();
        return false;
      }
      if (validate_required(detalleInforme, "Detalle del Informe") == false) {
        detalleInforme.focus();
        return false;
      }

      if (validate_required(fechaInforme, "Fecha Informe") == false) {
        fechaInforme.focus();
        return false;
      }
      if (validate_required(horaInforme, "Hora Informe") == false) {
        horaInforme.focus();
        return false;
      }
    }
    return true;
  }
</script>