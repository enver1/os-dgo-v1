function validate(thisform) {
    with(thisform) {
        if (validate_required(nombrePersonaC, 'Nombre del Servidor Policial') == false) {
            nombrePersonaC.focus();
            return false;
        }
        if (validate_required(cedulaPersonaC, 'Cédula del Servidor Policial') == false) {
            cedulaPersonaC.focus();
            return false;
        }
        if (validate_required(idGenUsuario, 'Seleccione un Usuario') == false) {
            cedulaPersonaC.focus();
            return false;
        }
        if (validate_combo(idDnaUnidadApp, 'Módulo Unidad') == false) {
            idDnaUnidadApp.focus();
            return false;
        }    if (validate_combo(idDnaPerfilVer, 'Tipo Permiso') == false) {
            idDnaPerfilVer.focus();
            return false;
        }
        if (validate_combo(idGenEstado, 'Estado') == false) {
            idGenEstado.focus();
            return false;
        }
    }
    return true;
}