<?php

class FormRecintoElectoral extends Form
{

    public function getCamposRecintoElectoral()
    {

        $formulario = array(
            array(
                'tipo'        => 'comboSQL',
                'etiqueta'    => 'Eje',
                'tabla'       => 'dgoTipoEje',
                'campoTabla'  => 'idDgoTipoEje1',
                'ancho'       => '313',
                'sql'         => "SELECT a.idDgoTipoEje as idDgoTipoEje1, a.descripcion FROM dgoTipoEje a  WHERE a.dgo_idDgoTipoEje is null AND a.delLog='N'",
                'soloLectura' => 'false',
                'onclick'     => 'onchange="cargaCmbEje(this.value)"',
            ),

            array(
                'tipo'          => 'comboDependiente',
                'etiqueta'      => '<span style="display:block" id="etTipoEje">Tipo Eje:</span>',
                'tabla'         => 'dgoTipoEje',
                'campoTabla'    => 'idDgoTipoEje2',
                'campoTablaDep' => 'idDgoTipoEje1',
                'sqlDep'        => "SELECT a.idDgoTipoEje as idDgoTipoEje2, a.descripcion FROM dgoTipoEje a  WHERE  a.delLog='N' AND a.dgo_idDgoTipoEje=",
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
                'sqlDep'        => "SELECT a.idDgoTipoEje, a.descripcion FROM dgoTipoEje a  WHERE a.delLog='N' AND a.dgo_idDgoTipoEje=",
                'ancho'         => '313',
                'soloLectura'   => 'false',
                'onclick'       => ''
            ),

            array(
                'tipo'        => 'hidden',
                'etiqueta'    => 'auxiliar:',
                'campoTabla'  => 'auxiliar',
                'ancho'       => '300',
                'maxChar'     => '',
                'soloLectura' => 'false'
            ),

            array(
                'tipo'        => 'text',
                'etiqueta'    => 'Latitud:',
                'campoTabla'  => 'latitud',
                'ancho'       => '300',
                'maxChar'     => '',
                'soloLectura' => 'false'
            ),

            array(
                'tipo'        => 'text',
                'etiqueta'    => 'Longitud:',
                'campoTabla'  => 'longitud',
                'ancho'       => '300',
                'maxChar'     => '',
                'soloLectura' => 'false'
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
                'tipo'        => 'arbol',
                'etiqueta'    => 'Parroquia/Cant&oacute;n/Prov/Pais:',
                'campoTabla'  => 'idGenDivPolitica',
                'campoValor'  => 'divPoliticaDescripcion',
                'pais'        => '',
                'niveles'     => '4',
                'tabla'       => 'genDivPolitica',
                'ancho'       => '200',
                'descripcion' => 'divPoliticaDescripcion'
            ),

            array(
                'tipo'        => 'text',
                'etiqueta'    => 'Código del Recinto:',
                'campoTabla'  => 'codRecintoElec',
                'ancho'       => '300',
                'alto'        => '50',
                'maxChar'     => '',
                'mayusculas'  => 'S',
                'soloLectura' => 'false'
            ),

            array(
                'tipo'        => 'text',
                'etiqueta'    => 'Nombre del Recinto:',
                'campoTabla'  => 'nomRecintoElec',
                'ancho'       => '300',
                'alto'        => '50',
                'maxChar'     => '',
                'mayusculas'  => 'S',
                'soloLectura' => 'false'
            ),

            array(
                'tipo'        => 'text',
                'etiqueta'    => 'Dirección del Recinto:',
                'campoTabla'  => 'direcRecintoElec',
                'ancho'       => '300',
                'alto'        => '50',
                'maxChar'     => '',
                'mayusculas'  => 'S',
                'soloLectura' => 'false'
            ),
            array(
                'tipo'        => 'hidden',
                'etiqueta'    => 'Direc',
                'campoTabla'  => 'idDgoT1',
                'ancho'       => '300',
                'alto'        => '50',
                'maxChar'     => '',
                'mayusculas'  => 'S',
                'soloLectura' => 'false'
            ),
            array(
                'tipo'        => 'hidden',
                'etiqueta'    => 'direccion',
                'campoTabla'  => 'direccion',
                'ancho'       => '300',
                'alto'        => '50',
                'maxChar'     => '',
                'mayusculas'  => 'S',
                'soloLectura' => 'false'
            ),

            array(
                'tipo'        => 'comboArreglo',
                'etiqueta'    => 'Tipo:',
                'campoTabla'  => 'tipoRecinto',
                'arreglo'     => array('URBANO' => 'URBANO', 'RURAL' => 'RURAL', 'ALEJADO' => 'ALEJADO'),
                'soloLectura' => 'false',
                'ancho'       => '313'
            ),

            array(
                'tipo'        => 'comboSQL',
                'etiqueta'    => 'Estado:',
                'tabla'       => 'genEstado',
                'campoTabla'  => 'idGenEstado',
                'ancho'       => '313',
                'sql'         => "SELECT idGenEstado, descripcion FROM genEstado",
                'soloLectura' => 'false',
                'onclick'     => ''
            ),

        );
        return $formulario;
    }

    public function getFormularioRecintoElectoral($datos, $idcampo, $opc)
    {
        echo $this->getFormulario(
            ($this->getCamposRecintoElectoral()),
            $datos,
            $idcampo,
            $opc,
            $btnNuevo = true,
            $btnGraba = true,
            $btnImprime = true
        );
    }

    public function getGrillaRecintoElectoral()
    {
        $gridS = array(
            'ID'        => 'idDgoReciElect',
            'Zona'      => 'Zona',
            'Subzona'   => 'Subzona',
            'Distrito'  => 'Distrito',
            'Provincia' => 'divPoliticaDescripcion',
            'Código'    => 'codRecintoElec',
            'Nombre'    => 'nomRecintoElec',
            'Dirección' => 'direcRecintoElec',
            'Estado'    => 'estado',
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
