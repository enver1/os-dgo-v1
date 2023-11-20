<?php

class FormDgoFuerzasPropias extends Form
{

    public function getCamposDgoFuerzasPropias()
    {
        $formulario = array(

            array(
                'tipo' => 'arbol',
                'etiqueta' => 'Unidad de Servicio:',
                'tabla' => 'dgpUnidad',
                'campoTabla' => 'idDgpUnidad',
                'campoValor' => 'unidadDescripcion',
                'ancho' => '200',
                'maxChar' => '',
                'fontSize' => '12px',
                'soloLectura' => 'false'
            ),
            array(
                'tipo'        => 'text',
                'etiqueta'    => 'Oficiales Superiores:',
                'campoTabla'  => 'superiores',
                'ancho'       => '250',
                'maxChar'     => '4',
                'mayusculas'  => 'S',
                'soloLectura' => 'false',
            ),
            array(
                'tipo'        => 'text',
                'etiqueta'    => 'Oficiales Subalternos:',
                'campoTabla'  => 'subalternos',
                'ancho'       => '250',
                'maxChar'     => '4',
                'mayusculas'  => 'S',
                'soloLectura' => 'false',
            ),
            array(
                'tipo'        => 'text',
                'etiqueta'    => 'Clases y Policias:',
                'campoTabla'  => 'clases',
                'ancho'       => '250',
                'maxChar'     => '4',
                'mayusculas'  => 'S',
                'soloLectura' => 'false',
            ),
            array(
                'tipo'        => 'hidden',
                'etiqueta'    => 'idDgoInfOrdenServicio:',
                'campoTabla'  => 'idDgoInfOrdenServicio',
                'ancho'       => '250',
                'maxChar'     => '',
                'mayusculas'  => 'S',
                'soloLectura' => 'false',
            ),
        );

        return $formulario;
    }

    public function getFormularioDgoFuerzasPropias($datos, $idcampo, $opc)
    {
        echo $this->getFormulario(
            ($this->getCamposDgoFuerzasPropias()),
            $datos,
            $idcampo,
            $opc,
            $btnNuevo = true,
            $btnGraba = true,
            $btnImprime = false
        );
    }
    public function getGrillaDgoFuerzasPropias()
    {
        $gridS = array(
            'Código'      => 'idDgoFuerzasPropias',
            'Unidad' => 'Unidad',
            'Tipo Unidad' => 'descripcion',
            'Superiores' => 'superiores',
            'Subalternos' => 'subalternos',
            'Clases' => 'clases',

        );

        return $gridS;
    }
}
