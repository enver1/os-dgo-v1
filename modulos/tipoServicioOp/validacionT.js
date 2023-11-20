function validate(thisform) {
    with(thisform) {
        if (validate_required(descripcion, 'Tipo de Servicio') == false) {
            descripcion.focus();
            return false;
        }
    }
    return true;
}