<?php
class FormAsignaPersonalElec extends Form
{

    public function getCamposAsignaPersonalElec()
    {

        $formulario = array(
            array(
                'tipo'        => 'comboSQL',
                'etiqueta'    => 'Subsistema',
                'tabla'       => 'dgoTipoEje',
                'campoTabla'  => 'idDgoTipoEje1',
                'ancho'       => '313',
                'sql'         => "SELECT a.idDgoTipoEje AS idDgoTipoEje1, a.descripcion FROM dgoTipoEje a WHERE	a.idGenEstado = 1 AND a.delLog = 'N' AND a.dgo_idDgoTipoEje =4",
                'soloLectura' => 'false',
                'onclick'     => 'onchange="cargaCmbEjeP(this.value)"'
            ),

            array(
                'tipo'          => 'comboDependiente',
                'etiqueta'      => '<span style="display:block" id="etTipoEje">Unidad/Dirección:</span>',
                'tabla'         => 'dgoTipoEje',
                'campoTabla'    => 'idDgoTipoEje2',
                'campoTablaDep' => 'idDgoTipoEje1',
                'sqlDep'        => "SELECT a.idDgoTipoEje as idDgoTipoEje2, a.descripcion FROM dgoTipoEje a  WHERE a.dgo_idDgoTipoEje=",
                'ancho'         => '313',
                'soloLectura'   => 'false',
                'onclick'       => 'onchange="cargaCmbEjeP1(this.value)"'
            ),
            array(
                'tipo'          => 'comboDependiente',
                'etiqueta'      => '<span style="display:block" id="etUnidad">Designación:</span>',
                'tabla'         => 'dgoTipoEje',
                'campoTabla'    => 'idDgoTipoEje',
                'campoTablaDep' => 'idDgoTipoEje2',
                'sqlDep'        => "SELECT a.idDgoTipoEje, a.descripcion FROM dgoTipoEje a  WHERE a.dgo_idDgoTipoEje=",
                'ancho'         => '313',
                'soloLectura'   => 'false',
                'onclick'       => 'onchange=""'
            ),

            array(
                'tipo'          => 'persona',
                'etiqueta'      => 'Asignación de Personal:',
                'campoTabla'    => 'idGenPersona',
                'campoCedula'   => 'cedulaPersonaC',
                'campoNombre'   => 'nombrePersonaC',
                'onclick'       => 'buscaConductor()',
                'ancho'               => '80',
                'maxChar'             => '10',
                'botonBuscar'         => 'S',
                'botonOculto'         => 'true',
                'buscaxNombres'       => 'S',
                'soloLectura'         => 'false',
                'buscarTipoDocumento' => 'N',
                'esPolicia'           => 0,
                'limpiar'       => 'limpiarR()',
            ),


            array(
                'tipo'        => 'text',
                'etiqueta'    => 'Latitud:',
                'campoTabla'  => 'latitud',
                'ancho'       => '300',
                'maxChar'     => '',
                'soloLectura' => 'true'
            ),

            array(
                'tipo'        => 'text',
                'etiqueta'    => 'Longitud:',
                'campoTabla'  => 'longitud',
                'ancho'       => '300',
                'maxChar'     => '',
                'soloLectura' => 'true'
            ),
            array(
                'tipo'       => 'arbol',
                'etiqueta'   => 'Dist/Circuito/Subcircuito:',
                'campoTabla' => 'idGenGeoSenplades',
                'campoValor' => 'senpladesDescripcion',
                'ancho'      => '300',
                'boton'      => 'N',
                'tabla'      => 'genGeoSenplades'
            ),
            array(
                'tipo'        => 'comboSQL',
                'etiqueta'    => 'Estado:',
                'tabla'       => 'genEstado',
                'campoTabla'  => 'idGenEstado',
                'ancho'       => '160',
                'sql'         => "SELECT idGenEstado, descripcion FROM genEstado",
                'soloLectura' => 'false',
                'onclick'     => ''
            ),
            array(
                'tipo'        => 'hidden',
                'etiqueta'    => 'idDgoCreaOpReci:',
                'campoTabla'  => 'idDgoCreaOpReci',
                'ancho'       => '300',
                'maxChar'     => '',
                'soloLectura' => 'true'
            ),
            array(
                'tipo'        => 'hidden',
                'etiqueta'    => 'idDgoProcElec:',
                'campoTabla'  => 'idDgoProcElec',
                'ancho'       => '300',
                'maxChar'     => '',
                'soloLectura' => 'true'
            ),
            array(
                'tipo'        => 'hidden',
                'etiqueta'    => 'idDgoReciElect:',
                'campoTabla'  => 'idDgoReciElect',
                'ancho'       => '300',
                'maxChar'     => '',
                'soloLectura' => 'true'
            ),

        );
        return $formulario;
    }

    public function getFormularioAsignaPersonalElec($datos, $idcampo, $opc)
    {
        echo $this->getFormulario(
            ($this->getCamposAsignaPersonalElec()),
            $datos,
            $idcampo,
            $opc,
            $btnNuevo = true,
            $btnGraba = true,
            $btnImprime = false
        );
    }

    public function getGrillaAsignaPersonalElec()
    {
        $gridS = array(
            'ID'              => 'idDgoPerAsigOpe',

            'Nombre Personal' => 'personal',
            'Estado'          => 'estado',
        );
        return $gridS;
    }
    public function texto($campos, $rowt)
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
}
