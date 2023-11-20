function validate_tipoSenplades(campoNivelSenplades, nivelSenplades, mensaje) {
	if (campoNivelSenplades.value != nivelSenplades && campoNivelSenplades.value != '') {
		return true;
	} else {
		alert(mensaje);
		return false;
	}
}

function validate(thisform) {
	with (thisform) {
		if (validate_enteros(idGenPersona, 'Cursante', null, null) == false) { idGenPersona.focus(); return false; }

		if (validate_enteros(idGenGeoSenplades, 'Distribucion Senplades', null, null) == false) { idGenGeoSenplades.focus(); return false; }

		if (validate_combo(meses, 'Meses') == false) { meses.focus(); return false; }

		if (validate_tipoSenplades(senplades, 0, '**No existe tipo nivel Senplades**') == false) { senplades.focus(); return false; }
	}
	return true;
}

