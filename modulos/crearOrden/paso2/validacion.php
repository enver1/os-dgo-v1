<script>
    function validate(thisform) {
        with(thisform) {
            if (validate_required(descripcion, "Antecedente:") == false) {
                descripcion.focus();
                return false;
            }
        }
        return true;
    }
</script>