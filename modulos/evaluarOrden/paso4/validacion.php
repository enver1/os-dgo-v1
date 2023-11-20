<script>
    function validate(thisform) {
        with(thisform) {
            if (validate_combo(idDgoTipoEvaluacionInf, "Tipo Evaluación") == false) {
                idDgoTipoEvaluacionInf.focus();
                return false;
            }
            if (validate_required(descripcion, "Descripción") == false) {
                descripcion.focus();
                return false;
            }
        }
        return true;
    }
</script>