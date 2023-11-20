<script>
	function validate(thisform) {
		with(thisform) {
			if (validate_combo(idDgpUnidad, 'Unidad') == false) {
				idDgpUnidad.focus();
				return false;
			}

			if (validate_combo(idGenPersona, 'Persona') == false) {
				idGenPersona.focus();
				return false;
			}

		}
		return true;
	}
</script>