<?php

class FormUsuariosAppDgscop extends Form
{
    public function getCamposUsuariosAppDgscop()
    {
        $formulario = array(
            array(
                'tipo'        => 'hidden',
                'etiqueta'    => 'idGenUsuario:',
                'campoTabla'  => 'idGenUsuario',
                'ancho'       => '350',
                'maxChar'     => '150',
                'soloLectura' => 'false'
            ),
            array(
                'tipo'                => 'persona',
                'etiqueta'            => 'Servidor Policial',
                'campoTabla'          => 'idGenPersona',
                'campoCedula'         => 'cedulaPersonaC',
                'campoNombre'         => 'nombrePersonaC',
                'ancho'               => '80',
                'maxChar'             => '10',
                'onclick'             => 'buscaConductor()',
                'botonBuscar'         => 'S',
                'botonOculto'         => 'true',
                'buscaxNombres'       => 'S',
                'soloLectura'         => 'false',
                'buscarTipoDocumento' => 'N',
                'esPolicia'           => 1,
                'limpiar'             => 'limpiarR()',
            ),

            array(
                'tipo'        => 'comboSQL',
                'etiqueta'    => 'Módulo Unidad:',
                'tabla'       => 'dnaUnidadApp',
                'campoTabla'  => 'idDnaUnidadApp',
                'ancho'       => '200',
                'sql'         => "SELECT idDnaUnidadApp, descripcionUnidad as descripcion FROM dnaUnidadApp WHERE delLog='N' AND filtro='APP_DGSCOP'",
                'soloLectura' => 'false',
                'onclick'     => ''
            ),
            array(
                'tipo'        => 'comboSQL',
                'etiqueta'    => 'Tipo Permiso',
                'tabla'       => 'dnaPerfilVer',
                'campoTabla'  => 'idDnaPerfilVer',
                'ancho'       => '200',
                'sql'         => "SELECT idDnaPerfilVer, descripcion FROM dnaPerfilVer WHERE delLog='N'",
                'soloLectura' => 'false',
                'onclick'     => ''
            ),
            array(
                'tipo'        => 'comboSQL',
                'etiqueta'    => 'Estado:',
                'tabla'       => 'genEstado',
                'campoTabla'  => 'idGenEstado',
                'ancho'       => '200',
                'sql'         => "SELECT idGenEstado, descripcion FROM genEstado",
                'soloLectura' => 'false',
                'onclick'     => ''
            ),

        );

        return $formulario;
    }

    public function getFormularioUsuariosAppDgscop($datos, $idCampo, $opc)
    {
        echo ($this->getFormulario($this->getCamposUsuariosAppDgscop(), $datos, $idCampo, $opc, true, true, true, false));
    }
    public function getGrillaUsuariosAppDgscop()
    {
        $gridS = array(
            'Código'            => 'idDnaUsuarioUnidadApp',
            'Servidor Policial'   => 'policia',
            'Modulo Unidad' => 'modulo',
            'Tipo Permiso' => 'permiso',
            'Estado'            => 'estado',
        );

        return $gridS;
    }
}
