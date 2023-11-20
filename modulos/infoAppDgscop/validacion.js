function validate(thisform) {
    with(thisform) {
        if (validate_combo(idDnaUnidadApp, 'Módulo Unidad') == false) {
            idDnaUnidadApp.focus();
            return false;
        }
        if (validate_required(nombreBoton, 'Nombre Opción') == false) {
            nombreBoton.focus();
            return false;
        }
        if (validate_combo(imgAlb, '(*) Icono') == false) {
            imgAlb.focus();
            return false;
        }
        if (validate_combo(idGenEstado, 'Estado') == false) {
            idGenEstado.focus();
            return false;
        }
   
    }
    return true;
}