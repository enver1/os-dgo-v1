<?php

class FormPuntoLlegada extends Form
{

    public function getCamposPuntosLlegada()
    {
        $formulario = array(

            array(
                'tipo'        => 'textArea',
                'etiqueta'    => 'Descripción de Punto de Llegada:',
                'campoTabla'  => 'descGoePunLleg',
                'ancho'       => '200',
                'alto'        => '',
                'maxChar'     => '200',
                'fontSize'    => '12px',
                'soloLectura' => 'false'
            ),

            array(
                'tipo'        => 'text',
                'etiqueta'    => 'Latitud:',
                'campoTabla'  => 'latitud',
                'ancho'       => '200',
                'maxChar'     => '',
                'fontSize'    => '12px',
                'soloLectura' => 'true'
            ),

            array(
                'tipo'        => 'text',
                'etiqueta'    => 'Longitud:',
                'campoTabla'  => 'longitud',
                'ancho'       => '200',
                'maxChar'     => '',
                'fontSize'    => '12px',
                'soloLectura' => 'true'
            ),
            array(
                'tipo'        => 'hidden',
                'etiqueta'    => 'direccion',
                'campoTabla'  => 'direccion',
                'ancho'       => '200',
                'maxChar'     => '',
                'fontSize'    => '12px',
                'soloLectura' => 'true'
            ),

            array(
                'tipo'        => 'comboSQL',
                'etiqueta'    => 'Estado:',
                'tabla'       => 'genEstado',
                'campoTabla'  => 'idGenEstado',
                'ancho'       => '215',
                'sql'         => "SELECT idGenEstado, descripcion FROM genEstado",
                'soloLectura' => 'false',
                'onclick'     => ''
            ),

        );

        return $formulario;
    }

    function texto($campos, $rowt)
    {
        $latitud  = (isset($rowt['latitud'])) ? $rowt['latitud'] : "";
        $longitud = (isset($rowt['longitud'])) ? $rowt['longitud'] : "";

        $html = '<table cellpadding="0" cellspacing="0"><tr><td>';
        $html .= '<input type="text" name="' . $campos['campoTabla'] . '" id="' . $campos['campoTabla'] . '"';
        $html .= empty($campos['ancho']) ? '' : 'style="width:' . $campos['ancho'] . 'px;';
        $html .= empty($campos['align']) ? '"' : 'text-align:' . $campos['align'] . ';" ';
        $html .= empty($campos['maxChar']) ? '' : 'maxlength="' . $campos['maxChar'] . '" ';
        $html .= 'value="' . (isset($rowt[$campos['campoTabla']]) ? $rowt[$campos['campoTabla']] : '') . '" ';
        $html .= 'placeholder="' . (isset($campos['placeholder']) ? $campos['placeholder'] : '') . '" ';
        $html .= ' class="inputSombra" ' . ($campos['soloLectura'] == 'true' ? 'readonly="readonly"' : '');

        if (isset($campos['mayusculas']) && $campos['mayusculas'] == 'S') {
            $html .= ' onkeyup="javascript:this.value=this.value.toUpperCase();" ';
        }

        $html .= '/><span>' . (isset($campos['ayuda1']) ? $campos['ayuda1'] : '') . '</span>';
        $html .= '</td>';

        if ($campos['campoTabla'] == 'longitud') {
            $html .= '<td><a href="../maps/gmaps.php?lat=' . $latitud . '&lon=' . $longitud . '" ';
            $html .= 'onclick="return GB_show(' . "'" . 'MAPA' . "'" . ', this.href,650,720)">';
            $html .= '<img src="../imagenes/googleMap.jpg" class="foto" style="border: solid 1px #999;box-shadow:none"></a>';
            $html .= '<a href="javascript:void(0)" onclick="buscaZSDCS()" id="getS"></a></td>';
        }

        $html .= '<td>&nbsp;<span class="texto_red" style="font-size:9px">';
        $html .= (isset($campos['ayuda']) ? $campos['ayuda'] : '') . '</span></td></tr></table>';
        return $html;
    }

    public function getFormularioPuntosLlegada($datos, $idcampo, $opc)
    {
        echo $this->getFormulario(
            ($this->getCamposPuntosLlegada()),
            $datos,
            $idcampo,
            $opc,
            $btnNuevo = true,
            $btnGraba = true,
            $btnImprime = true
        );
        //$this->getFormulario($conn, $this->getCamposPuntosLlegada(), $datos, $idcampo, $opc);
    }
}
