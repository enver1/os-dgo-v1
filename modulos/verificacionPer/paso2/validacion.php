<script>
    function validate(thisform) {
        with(thisform) {
            if (validate_combo(idDgoReciElect, 'Unidad a la que Pertenece') == false) {
                idDgoReciElect.focus();
                return false;
            }
            if (validate_required(cedulaPersonaC, 'Cédula Servidor Policial Encargado') == false) {
                cedulaPersonaC.focus();
                return false;
            }
            if (validate_required(nombrePersonaC, 'Nombre Servidor Policial Encargado') == false) {
                nombrePersonaC.focus();
                return false;
            }
            if (validate_required(idGenPersona, 'Seleccione una Persona') == false) {
                longitud.focus();
                return false;
            }
            if (validate_combo(idGenEstado, 'Estado') == false) {
                idGenEstado.focus();
                return false;
            }
        }
        return true;
    }
</script>