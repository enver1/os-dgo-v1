<?php

class FormCrearOrdenServicio extends Form
{
    public function getCamposCrearOrdenServicio()
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
                'tipo'        => 'comboSQL',
                'etiqueta'    => 'Operativo',
                'tabla'       => 'genTipoOperativo',
                'campoTabla'  => 'idGenTipoOperativo',
                'ancho'       => '320',
                'sql'         => "SELECT idGenTipoOperativo, descripcion FROM genTipoOperativo WHERE delLog='N' AND genTipoOperativo_idGenTipoOperativo is null",
                'soloLectura' => 'false',
                'onclick'     => 'onchange="cargaCmbOperativo(this.value);"'
            ),

            array(
                'tipo'          => 'comboDependiente',
                'etiqueta'      => '<span style="display:block" id="etOperativo">Tipo Operativo:</span>',
                'tabla'         => 'genTipoOperativo',
                'campoTabla'    => 'idGenTipoOperativoHijo',
                'campoTablaDep' => 'idGenTipoOperativoHijo',
                'sqlDep'        => "SELECT a.idGenTipoOperativo as idGenTipoOperativoHijo, a.descripcion FROM genTipoOperativo a  WHERE a.idGenTipoOperativo=",
                'ancho'         => '320',
                'soloLectura'   => 'false',
                'onclick'       => ''
            ),
            array(
                'tipo'                => 'persona',
                'etiqueta'            => 'Jefe del Operativo',
                'campoTabla'          => 'idGenPersonaJefeOperativo',
                'campoCedula'         => 'cedulaPersonaJefe',
                'campoNombre'         => 'nombrePersonaJefe',
                'ancho'               => '80',
                'maxChar'             => '10',
                'onclick'             => 'buscaJefeOperativo()',
                'botonBuscar'         => 'S',
                'botonOculto'         => 'true',
                'buscaxNombres'       => 'S',
                'soloLectura'         => 'false',
                'buscarTipoDocumento' => 'N',
                'esPolicia'           => 1,
                'limpiar'             => 'limpiarJefe()',
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
                'etiqueta'    => 'Nombre Operativo:',
                'campoTabla'  => 'nombreOperativo',
                'ancho'       => '310',
                'alto'       => '100',
                'maxChar'     => '250',
                'mayusculas'  => 'N',
                'soloLectura' => 'false'
            ), array(
                'tipo'        => 'textArea',
                'etiqueta'    => 'Detalle Operativo:',
                'campoTabla'  => 'detalleOperativo',
                'ancho'       => '310',
                'alto'       => '200',
                'maxChar'     => '600',
                'mayusculas'  => 'N',
                'soloLectura' => 'false'
            ),

            array(
                'tipo'        => 'date',
                'etiqueta'    => 'Fecha Inicio Orden',
                'campoTabla'  => 'fechaOrden',
                'ancho'       => '310',
                'maxChar'     => '',
                'ayuda'       => '',
                'soloLectura' => 'true'
            ),
            array(
                'tipo'        => 'date',
                'etiqueta'    => 'Fecha Fin Orden',
                'campoTabla'  => 'fechaFinOrden',
                'ancho'       => '310',
                'maxChar'     => '',
                'ayuda'       => '',
                'soloLectura' => 'true'
            ),
            array(
                'tipo'        => 'text',
                'etiqueta'    => 'Hora de la Orden:',
                'campoTabla'  => 'horaOrden',
                'ancho'       => '310',
                'maxChar'     => '',
                'mayusculas'  => 'N',
                'soloLectura' => 'false'
            ),
            array(
                'tipo'        => 'text',
                'etiqueta'    => 'Hora de Formación:',
                'campoTabla'  => 'horaFormacion',
                'ancho'       => '310',
                'maxChar'     => '',
                'mayusculas'  => 'N',
                'onclick'     => 'validate_hora(this.value)',
                'soloLectura' => 'false'
            ),

            array(
                'tipo'        => 'text',
                'etiqueta'    => 'Servidor Policia Elabora Orden:',
                'campoTabla'  => 'nombreElabora',
                'ancho'       => '310',
                'maxChar'     => '',
                'mayusculas'  => 'N',
                'soloLectura' => 'true'
            ),
            ////////////////////////////////hidden
            array(
                'tipo'        => 'hidden',
                'etiqueta'    => 'jefeOperativo:',
                'campoTabla'  => 'jefeOperativo',
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

    public function getFormularioCrearOrdenServicio($datos, $idCampo, $opc)
    {
        echo ($this->getFormulario($this->getCamposCrearOrdenServicio(), $datos, $idCampo, $opc, true, true, false, false));
    }
    public function getGrillaCrearOrdenServicio()
    {
        $gridS = array(
            'Código'            => 'idDgoOrdenServicio',
            'Operativo'         => 'operativo',
            'Tipo Operativo'    => 'tipoOperativo',
            'Nombre del Operativo'    => 'nombreOperativo',
            'Número Orden'      => 'numeroOrden',
            'Fecha'             => 'fechaOrden',
            'Estado'            => 'estadoOrden',
        );

        return $gridS;
    }
}
