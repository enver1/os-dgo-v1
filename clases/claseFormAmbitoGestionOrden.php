<?php
class FormAmbitoGestionOrden extends FormOperacionesOrden
{
    public function getCamposAmbitoGestionOrden()
    {
        $formulario = array(
            array(
                'tipo'        => 'arbol',
                'etiqueta'    => 'Distrito',
                'campoTabla'  => 'idGenGeoSenplades',
                'campoValor'  => 'senpladesDescripcion',
                'ancho'       => '260px',
                'pais'        => 'N',
                'niveles'     => '3',
                'tabla'       => 'genGeoSenplades',
                'descripcion' => 'senpladesDescripcion'
            ),
            array(
                'tipo'                => 'persona',
                'etiqueta'            => 'Servidor Policial',
                'campoTabla'          => 'idGenUsuario',
                'campoCedula'         => 'cedulaPersona',
                'campoNombre'         => 'nombrePersona',
                'ancho'               => '80',
                'maxChar'             => '10',
                'onclick'             => 'buscaPersona()',
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
                'etiqueta'    => 'Estado:',
                'tabla'       => 'genEstado',
                'campoTabla'  => 'idGenEstado',
                'campoValor'  => 'descripcion',
                'soloLectura' => 'false',
                'sql'         => "SELECT a.idGenEstado,a.descripcion FROM genEstado a ",
                'onclick'     => '',
                'ancho'       => '328'
            ),
            array(
                'tipo'        => 'hidden',
                'etiqueta'    => 'Usuario:',
                'campoTabla'  => 'usuario',
                'ancho'       => '220',
                'maxChar'     => '',
                'mayusculas'  => 'S',
                'soloLectura' => 'false'
            ),

        );

        return $formulario;
    }

    public function getGrillaAmbitoGestionOrden()
    {
        $gridS = array(
            'Código' => 'idDgoAmbitoGestionOrden',
            'Zona' => 'Zona',
            'Subzona' => 'Subzona',
            'Distrito' => 'Distrito',
            'Servidor Policial' => 'apenom',
            'Estado' => 'estado',
        );

        return $gridS;
    }

    public function getFormularioAmbitoGestionOrden($datos, $idcampo, $opc)
    {
        echo $this->getFormulario(
            ($this->getCamposAmbitoGestionOrden()),
            $datos,
            $idcampo,
            $opc,
            $btnNuevo = true,
            $btnGraba = true,
            $btnImprime = true,
            $campo = false
        );
    }
}
