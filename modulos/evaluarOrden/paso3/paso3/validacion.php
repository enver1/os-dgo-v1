<script>
    function validate(thisform) {
        with(thisform) {

            if (validate_required(descripcion, "Operaciones Realizadas") == false) {
                descripcion.focus();
                return false;
            }
        }
        return true;
    }
</script>