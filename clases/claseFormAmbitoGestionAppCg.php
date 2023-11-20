<?php
class FormAmbitoGestionAppCg extends Form
{
    public function getCamposAmbitoGestionAppCg()
    {
        $formulario = array(
            array(
                'tipo'                => 'persona',
                'etiqueta'            => 'Servidor Policial',
                'campoTabla'          => 'idGenPersona',
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
                'tipo'        => 'comboArreglo',
                'etiqueta'    => 'Tipo Permiso:',
                'campoTabla'  => 'tipoPermiso',
                'arreglo'     => array('PUBLICO' => 'PUBLICO', 'PRIVADO' => 'PRIVADO'),
                'soloLectura' => 'false',
                'ancho'       => '328'
            ),


            array(
                'tipo'        => 'text',
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

    public function getGrillaAmbitoGestionAppCg()
    {
        $gridS = array(
            'Código' => 'idCgAmbitoGestionAppCg',
            'Servidor Policial' => 'apenom',
            'Dirección' => 'direccion',
            'Designación' => 'unidad',
            'Estado' => 'estado',
        );

        return $gridS;
    }

    public function getFormularioAmbitoGestionAppCg($datos, $idcampo, $opc)
    {
        echo $this->getFormulario(
            ($this->getCamposAmbitoGestionAppCg()),
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
