function validate(thisform) {
    with (thisform) {
        if (validate_required(nombrePersonaC, 'Servidor Policial Reporta Novedad') == false) {
            nombrePersonaC.focus();
            return false;
        }
        if (validate_required(cedulaPersonaC, 'Cédula Servidor Policial Reporta Novedad') == false) {
            cedulaPersonaC.focus();
            return false;
        }
        if (validate_combo(unidad, 'Recinto Electoral') == false) {
            unidad.focus();
            return false;
        }
        if (validate_required(jefe, 'Nombre del Jefe / Encargado del Recinto') == false) {
            jefe.focus();
            return false;
        }
        if (validate_requiredmax(idOperativo, 'Id. Operativo Recinto', 1) == false) {
            idOperativo.focus();
            return false;
        }
        if (validate_required(latitud, 'Latitud') == false) {
            latitud.focus();
            return false;
        }
        if (validate_required(longitud, 'Longitud') == false) {
            longitud.focus();
            return false;
        }
        if (validate_combo(idNovedad, 'Tipo Novedad') == false) {
            idNovedad.focus();
            return false;
        }
        if (validate_combo(idDgoNovedadesElect, 'Novedad') == false) {
            idDgoNovedadesElect.focus();
            return false;
        }
        //////////////////////////////////////////////////////////////////////////////////////
        var novedad = idDgoNovedadesElect.options[idDgoNovedadesElect.selectedIndex].value;
        if ((novedad >= 10 && novedad <= 13) || (novedad >= 24 && novedad <= 27)) {
            if (validate_required(documento, 'Número de Cédula') == false) {
                documento.focus();
                return false;
            }
            if (validate_required(boleta, 'Número de Citación') == false) {
                boleta.focus();
                return false;
            }
        } else if ((novedad >= 6 && novedad <= 9)) {
            if (validate_required(documento, 'Número de Cédula') == false) {
                documento.focus();
                return false;
            }
        } else if ((novedad >= 14 && novedad <= 16)) {
            if (validate_required(idGenPersonaD, 'Número de Cédula') == false) {
                idGenPersonaD.focus();
                return false;
            }
            if (validate_required(boleta, 'Número de Boleta') == false) {
                boleta.focus();
                return false;
            }
        } else if ((novedad == 19)) {
            if (validate_required(cedula, 'Hora Instlación') == false) {
                cedula.focus();
                return false;
            }
        } else if ((novedad == 20)) {
            if (validate_required(cedula, 'Motivo Cierre') == false) {
                cedula.focus();
                return false;
            }
        } else if ((novedad == 21)) {
            if (validate_required(cedula, 'Cédula Servidor Policial') == false) {
                cedula.focus();
                return false;
            }
        } else if ((novedad >= 22 && novedad <= 23)) {
            if (validate_requiredmax(cedula, 'Número de Manifestantes', 1) == false) {
                cedula.focus();
                return false;
            }
            if (validate_required(boleta, 'Organización') == false) {
                boleta.focus();
                return false;
            }
            if (validate_required(lider, 'Lider Organización') == false) {
                lider.focus();
                return false;
            }
        } else if ((novedad == 28)) {
            if (validate_requiredmax(cedula, 'Número de Manifestantes', 1) == false) {
                cedula.focus();
                return false;
            }
            if (validate_required(boleta, 'Organización') == false) {
                boleta.focus();
                return false;
            }
            if (validate_required(lider, 'Lider Organización') == false) {
                lider.focus();
                return false;
            }
        } else if ((novedad == 30)) {
            if (validate_required(documento, 'Cédula Persona') == false) {
                documento.focus();
                return false;
            }
        } else if ((novedad == 32)) {
            if (validate_requiredmax(cedula, 'Numérico', 1) == false) {
                cedula.focus();
                return false;
            }
        } else if ((novedad == 33)) {
            if (validate_requiredmax(documento, 'Numerico de Personal', 1) == false) {
                documento.focus();
                return false;
            }
        } else if ((novedad >= 34 && novedad <= 37)) {
            if (validate_requiredmax(cedula, 'Número de Manifestantes', 1) == false) {
                cedula.focus();
                return false;
            }
            if (validate_required(boleta, 'Organización') == false) {
                boleta.focus();
                return false;
            }
            if (validate_required(lider, 'Lider Organización') == false) {
                lider.focus();
                return false;
            }
        } else if ((novedad == 41)) {
            if (validate_required(cedula, 'Función') == false) {
                cedula.focus();
                return false;
            }
            if (validate_required(boleta, 'Nombres') == false) {
                boleta.focus();
                return false;
            }
        } else if ((novedad == 42)) {
            if (validate_required(cedula, 'Nombre Instalación') == false) {
                cedula.focus();
                return false;
            }
            if (validate_required(boleta, 'Descripción') == false) {
                boleta.focus();
                return false;
            }
        } else if ((novedad == 43)) {
            if (validate_required(cedula, 'Dirección') == false) {
                cedula.focus();
                return false;
            }
            if (validate_required(boleta, 'Descripción') == false) {
                boleta.focus();
                return false;
            }
        } else if ((novedad == 44)) {
            if (validate_required(cedula, 'Unidad') == false) {
                cedula.focus();
                return false;
            }
        } else if ((novedad >= 45 && novedad <= 46)) {
            if (validate_required(cedula, 'Nombre') == false) {
                cedula.focus();
                return false;
            }
            if (validate_required(boleta, 'Cargo Función') == false) {
                boleta.focus();
                return false;
            }
        } else if ((novedad == 47)) {
            if (validate_required(cedula, 'Nombre') == false) {
                cedula.focus();
                return false;
            }
            if (validate_required(boleta, 'Medio de Comunicación') == false) {
                boleta.focus();
                return false;
            }
        } else if ((novedad >= 49 && novedad <= 53)) {
            if (validate_requiredmax(cedula, 'Numérico', 1) == false) {
                cedula.focus();
                return false;
            }
        } else if ((novedad >= 54 && novedad <= 55)) {
            if (validate_required(cedula, 'Hora (00:00)') == false) {
                cedula.focus();
                return false;
            }
        }
        //////////////////////////////////////////////////////////////////////////////////////
    }
    return true;
}