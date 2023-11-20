<script>
	function validate(thisform) {
		with(thisform) {
			if (validate_required(desc_unidad_actividad, 'Unidad Actividad') == false) {
				desc_unidad_actividad.focus();
				return false;
			}
			if (validate_required(descripcion, 'Geo Senplades') == false) {
				descripcion.focus();
				return false;
			}
		}
		return true;
	}

	function validate_required(field, alerttxt) {
		with(field) {
			if (value == null || value == "") {
				alert(alerttxt + ' no puede estar en blanco');
				return false;
			} else {
				if (value.length < 3) {
					alert(alerttxt + ' debe tener al menos 3 caracteres');
					return false;
				} else {
					return true;
				}
			}
		}
	}
</script>