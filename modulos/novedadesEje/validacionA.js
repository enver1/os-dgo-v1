function validate(thisform) {
    with(thisform) {
    	    if (validate_combo(idDgoTipoEje1, 'Eje') == false) {
            idDgoTipoEje1.focus();
            return false;
        }
        var idEje1 = idDgoTipoEje1.options[idDgoTipoEje1.selectedIndex].value;
        if (idEje1 > 1) {
            if (validate_combo(idDgoTipoEje2, 'Tipo de Eje') == false) {
                idDgoTipoEje2.focus();
                return false;
            }
        }
   
    }
    return true;
}