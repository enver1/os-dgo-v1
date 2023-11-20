<script>
    function validate(thisform) {
        with(thisform) {
            if (validate_combo(idDgoTipoEje1, 'Eje') == false) {
                idDgoTipoEje1.focus();
                return false;
            }
            var idEje1 = idDgoTipoEje1.options[idDgoTipoEje1.selectedIndex].value;
            if (idEje1 > 1) {
                if (validate_combo(idDgoTipoEje2, 'Tipo de Eje') == false) {
                    idDgoTipoEje2.focus();
                    return false;
                }
            }
            var idEje = idDgoTipoEje2.options[idDgoTipoEje2.selectedIndex].value;
            var aux = auxiliar.value;
            if ((idEje > 1) && (aux == '') && (idDgoTipoEje.value == "")) {
                if (validate_combo(idDgoTipoEje, 'Unidad') == false) {
                    idDgoTipoEje.focus();
                    return false;
                }
            }
            if (validate_required(latitud, 'Latitud') == false) {
                latitud.focus();
                return false;
            }
            if (validate_required(longitud, 'Longitud') == false) {
                longitud.focus();
                return false;
            }
            if (validate_required(divPoliticaDescripcion, 'División Política') == false) {
                divPoliticaDescripcion.focus();
                return false;
            }
            if (validate_required(codRecintoElec, 'Código de Recinto') == false) {
                codRecintoElec.focus();
                return false;
            }
            if (validate_required(nomRecintoElec, 'Nombre de Recinto') == false) {
                nomRecintoElec.focus();
                return false;
            }
            if (validate_required(direcRecintoElec, 'Dirección del Recinto') == false) {
                direcRecintoElec.focus();
                return false;
            }
            if (validate_combo(tipoRecinto, 'Tipo Recinto') == false) {
                tipoRecinto.focus();
                return false;
            }
            if (validate_combo(idGenEstado, 'Estado') == false) {
                idGenEstado.focus();
                return false;
            }
        }
        return true;
    }
</script>