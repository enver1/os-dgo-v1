<?php

class FormCrearOperativoReci extends Form
{

    public function getCamposCrearOperativoReci()
    {

        $formulario = array(
            array(
                'tipo'        => 'comboSQL',
                'etiqueta'    => 'Proceso',
                'tabla'       => 'dgoProcElec',
                'campoTabla'  => 'idDgoProcElec',
                'ancho'       => '313',
                'sql'         => "SELECT a.idDgoProcElec,a.descProcElecc as descripcion FROM dgoProcElec a WHERE a.delLog='N' AND a.idGenEstado=1 ORDER BY a.idDgoProcElec DESC",
                'soloLectura' => 'false',
                'onclick'     => ''
            ),

            array(
                'tipo'        => 'comboSQL',
                'etiqueta'    => 'Eje',
                'tabla'       => 'dgoTipoEje',
                'campoTabla'  => 'idDgoTipoEje1',
                'ancho'       => '313',
                'sql'         => "SELECT a.idDgoTipoEje as idDgoTipoEje1, a.descripcion FROM dgoTipoEje a  WHERE a.dgo_idDgoTipoEje is null AND a.idGenEstado=1 AND a.delLog='N'",
                'soloLectura' => 'false',
                'onclick'     => 'onchange="cargaCmbEje(this.value)"'
            ),

            array(
                'tipo'          => 'comboDependiente',
                'etiqueta'      => '<span style="display:block" id="etTipoEje">Tipo Eje:</span>',
                'tabla'         => 'dgoTipoEje',
                'campoTabla'    => 'idDgoTipoEje2',
                'campoTablaDep' => 'idDgoTipoEje1',
                'sqlDep'        => "SELECT a.idDgoTipoEje as idDgoTipoEje2, a.descripcion FROM dgoTipoEje a  WHERE a.dgo_idDgoTipoEje=",
                'ancho'         => '313',
                'soloLectura'   => 'false',
                'onclick'       => 'onchange="cargaCmbEje1(this.value)"'
            ),
            array(
                'tipo'          => 'comboDependiente',
                'etiqueta'      => '<span style="display:block" id="etUnidad">Unidad:</span>',
                'tabla'         => 'dgoTipoEje',
                'campoTabla'    => 'idDgoTipoEje',
                'campoTablaDep' => 'idDgoTipoEje2',
                'sqlDep'        => "SELECT a.idDgoTipoEje, a.descripcion FROM dgoTipoEje a  WHERE a.dgo_idDgoTipoEje=",
                'ancho'         => '313',
                'soloLectura'   => 'false',
                'onclick'       => 'onchange="cargaCmbRecintosPorEje(this.value)"'
            ),

            array(
                'tipo'        => 'text',
                'etiqueta'    => '<span style="display:block" id="etLatitud">Latitud:</span>',
                'campoTabla'  => 'latitud',
                'ancho'       => '300',
                'maxChar'     => '',
                'soloLectura' => 'true'
            ),

            array(
                'tipo'        => 'text',
                'etiqueta'    => '<span style="display:block" id="etLongitud">Longitud:</span>',
                'campoTabla'  => 'longitud',
                'ancho'       => '300',
                'maxChar'     => '',
                'soloLectura' => 'true'
            ),

            array(
                'tipo'       => 'arbol',
                'etiqueta'   => '<span style="display:block" id="etDist">Dist/Circuito/Subcircuito:</span>',
                'campoTabla' => 'idGenGeoSenplades',
                'campoValor' => 'senpladesDescripcion',
                'ancho'      => '300',
                'boton'      => 'N',
                'tabla'      => 'genGeoSenplades'
            ),

            array(
                'tipo'          => 'comboDependiente',
                'etiqueta'      => '<span style="display:block" id="etDispositivo">Recinto Electoral / Unidad Policial / Institución:</span>',
                'tabla'         => 'dgoReciElect',
                'campoTabla'    => 'idDgoReciElect',
                'campoValor'    => 'idDgoReciElect',
                'campoTablaDep' => 'idDgoReciElect',
                'sqlDep'        => "SELECT
                                        a.idDgoReciElect,
                                        a.nomRecintoElec descripcion
                                    FROM
                                        dgoReciElect a
                                    WHERE a.delLog='N'
                                    AND a.idDgoReciElect=",
                'ancho'         => '305',
                'soloLectura'   => 'false',
                'onclick'       => 'onchange="getLatitudLongitud(this.value)"'
            ),
            array(
                'tipo'                => 'persona',
                'etiqueta'      => 'Servidor Policial Encargado:',
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
                'esPolicia'           => 1,
                'limpiar'       => 'limpiarR()',
            ),
            array(
                'tipo'        => 'text',
                'etiqueta'    => 'Telefono Encargado:',
                'campoTabla'  => 'telefono',
                'ancho'       => '300',
                'maxChar'     => '',
                'soloLectura' => 'true'
            ),
            array(
                'tipo'        => 'comboArreglo',
                'etiqueta'    => 'Estado Recinto:',
                'campoTabla'  => 'estado',
                'arreglo'     => array('A' => 'INICIAR', 'C' => 'FINALIZAR'),
                'soloLectura' => 'false',
                'ancho'       => '300'
            ),

            array(
                'tipo'        => 'hidden',
                'etiqueta'    => 'auxR:',
                'campoTabla'  => 'auxR',
                'ancho'       => '300',
                'maxChar'     => '',
                'soloLectura' => 'true'
            ),
            array(
                'tipo'        => 'hidden',
                'etiqueta'    => 'auxC:',
                'campoTabla'  => 'auxC',
                'ancho'       => '300',
                'maxChar'     => '',
                'soloLectura' => 'true'
            ),
            array(
                'tipo'        => 'hidden',
                'etiqueta'    => 'fechaIni',
                'campoTabla'  => 'fechaIni',
                'ancho'       => '300',
                'maxChar'     => '',
                'soloLectura' => 'true'
            ),

            array(
                'tipo'        => 'hidden',
                'etiqueta'    => 'fechaFin',
                'campoTabla'  => 'fechaFin',
                'ancho'       => '300',
                'maxChar'     => '',
                'soloLectura' => 'true'
            ),
            array(
                'tipo'        => 'hidden',
                'etiqueta'    => 'idPer:',
                'campoTabla'  => 'idPer',
                'ancho'       => '300',
                'maxChar'     => '',
                'soloLectura' => 'true'
            ),
            array(
                'tipo'        => 'hidden',
                'etiqueta'    => 'auxiliar:',
                'campoTabla'  => 'auxiliar',
                'ancho'       => '300',
                'maxChar'     => '',
                'soloLectura' => 'true'
            ),

            array(
                'tipo'        => 'hidden',
                'etiqueta'    => 'idDgoComisios',
                'campoTabla'  => 'idDgoComisios',
                'ancho'       => '300',
                'maxChar'     => '',
                'soloLectura' => 'true'
            ),
            array(
                'tipo'        => 'hidden',
                'etiqueta'    => 'finalizado',
                'campoTabla'  => 'finalizado',
                'ancho'       => '300',
                'maxChar'     => '',
                'soloLectura' => 'true'
            ),
            array(
                'tipo'        => 'hidden',
                'etiqueta'    => 'direccion',
                'campoTabla'  => 'direccion',
                'ancho'       => '300',
                'maxChar'     => '',
                'soloLectura' => 'true'
            ),
            array(
                'tipo'        => 'hidden',
                'etiqueta'    => 'idRecintoElec',
                'campoTabla'  => 'idRecintoElec',
                'ancho'       => '300',
                'maxChar'     => '',
                'soloLectura' => 'true'
            ),

        );
        return $formulario;
    }

    public function getFormularioCrearOperativoReci($datos, $idcampo, $opc)
    {
        echo $this->getFormulario(
            ($this->getCamposCrearOperativoReci()),
            $datos,
            $idcampo,
            $opc,
            $btnNuevo = true,
            $btnGraba = true,
            $btnImprime = false
        );
    }

    public function getGrillaCrearOperativoReci()
    {
        $gridS = array(
            'ID'          => 'idDgoCreaOpReci',
            'Proceso'     => 'descProcElecc',
            'Zona'        => 'Zona',
            'Subzona'     => 'Subzona',
            'Recinto'     => 'nomRecintoElec',
            'Nombre Jefe' => 'jefe_operativo',
            'Estado'      => 'estado',
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
        $html .= ' class="inputSombra" ' . ($campos['soloLectura'] == 'false' ? 'readonly="readonly"' : '');

        if (isset($campos['mayusculas']) && $campos['mayusculas'] == 'S') {
            $html .= ' onkeyup="javascript:this.value=this.value.toUpperCase();" ';
        }

        $html .= '/><span>' . (isset($campos['ayuda1']) ? $campos['ayuda1'] : '') . '</span>';
        $html .= '</td>';

        if ($campos['campoTabla'] == 'longitud') {
            $html .= '<td><a id=t987 href="../maps/gmaps.php?lat=' . $latitud . '&lon=' . $longitud . '" ';
            $html .= 'onclick="return GB_show(' . "'" . 'MAPA' . "'" . ', this.href,650,720)">';
            $html .= '<img src="../imagenes/googleMap.jpg" class="foto" style="border: solid 1px #999;box-shadow:none"></a>';
            $html .= '<a href="javascript:void(0)" onclick="buscaZSDCS()" id="getS"></a></td>';
        }

        $html .= '<td>&nbsp;<span class="texto_red" style="font-size:9px">';
        $html .= (isset($campos['ayuda']) ? $campos['ayuda'] : '') . '</span></td></tr></table>';
        return $html;
    }

    public function getCamposCerrarOperativoReci()
    {
        $formulario = array(
            array(
                'tipo'        => 'comboSQL',
                'etiqueta'    => 'Proceso',
                'tabla'       => 'dgoProcElec',
                'campoTabla'  => 'idDgoProcElec',
                'ancho'       => '313',
                'sql'         => "SELECT a.idDgoProcElec,a.descProcElecc as descripcion FROM dgoProcElec a WHERE a.delLog='N' and a.idGenEstado=1 ORDER BY a.idDgoProcElec DESC",
                'soloLectura' => 'false',
                'onclick'     => ''
            ),



        );
        return $formulario;
    }
    public function getFormularioCerrarOperativoReci($datos, $idcampo, $opc)
    {
        echo $this->getFormulario(
            ($this->getCamposCerrarOperativoReci()),
            $datos,
            $idcampo,
            $opc,
            $btnNuevo = true,
            $btnGraba = true,
            $btnImprime = false
        );
    }
}
