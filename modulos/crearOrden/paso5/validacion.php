<script>
    function validate(thisform) {
        with(thisform) {
            if (validate_combo(temporalidad, "Temporalidad") == false) {
                temporalidad.focus();
                return false;
            }
            if (validate_required(descripcion, "Instrucciones") == false) {
                descripcion.focus();
                return false;
            }
        }
        return true;
    }
</script>