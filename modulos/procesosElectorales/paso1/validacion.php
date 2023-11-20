<script>
    function validate(thisform) {
        with(thisform) {
            if (validate_required(descProcElecc, 'Descripción') == false) {
                descProcElecc.focus();
                return false;
            }
            if (validate_required(fechaInici, 'Fecha Inicial') == false) {
                fechaInici.focus();
                return false;
            }
            if (validate_required(fechaFin, 'Fecha Final') == false) {
                fechaFin.focus();
                return false;
            }

            if (validate_combo(tipo, 'Tipo Evento') == false) {
                tipo.focus();
                return false;
            }
            if (validate_combo(idGenEstado, 'Estado') == false) {
                idGenEstado.focus();
                return false;
            }
            if (fechaFin.value != '') {
                if (validate_fecha_registro(fechaInici, fechaFin, '>', 'La Fecha de Finalización no puede ser menor a la Fehca de Inicio') == false) {
                    fechaFin.focus();
                    return false;
                }
            }
        }
        return true;
    }
</script>