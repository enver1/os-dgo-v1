<?php

class FormRegistroNovElec extends Form
{

    public function getCamposRegistroNovElec()
    {

        $formulario = array(

            array(
                'tipo'          => 'persona',
                'etiqueta'      => 'Servior Policial',
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
                'etiqueta'    => 'Nombre del Jefe / Encargado:',
                'campoTabla'  => 'jefe',
                'ancho'       => '300',
                'maxChar'     => '',
                'mayusculas'  => 'S',
                'soloLectura' => 'true'
            ),

            array(
                'tipo'        => 'text',
                'etiqueta'    => 'Proceso',
                'campoTabla'  => 'descProcElecc',
                'ancho'       => '300',
                'soloLectura' => 'true',
                'onclick'     => ''
            ),

            array(
                'tipo'        => 'text',
                'etiqueta'    => 'Eje',
                'campoTabla'  => 'idDgoTipoEje1',
                'ancho'       => '300',
                'soloLectura' => 'true',
                'onclick'     => ''
            ),

            array(
                'tipo'        => 'text',
                'etiqueta'    => '<span style="display:block" id="etTipoEje">Tipo Eje:</span>',
                'campoTabla'  => 'idDgoTipoEje2',
                'ancho'       => '300',
                'soloLectura' => 'true',
                'onclick'     => ''
            ),

            array(
                'tipo'        => 'text',
                'etiqueta'    => '<span style="display:block" id="etUnidad">Unidad:</span>',
                'campoTabla'  => 'idDgoTipoEje',
                'ancho'       => '300',
                'soloLectura' => 'true',
                'onclick'     => ''
            ),



            array(
                'tipo'        => 'text',
                'etiqueta'    => 'Recinto / Unidad Policial:',
                'campoTabla'  => 'unidad',
                'ancho'       => '300',
                'maxChar'     => '',
                'soloLectura' => 'true'
            ),
            array(
                'tipo'        => 'text',
                'etiqueta'    => 'Id. Operativo:',
                'campoTabla'  => 'idOperativo',
                'ancho'       => '300',
                'alto'        => '50',
                'maxChar'     => '',
                'mayusculas'  => 'S',
                'soloLectura' => 'true'
            ),

            array(
                'tipo'        => 'hidden',
                'etiqueta'    => 'Id. Operativo:',
                'campoTabla'  => 'idDgoPerAsigOpe',
                'ancho'       => '300',
                'alto'        => '50',
                'maxChar'     => '',
                'mayusculas'  => 'S',
                'soloLectura' => 'true'
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
                'etiqueta'    => 'Tipo Novedad:',
                'tabla'       => 'dgoNovedadesElect',
                'campoTabla'  => 'idNovedad',
                'ancho'       => '310',
                'sql'         => "SELECT idDgoNovedadesElect idNovedad, descripcion FROM dgoNovedadesElect WHERE ISNULL(dgo_idDgoNovedadesElect) AND  idDgoNovedadesElect<>1 AND idDgoNovedadesElect<>38 AND idDgoNovedadesElect<>39 AND idDgoNovedadesElect<>40",
                'soloLectura' => 'false',
                'onclick'     => 'onchange="cargaCmbTipoNovedades(this.value)"'
            ),

            array(
                'tipo'          => 'comboDependiente',
                'etiqueta'      => '<span style="display:block" id="etDispositivo">Novedad:</span>',
                'tabla'         => 'dgoNovedadesElect',
                'campoTabla'    => 'idDgoNovedadesElect',
                'campoValor'    => 'idDgoNovedadesElect',
                'campoTablaDep' => 'idDgoNovedadesElect',
                'sqlDep'        => "SELECT
                                        a.idDgoNovedadesElect,
                                        a.descripcion
                                    FROM
                                        dgoNovedadesElect a
                                    WHERE a.delLog='N'
                                    AND a.idDgoNovedadesElect=",
                'ancho'         => '310',
                'soloLectura'   => 'false',
                'onclick'       => 'onchange="verCampos(this.value)"',
            ),
            array(
                'tipo'          => 'comboDependiente',
                'etiqueta'      => '<span style="display:block" id="etDispositivoHijo">Delito:</span>',
                'tabla'         => 'dgoNovedadesElect',
                'campoTabla'    => 'idDgoNovedadesElect1',
                'campoValor'    => 'idDgoNovedadesElect1',
                'campoTablaDep' => 'idDgoNovedadesElect',
                'sqlDep'        => "SELECT
                                        a.idDgoNovedadesElect as idDgoNovedadesElect1,
                                        a.idDgoNovedadesElect,
                                        a.descripcion
                                    FROM
                                        dgoNovedadesElect a
                                    WHERE a.delLog='N'
                                    AND a.idDgoNovedadesElect=",
                'ancho'         => '310',
                'soloLectura'   => 'false',
                'onclick'       => 'onchange=""',
            ),

            array(
                'tipo'         => 'file',
                'etiqueta'     => '',
                'campoTabla'   => 'imagen',
                'pathFile'     => '../../../descargas/movil/operaciones/elecciones2021/',
                'fileSize'     => '5000000',
                'fileTypes'    => 'png',
                'accept'       => 'image/png',
                'nombreObjeto' => 'myfile',
                'obligatorio'  => 'N'
            ),

            array(
                'tipo'        => 'text',
                'etiqueta'    => '<span style="display:block" id="etDocumento">Documento:</span>',
                'campoTabla'  => 'documento',
                'ancho'       => '300',
                'maxChar'     => '',
                'mayusculas'  => 'S',
                'soloLectura' => 'false'
            ),

            array(
                'tipo'        => 'text',
                'etiqueta'    => '<span style="display:block" id="etCedula">Cédula:</span>',
                'campoTabla'  => 'cedula',
                'ancho'       => '300',
                'maxChar'     => '',
                'mayusculas'  => 'S',
                'soloLectura' => 'false'
            ),

            array(
                'tipo'        => 'text',
                'etiqueta'    => '<span style="display:block" id="etLider">Lider Organización</span>',
                'campoTabla'  => 'lider',
                'ancho'       => '300',
                'maxChar'     => '',
                'mayusculas'  => 'S',
                'soloLectura' => 'false'
            ),

            array(
                'tipo'        => 'text',
                'etiqueta'    => '<span style="display:block" id="etBoleta">Número de Boleta / Citación:</span>',
                'campoTabla'  => 'boleta',
                'ancho'       => '300',
                'maxChar'     => '',
                'mayusculas'  => 'S',
                'soloLectura' => 'false'
            ),

            array(
                'tipo'        => 'hidden',
                'etiqueta'    => 'auxiliar',
                'campoTabla'  => 'auxiliar',
                'ancho'       => '300',
                'maxChar'     => '',
                'mayusculas'  => 'S',
                'soloLectura' => 'false'
            ),


            array(
                'tipo'        => 'hidden',
                'etiqueta'    => 'E1',
                'campoTabla'  => 'idDgoTipoE1',
                'ancho'       => '300',
                'soloLectura' => 'true',
                'onclick'     => ''
            ),

            array(
                'tipo'        => 'hidden',
                'etiqueta'    => 'e2',
                'campoTabla'  => 'idDgoTipoE2',
                'ancho'       => '300',
                'soloLectura' => 'true',
                'onclick'     => ''
            ),

            array(
                'tipo'        => 'hidden',
                'etiqueta'    => 'E',
                'campoTabla'  => 'idDgoTipoE',
                'ancho'       => '300',
                'soloLectura' => 'true',
                'onclick'     => ''
            ),
            array(
                'tipo'          => 'persona',
                'etiqueta'      => 'Cédula Detenido:',
                'campoTabla'    => 'idGenPersonaD',
                'campoCedula'   => 'cedulaPersonaD',
                'campoNombre'   => 'nombrePersonaD',
                'onclick'       => 'buscaConductorB()',
                'maxChar'             => '10',
                'botonBuscar'         => 'S',
                'botonOculto'         => 'true',
                'buscaxNombres'       => 'S',
                'soloLectura'         => 'false',
                'buscarTipoDocumento' => 'N',
                'esPolicia'           => 0,
                'limpiar'       => 'limpiarD()',
            ),

        );
        return $formulario;
    }

    public function getFormularioRegistroNovElec($datos, $idcampo, $opc)
    {
        echo $this->getFormulario(
            ($this->getCamposRegistroNovElec()),
            $datos,
            $idcampo,
            $opc,
            $btnNuevo = true,
            $btnGraba = true,
            $btnImprime = false
        );
    }

    public function getGrillaRegistroNovElec()
    {
        $gridS = array(
            'Id. Nov'                 => 'idDgoNovReciElec',
            'Id Operativo'            => 'idDgoCreaOpReci',
            'Nombre Recinto / Unidad' => 'nomRecintoElec',
            'Persona Reporta'         => 'jefe_operativo',
            'Tipo Novedad'            => 'Tipo',
            'Novedad'                 => 'Novedad',
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
