function validate(thisform) {
    with (thisform) {
        if (validate_required(idGenPersonaJefe, 'Servidor Policial Observador') == false) {
            cedulaPersonaJefe.focus();
            return false;
        }
        if (validate_required(idGenPersona, 'Servidor Policial Sancionado') == false) {
            cedulaPersona.focus();
            return false;
        }

        if (validate_combo(idCgTipoAspecto2, 'Tipo Aspecto') == false) {
            idCgTipoAspecto2.focus();
            return false;
        }
        if (validate_combo(idCgTipoAspecto1, 'Detalle Aspecto') == false) {
            idCgTipoAspecto1.focus();
            return false;
        }
        if (validate_combo(idCgTipoAspecto, 'Aspecto') == false) {
            idCgTipoAspecto.focus();
            return false;
        }
        if (validate_combo(idCgTipoAspectoSancion, 'Motivo Registro') == false) {
            idCgTipoAspectoSancion.focus();
            return false;
        }
    }
    return true;
}