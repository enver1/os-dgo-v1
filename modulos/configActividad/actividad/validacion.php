<script>
    function validate(thisform) {
        with(thisform) {

            if (validate_combo(idDgoEjeProcSu, 'Eje') == false) {
                idDgoEjeProcSu.focus();
                return false;
            }
            if (validate_requiredmax(descDgoActividad, 'Descripcion', 20) == false) {
                descDgoActividad.focus();
                return false;
            }
            if (validate_requiredmax(obsDgoActividad, 'Observacion', 5) == false) {
                obsDgoActividad.focus();
                return false;
            }
            if (validate_decimales(peso, 'Peso Coeficiente', 0, 100) == false) {
                peso.focus();
                return false;
            }
        }
        return true;
    }
</script>