function validate(thisform) {
  with (thisform) {
    if (validate_required(descripcion, "Descripción") == false) {
      descripcion.focus();
      return false;
    }
    if (validate_combo(idGenEstado, "Estado") == false) {
      idGenEstado.focus();
      return false;
    }
  }
  return true;
}
