<?php

class FormDgoInfOrdenServicio extends Form
{
    public function getCamposDgoInfOrdenServicio()
    {
        $formulario = array(
            array(
                'tipo'        => 'comboSQL',
                'etiqueta'    => 'Tipo Calificación',
                'tabla'       => 'dgoTipoCalificacion',
                'campoTabla'  => 'idDgoTipoCalificacion',
                'ancho'       => '320',
                'sql'         => "SELECT idDgoTipoCalificacion, descripcion FROM dgoTipoCalificacion WHERE delLog='N'",
                'soloLectura' => 'false',
                'onclick'     => ''
            ),
            array(
                'tipo'                => 'persona',
                'etiqueta'            => 'Responsable del Informe',
                'campoTabla'          => 'idGenPersonaResponsable',
                'campoCedula'         => 'cedulaPersonaR',
                'campoNombre'         => 'nombrePersonaR',
                'ancho'               => '80',
                'maxChar'             => '10',
                'onclick'             => 'buscaResponsableInforme()',
                'botonBuscar'         => 'S',
                'botonOculto'         => 'true',
                'buscaxNombres'       => 'S',
                'soloLectura'         => 'false',
                'buscarTipoDocumento' => 'N',
                'esPolicia'           => 1,
                'limpiar'             => 'limpiarResponsable()',
            ),
            array(
                'tipo'                => 'persona',
                'etiqueta'            => 'Comandante de Unidad',
                'campoTabla'          => 'idGenPersonaComandante',
                'campoCedula'         => 'cedulaPersonaComandante',
                'campoNombre'         => 'nombrePersonaComandante',
                'ancho'               => '80',
                'maxChar'             => '10',
                'onclick'             => 'buscaComandante()',
                'botonBuscar'         => 'S',
                'botonOculto'         => 'true',
                'buscaxNombres'       => 'S',
                'soloLectura'         => 'false',
                'buscarTipoDocumento' => 'N',
                'esPolicia'           => 1,
                'limpiar'             => 'limpiarComandante()',
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
                'tipo'        => 'textArea',
                'etiqueta'    => 'Nombre Informe:',
                'campoTabla'  => 'nombreInforme',
                'ancho'       => '310',
                'alto'       => '100',
                'maxChar'     => '250',
                'mayusculas'  => 'N',
                'soloLectura' => 'false'
            ), array(
                'tipo'        => 'textArea',
                'etiqueta'    => 'Detalle Informe:',
                'campoTabla'  => 'detalleInforme',
                'ancho'       => '310',
                'alto'       => '200',
                'maxChar'     => '600',
                'mayusculas'  => 'N',
                'soloLectura' => 'false'
            ),

            array(
                'tipo'        => 'date',
                'etiqueta'    => 'Fecha Informe',
                'campoTabla'  => 'fechaInforme',
                'ancho'       => '310',
                'maxChar'     => '',
                'ayuda'       => '',
                'soloLectura' => 'true'
            ),

            array(
                'tipo'        => 'text',
                'etiqueta'    => 'Hora de la Orden:',
                'campoTabla'  => 'horaInforme',
                'ancho'       => '310',
                'maxChar'     => '',
                'mayusculas'  => 'N',
                'soloLectura' => 'false'
            ),


            array(
                'tipo'        => 'text',
                'etiqueta'    => 'Servidor Policia Elabora Informe:',
                'campoTabla'  => 'nombreElabora',
                'ancho'       => '310',
                'maxChar'     => '',
                'mayusculas'  => 'N',
                'soloLectura' => 'true'
            ),
            ////////////////////////////////hidden////////////////////////////////////////////////////////////////////////////////
            /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            array(
                'tipo'        => 'hidden',
                'etiqueta'    => 'responsableInforme:',
                'campoTabla'  => 'responsableInforme',
                'ancho'       => '200',
                'maxChar'     => '',
                'mayusculas'  => 'N',
                'soloLectura' => 'false'
            ),     array(
                'tipo'        => 'hidden',
                'etiqueta'    => 'comandanteUnidad:',
                'campoTabla'  => 'comandanteUnidad',
                'ancho'       => '200',
                'maxChar'     => '',
                'mayusculas'  => 'N',
                'soloLectura' => 'false'
            ),
            array(
                'tipo'        => 'hidden',
                'etiqueta'    => 'idGenGeoSenplades:',
                'campoTabla'  => 'idGenGeoSenplades',
                'ancho'       => '200',
                'maxChar'     => '',
                'mayusculas'  => 'N',
                'soloLectura' => 'false'
            ),
            array(
                'tipo'        => 'hidden',
                'etiqueta'    => 'idGenPersonaElabora:',
                'campoTabla'  => 'idGenPersonaElabora',
                'ancho'       => '200',
                'maxChar'     => '',
                'mayusculas'  => 'N',
                'soloLectura' => 'false'
            ),
            array(
                'tipo'        => 'hidden',
                'etiqueta'    => 'siglasDistrito:',
                'campoTabla'  => 'siglasDistrito',
                'ancho'       => '200',
                'maxChar'     => '',
                'mayusculas'  => 'N',
                'soloLectura' => 'false'
            ),
            array(
                'tipo'        => 'hidden',
                'etiqueta'    => 'anio:',
                'campoTabla'  => 'anio',
                'ancho'       => '200',
                'maxChar'     => '',
                'mayusculas'  => 'N',
                'soloLectura' => 'false'
            ),
            array(
                'tipo'        => 'hidden',
                'etiqueta'    => 'fechaHoy:',
                'campoTabla'  => 'fechaH',
                'ancho'       => '200',
                'maxChar'     => '',
                'mayusculas'  => 'N',
                'soloLectura' => 'false'
            ),
        );

        return $formulario;
    }

    public function getFormularioDgoInfOrdenServicio($datos, $idCampo, $opc)
    {
        echo ($this->getFormulario($this->getCamposDgoInfOrdenServicio(), $datos, $idCampo, $opc, true, true, false, false));
    }
    public function getGrillaDgoInfOrdenServicio()
    {
        $gridS = array(
            'Código'            => 'idDgoInfOrdenServicio',
            'Nombre del Informe'    => 'nombreInforme',
            'Número Informe'      => 'numeroInforme',
            'Fecha'             => 'fechaInforme',
            'Estado'            => 'estadoInforme',
        );

        return $gridS;
    }
}
