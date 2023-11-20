function validate(thisform) {
    with(thisform) {
        if (validate_required(desHdrGrupResum, 'Descripción') == false) {
            desHdrGrupResum.focus();
            return false;
        }
          if (validate_requiredmax(categorizacion, 'Categorización',0) == false) {
            categorizacion.focus();
            return false;
        }
    }
    return true;
}