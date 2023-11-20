function validate_plazo_fechas(f1, f2, comparador, mensaje) {

	switch (comparador) {
		case ">":
		case "mayor":
			if (f1.value > f2.value) {
				alert(mensaje);
				return false
			}
			break;
		case "<":
		case "menor":
			if (f1.value < f2.value) {
				alert(mensaje);
				return false
			}
			break;
		case "=":
			if (f1.value == f2.value) {
				alert(mensaje);
				return false
			}
			break;
		case "<=":
			if (f1.value <= f2.value) {
				alert(mensaje);
				return false
			}
			break;
		case ">=":
			if (f1.value >= f2.value) {
				alert(mensaje);
				return false
			}
			break;
	}
}


function validate(thisform) {
	with (thisform) {
		if (validate_combo(idDgoActUnidad, 'Proceso Unidad') == false) { idDgoActUnidad.focus(); return false; }
		if (validate_required(idGenPersona, 'Cédula de la Persona') == false) { cedulaPersona.focus(); return false; }
		if (validate_required(nombrePersona, 'Encargado') == false) { nombrePersona.focus(); return false; }

		if (validate_fecha(fechaVisita, 'Fecha Visita') == false) { fechaVisita.focus(); return false; }

		if (validate_fecha(fechaInicio, 'Fecha Inicio') == false) { fechaInicio.focus(); return false; }

		if (validate_required(horaInicio, 'Hora Inicio') == false) { horaInicio.focus(); return false; }

		if (validate_plazo_fechas(fechaInicio, fechaFin, '>', 'Fecha Inicio no puede ser mayor que la Fecha Final del Proceso') == false) { fechaInicio.focus(); return false; }

		if (validate_plazo_fechas(fechaInicio, fechaVisita, '>', 'Fecha Inicio no puede ser mayor que la Fecha Visita') == false) { fechaInicio.focus(); return false; }

		if (validate_plazo_fechas(fechaVisita, fechaFin, '>', 'Fecha Visita no puede ser mayor que la Fecha Final del proceso') == false) { fechaInicio.focus(); return false; }


		if (fechaFin.value != '') {
			if (validate_fecha(fechaFin, 'Fecha Fin') == false) { fechaFin.focus(); return false; }

			if (horaFin.value != '') {
				if (validate_required(horaFin, 'Hora Fin') == false) { horaFin.focus(); return false; }
			}
		}

	}
	return true;
}

