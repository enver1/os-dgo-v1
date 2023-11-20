<script>
    function validate(thisform) {
        with(thisform) {
            if (validate_combo(idDgoProcElec, 'Proceso Electoral') == false) {
                idDgoProcElec.focus();
                return false;
            }
            var recintos = idDgoT.value;
            if (recintos == 1) {
                if (validate_enteros(numElectores, 'Número de Electores', 0, 1000000) == false) {
                    numElectores.focus();
                    return false;
                }
                if (validate_enteros(numJuntMascu, 'Número de Juntas Hombres', 0, 1000) == false) {
                    numJuntMascu.focus();
                    return false;
                }
                if (validate_enteros(numJuntFeme, 'Número de Juntas Mujeres', 0, 1000) == false) {
                    numJuntFeme.focus();
                    return false;
                }
            }
        }
        return true;
    }
</script>