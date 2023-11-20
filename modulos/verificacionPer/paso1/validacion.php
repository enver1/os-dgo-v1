<script>
    function validate(thisform) {
        with(thisform) {
            if (validate_combo(idDgoTipoEje1, 'Eje') == false) {
                idDgoTipoEje1.focus();
                return false;
            }
            var idEje1 = idDgoTipoEje1.options[idDgoTipoEje1.selectedIndex].value;
            if (idEje1 == 1) {
                if (validate_required(latitud, 'Latitud') == false) {
                    latitud.focus();
                    return false;
                }
                if (validate_required(longitud, 'Longitud') == false) {
                    longitud.focus();
                    return false;
                }
                if (validate_required(senpladesDescripcion, 'División Senplades') == false) {
                    senpladesDescripcion.focus();
                    return false;
                }
            }
            if (idEje1 > 1) {
                if (validate_combo(idDgoTipoEje2, 'Tipo de Eje') == false) {
                    idDgoTipoEje2.focus();
                    return false;
                }
            }
            var idEje = idDgoTipoEje2.options[idDgoTipoEje2.selectedIndex].value;
            var aux = auxiliar.value;
            if ((idEje > 1) && (aux == '')) {
                if (validate_combo(idDgoTipoEje, 'Unidad') == false) {
                    idDgoTipoEje.focus();
                    return false;
                }
            }
            if (validate_combo(idDgoReciElect, 'Recinto Electoral / Unidad Policial / Institución') == false) {
                idDgoReciElect.focus();
                return false;
            }
            if (validate_required(cedulaPersonaC, 'Cédula Servidor Policial Encargado') == false) {
                cedulaPersonaC.focus();
                return false;
            }
            if (validate_required(nombrePersonaC, 'Nombre Servidor Policial Encargado') == false) {
                nombrePersonaC.focus();
                return false;
            }
            if (validate_required(idGenPersona, 'Seleccione una Persona') == false) {
                cedulaPersonaC.focus();
                return false;
            }
            if (validate_combo(telefono, 'Telefono Encargado') == false) {
                telefono.focus();
                return false;
            }
            if (validate_combo(estado, 'Estado Recinto') == false) {
                estado.focus();
                return false;
            }
        }
        return true;
    }
</script>