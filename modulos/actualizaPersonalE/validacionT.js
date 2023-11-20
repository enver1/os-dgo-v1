function validate(thisform) {
    with (thisform) {
        if (validate_combo(idDgoProcElec, "Proceso") == false) {
            idDgoProcElec.focus();
            return false;
        }
    }
    return true;
}