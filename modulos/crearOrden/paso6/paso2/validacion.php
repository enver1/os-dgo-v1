<script>
    function validate(thisform) {
        with(thisform) {
            if (validate_combo(idDgoTipoFuerzasAlternativas, "Fuerza Alternativa") == false) {
                idDgoTipoFuerzasAlternativas.focus();
                return false;
            }
            if (validate_requiredmax(numericoJefes, 'Numerico Jefes', 1) == false) {
                numericoJefes.focus();
                return false;
            }
            if (validate_requiredmax(numericoSubalternos, "Numerico Subalternos", 1) == false) {
                numericoSubalternos.focus();
                return false;
            }
        }
        return true;
    }
</script>