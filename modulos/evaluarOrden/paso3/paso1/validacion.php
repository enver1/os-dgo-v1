<script>
    function validate(thisform) {
        with(thisform) {
            if (validate_required(unidadDescripcion, "Unidad de Servicio") == false) {
                unidadDescripcion.focus();
                return false;
            }
            if (validate_requiredmax(superiores, 'Superiores', 1) == false) {
                superiores.focus();
                return false;
            }
            if (validate_requiredmax(subalternos, "Subalternos", 1) == false) {
                subalternos.focus();
                return false;
            }
            if (validate_requiredmax(clases, "Clases y Policias", 1) == false) {
                clases.focus();
                return false;
            }
        }
        return true;
    }
</script>