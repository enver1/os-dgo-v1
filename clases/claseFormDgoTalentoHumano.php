<?php

class FormDgoTalentoHumano extends Form
{

    public function getCamposDgoTalentoHumano()
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
                'onclick'             => 'buscaPolicia();',
                'botonBuscar'         => 'S',
                'botonOculto'         => 'true',
                'buscaxNombres'       => 'S',
                'soloLectura'         => 'false',
                'buscarTipoDocumento' => 'N',
                'esPolicia'           => 1,
                'limpiar'             => 'limpiar()',
            ),
            array(
                'tipo'        => 'text',
                'etiqueta'    => 'Unidad:',
                'campoTabla'  => 'unidad',
                'ancho'       => '300',
                'maxChar'     => '',
                'mayusculas'  => 'S',
                'soloLectura' => 'true',
            ),
            array(
                'tipo'        => 'text',
                'etiqueta'    => 'Función:',
                'campoTabla'  => 'funcion',
                'ancho'       => '300',
                'maxChar'     => '',
                'mayusculas'  => 'S',
                'soloLectura' => 'true',
            ),
            array(
                'tipo'        => 'hidden',
                'etiqueta'    => 'idDgpUnidad:',
                'campoTabla'  => 'idDgpUnidad',
                'ancho'       => '250',
                'maxChar'     => '',
                'mayusculas'  => 'S',
                'soloLectura' => 'false',
            ),      array(
                'tipo'        => 'hidden',
                'etiqueta'    => 'idDgpGrado:',
                'campoTabla'  => 'idDgpGrado',
                'ancho'       => '250',
                'maxChar'     => '',
                'mayusculas'  => 'S',
                'soloLectura' => 'false',
            ),

            array(
                'tipo'        => 'hidden',
                'etiqueta'    => 'idDgoOrdenServicio:',
                'campoTabla'  => 'idDgoOrdenServicio',
                'ancho'       => '250',
                'maxChar'     => '',
                'mayusculas'  => 'S',
                'soloLectura' => 'false',
            ),
        );

        return $formulario;
    }

    public function getFormularioDgoTalentoHumano($datos, $idcampo, $opc)
    {
        echo $this->getFormulario(
            ($this->getCamposDgoTalentoHumano()),
            $datos,
            $idcampo,
            $opc,
            $btnNuevo = true,
            $btnGraba = true,
            $btnImprime = false
        );
    }
    public function getGrillaDgoTalentoHumano()
    {
        $gridS = array(
            'Código'      => 'idDgoTalentoHumano',
            'Unidad' => 'unidad',
            'Servidor Policial' => 'nombrePersona',
            'Designación' => 'funcion',

        );

        return $gridS;
    }
}
