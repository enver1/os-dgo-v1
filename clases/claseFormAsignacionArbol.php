<?php
class FormAsignacionArbol extends Form
{
    public function getCrearArbol($campos, $rowt)
    {
        if (isset($campos['oculto']) && $campos['oculto'] == 'S') {
            $oculto = 'style="display:none"';
        } else {
            $oculto = '';
        }

        $html = '<table id="' . $campos['tabla'] . '" ' . $oculto . '><tr><td><input type="hidden" name="' . $campos['campoTabla'] . '"  id="' . $campos['campoTabla'] . '" ';
        $html .= 'value="' . (isset($rowt[$campos['campoTabla']]) ? $rowt[$campos['campoTabla']] : '');
        $html .= '"/><input type="text" ';
        $html .= 'name="' . (isset($campos['campoValor']) ? $campos['campoValor'] : 'unidadDescripcion') . '" ';
        $html .= 'id="' . (isset($campos['campoValor']) ? $campos['campoValor'] : 'unidadDescripcion') . '" ';
        $html .= 'value="' . (isset($rowt[$campos['campoValor']]) ? $rowt[$campos['campoValor']] : '');
        $html .= '" style="width:' . (isset($campos['ancho']) ? $campos['ancho'] : '');
        $html .= '"  class="inputSombra" readonly="readonly" /></td><td style="padding:0 15px;">';
        if (isset($campos['boton']) && $campos['boton'] == 'N') {
            $html .= '&nbsp;';
        } else {
            $html .= '<a href="' . (isset($campos['href']) ? $campos['href'] : '../funciones/arbolUnidades.php?id=0') . '" ';
            $html .= 'class="button" style="background-image:url(' . $campos['estiloBoton'] . ')" ';
            $html .= 'onclick="return GB_showPage(\'' . $campos['titulo'] . '\', this.href)"><span>' . $campos['nomBoton'] . '</span></a>';
        }
        $html .= '</td></tr></table>';
        return $html;
    }

    public function getCrearArbolCaracteristicas($campos, $rowt)
    {
        if (isset($campos['oculto']) && $campos['oculto'] == 'S') {
            $oculto = 'style="display:none"';
        } else {
            $oculto = '';
        }

        $html = '<table id="' . $campos['tabla'] . '" ' . $oculto . '><tr><td><input type="hidden" name="' . $campos['campoTabla'] . '"  id="' . $campos['campoTabla'] . '" ';
        $html .= 'value="' . (isset($rowt[$campos['campoTabla']]) ? $rowt[$campos['campoTabla']] : '');
        $html .= '"/><input type="text" ';
        $html .= 'name="' . (isset($campos['campoValor']) ? $campos['campoValor'] : 'unidadDescripcion') . '" ';
        $html .= 'id="' . (isset($campos['campoValor']) ? $campos['campoValor'] : 'unidadDescripcion') . '" ';
        $html .= 'value="' . (isset($rowt[$campos['campoValor']]) ? $rowt[$campos['campoValor']] : '');
        $html .= '" style="width:' . (isset($campos['ancho']) ? $campos['ancho'] : '');
        $html .= '"  class="inputSombra" readonly="readonly" /></td><td style="padding:0">';
        if (isset($campos['boton']) && $campos['boton'] == 'N') {
            $html .= '&nbsp;';
        } else {
            $html .= '<a href="#" ';
            $html .= 'onclick="return getCrearArbolCaracteristicas(\'' . $campos['titulo'] . '\')"><img src="' . $campos['estiloBoton'] . '" border="0" alt="Abrir"></a>';
        }
        $html .= '</td></tr></table>';
        return $html;
    }

    public function arbol($campos, $rowt)
    {
        switch ($campos['tabla']) {
            case 'genGeoSenplades':
                $campos['href']        = (isset($campos['href']) && !empty($campos['href'])) ? $campos['href'] : 'modulos/asignacion/includes/arbolSenplades.php';
                $campos['titulo']      = 'DIVISION SENPLADES';
                $campos['estiloBoton'] = '../css/png/senplades.png';
                $campos['nomBoton']    = 'Senplades';
                $html                  = $this->getCrearArbol($campos, $rowt);
                break;
            default:
                $html = '<span class="texto_red">No se permite arboles para el tipo especificado</span>';
                break;
        }
        return $html;
    }


    public function getBotonesArbol($idcampo, $valor)
    {
        $html = '<table width="100%" border="0"><tr><td>';

        if (isset($_SESSION['privilegios']) and substr($_SESSION['privilegios'], 0, 1) == 1) {
            $html .= '<input type="button" name="nuevo"  onclick="getregistro(0)" value="Nuevo" class="boton_new" />';
        } else {
            $html .= '&nbsp';
        }
        $html .= '</td><td>';
        /* De acuerdo a los privilegios ejecuta la funcion GRABAREGISTRO() y pasa el parametro 1, 2 o 3mas el nombre del id del campo*/
        if (isset($_SESSION['privilegios'])) {
            switch (substr($_SESSION['privilegios'], 0, 2)) {
                case '11': //SI Insert y SI Update
                    $html .= '<input type="button" name="enviar" onclick="grabaregistros(1,\'id' . $idcampo . '\')" value="Grabar"  class="boton_save" />';
                    break;
                case '10'; //SI Insert y NO Update
                    $html .= '<input type="button" name="enviar" onclick="grabaregistros(2,\'id' . $idcampo . '\')" value="Grabar"  class="boton_save" />';
                    break;
                case '01'; // NO Insert y SI Update
                    $html .= '<input type="button" name="enviar" onclick="grabaregistros(3,\'id' . $idcampo . '\')" value="Grabar"  class="boton_save" />';
                    break;
                case '00'; // NO Insert y NO Update
                    $html .= '&nbsp;';
                    break;
            }
        }
        $html .= '</td>';
        $html .= '<td><input type="button" name="imprimir" ';
        $html .= 'onclick="delregistros(' . $valor . ')" ';
        $html .= 'value="Eliminar"  class="boton_general" ';
        $html .= 'style="background:url(../../../imagenes/botondelete.jpg);height:33px" /></td> ';
        $html .= '<td><input type="button" name="imprimir" onclick="imprimirdata()" ';
        $html .= ' value="Imprimir"  class="boton_print"/></td></tr></table></td></tr>';

        return $html;
    }
}
