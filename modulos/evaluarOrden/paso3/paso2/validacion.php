<script>
    function validate(thisform) {
        with(thisform) {
            if (validate_combo(idDgoMediosLogisticos, "Medio Logístico") == false) {
                idDgoMediosLogisticos.focus();
                return false;
            }
            if (validate_requiredmax(cantidad, 'Numerico Medio', 1) == false) {
                cantidad.focus();
                return false;
            }
        }
        return true;
    }
</script>