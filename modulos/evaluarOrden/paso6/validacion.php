<script>
    function validate(thisform) {
        with(thisform) {
            if (validate_combo(destino, "Tipo Ejemplar") == false) {
                destino.focus();
                return false;
            }
            if (validate_required(descripcion, "Unidad de Destino") == false) {
                descripcion.focus();
                return false;
            }
        }
        return true;
    }
</script>