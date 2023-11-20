function validate(thisform) {
	with (thisform) {


		if (
			validate_enterosArbol(
				hdr_idHdrTipoResum,
				'Este registro no tiene padre, esta seguro de Grabar los datos en la raiz del Arbol? ',
				null,
				null
			) == false
		) {
			hdr_idHdrTipoResum.focus();
			return false;
		}

		if (validate_requiredmax(desHdrTipoResum, 'Descripción', 3) == false) {
			desHdrTipoResum.focus();
			return false;
		}

	}
	return true;
}
