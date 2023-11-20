function validate(thisform) {
    with(thisform) {
        if (validate_required(descripcionUnidad, 'Nombre de Unidad') == false) {
            descripcionUnidad.focus();
            return false;
        }

        if (validate_combo(idGenEstado, 'Estado') == false) {
            idGenEstado.focus();
            return false;
        }
        if (validate_combo(imgAlb, '(*) Imagen Unidad') == false) {
            imgAlb.focus();
            return false;
        }
    }
    return true;
}