function validate(thisform) {
    with(thisform) {
        if (validate_combo(idDnaUnidadApp, 'Módulo Unidad') == false) {
            idDnaUnidadApp.focus();
            return false;
        }
        if (validate_combo(idDnaInfoApp, 'Opción') == false) {
            idDnaInfoApp.focus();
            return false;
        }
   
        if (validate_required(detalle, 'Detalle') == false) {
            detalle.focus();
            return false;
        }

      
        if (validate_combo(filtro, 'Filtro') == false) {
            filtro.focus();
            return false;
        }
            /////////////////////////////////////////////////////////////////////////////////////////
    var documentoPDF = filtro.options[filtro.selectedIndex].value;
    var editaRegistro = idDnaInfoDetalleApp.value;

    if (documentoPDF == 'PDF') {
        if (editaRegistro<0) {
        if (validate_combo(imgAlb1, '(*) Documento PDF') == false) {
            imgAlb1.focus();
            return false;
        }
    }
    }else{
        if (validate_required(accion1, 'Información') == false) {
            accion1.focus();
            return false;
        }
    }

    /////////////////////////////////////////////////////////
    if (validate_combo(idDnaPerfilVer, 'Tipo Permiso') == false) {
        idDnaPerfilVer.focus();
        return false;
    }
        if (validate_combo(idGenEstado, 'Estado') == false) {
            idGenEstado.focus();
            return false;
        }
        if (editaRegistro<0) {
        if (validate_combo(imgAlb, '(*) Icono Detalle') == false) {
            imgAlb.focus();
            return false;
        }
    }
    }
    return true;
}