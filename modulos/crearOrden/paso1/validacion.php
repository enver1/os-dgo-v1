<script>
  function validate(thisform) {
    with(thisform) {
      if (validate_combo(idDgoTipoCalificacion, "Tipo Calificación") == false) {
        idDgoTipoCalificacion.focus();
        return false;
      }
      if (validate_combo(idGenTipoOperativo, "Operativo") == false) {
        idGenTipoOperativo.focus();
        return false;
      }
      if (validate_combo(idGenTipoOperativoHijo, "Tipo Operativo") == false) {
        idGenTipoOperativoHijo.focus();
        return false;
      }
      if (
        validate_required(cedulaPersonaJefe, "Cédula Jefe del Operativo") == false
      ) {
        cedulaPersonaJefe.focus();
        return false;
      }

      if (
        validate_required(nombrePersonaJefe, "Nombre Jefe Operativo") == false
      ) {
        nombrePersonaJefe.focus();
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
      if (validate_required(nombreOperativo, "Nombre del Operativo") == false) {
        nombreOperativo.focus();
        return false;
      }

      if (validate_required(fechaOrden, "Fecha Inicio Orden") == false) {
        fechaOrden.focus();
        return false;
      }
      if (validate_required(fechaFinOrden, "Fecha Fin Orden") == false) {
        fechaFinOrden.focus();
        return false;
      }

      if (validate_fecha_registro(fechaOrden, fechaFinOrden, '>', 'Fecha Orden') == false) {
        fechaOrden.focus();
        return false;
      }

      if (validate_required(horaOrden, "Hora Orden") == false) {
        horaOrden.focus();
        return false;
      }
      if (validate_required(horaFormacion, "Hora Formación") == false) {
        horaFormacion.focus();
        return false;
      }
    }
    return true;
  }
</script>