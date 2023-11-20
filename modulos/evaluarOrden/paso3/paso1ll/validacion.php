<script>
    function validate(thisform) {
        with(thisform) {
            if (validate_required(idGenPersona, "Servidor Polcial") == false) {
                idGenPersona.focus();
                return false;
            }
            if (validate_required(cedulaPersona, 'cedula') == false) {
                cedulaPersona.focus();
                return false;
            }

        }
        return true;
    }
</script>