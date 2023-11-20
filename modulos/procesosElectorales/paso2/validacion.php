<script>
    function validate(thisform) {
        with(thisform) {
            if (validate_requiredmax(idDgoProcElec, 'No ha seleccionado una Unidad', 0) == false) {
                idDgoProcElec.focus();
                return false;
            }
        }
        return true;
    }
</script>