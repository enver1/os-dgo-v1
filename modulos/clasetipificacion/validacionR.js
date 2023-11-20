function validate(thisform) {
	with (thisform) {


		if (
			validate_enterosArbol(
				gen_idGenTipoTipificacion,
				'Este registro no tiene padre, esta seguro de Grabar los datos en la raiz del Arbol? ',
				null,
				null
			) == false
		) {
			gen_idGenTipoTipificacion.focus();
			return false;
		}

		if (validate_requiredmax(descripcion, 'Nombre', 3) == false) {
			descripcion.focus();
			return false;
		}

	}
	return true;
}
