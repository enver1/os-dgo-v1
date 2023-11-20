<script>
    function validate(thisform) {
        with(thisform) {
            if (validate_requiredmax(descEncuesta, 'Descripcion', 20) == false) {
                descEncuesta.focus();
                return false;
            }
            if (validate_decimales(puntaje, 'Puntaje', 0, 5) == false) {
                puntaje.focus();
                return false;
            }
        }
        return true;
    }
</script>