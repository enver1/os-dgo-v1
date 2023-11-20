<script>
	function validate(thisform) {
		with(thisform) {

			if (validate_combo(idGenPersona, 'Partipante') == false) {
				idGenPersona.focus();
				return false;
			}

			if (validate_combo(tipoParticipacion, 'Tipo Participación') == false) {
				tipoParticipacion.focus();
				return false;
			}
		}
		return true;
	}
</script>