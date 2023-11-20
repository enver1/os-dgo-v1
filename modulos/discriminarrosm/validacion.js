function validate(thisform) {
    with(thisform) {
    	if (validate_required(apenom, "Persona Sancionada") == false) {
            apenom.focus();
            return false;
        }
        if (validate_combo(causa, "Sanción Por") == false) {
            causa.focus();
            return false;
        }
        if (validate_required(nroParteWeb, "Nro. Parte Web") == false) {
            nroParteWeb.focus();
            return false;
        }
        if (validate_combo(idGenPersona, "Persona Que Realiza El Parte") == false) {
            idGenPersona.focus();
            return false;
        }
        if (validate_required(justificacion, "Justificacion") == false) {
            justificacion.focus();
            return false;
        }
    }
    return true;
}