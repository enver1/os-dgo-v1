function validate(thisform) {
  with (thisform) {
    if (validate_combo(idGenGeoSenplades, "Distrito") == false) {
      senpladesDescripcion.focus();
      return false;
    }
    if (validate_combo(cedulaPersona, "Cédula Servidor Policial") == false) {
      cedulaPersona.focus();
      return false;
    }
    if (validate_combo(nombrePersona, "Nombre Servidor Policial") == false) {
      nombrePersona.focus();
      return false;
    }
    if (validate_combo(idGenEstado, "Estado") == false) {
      idGenEstado.focus();
      return false;
    }
  }
  return true;
}
