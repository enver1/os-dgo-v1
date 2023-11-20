<?php

class FormDgoInstruccionesOrden extends Form
{

    public function getCamposDgoInstruccionesOrden()
    {
        $formulario = array(
            array(
                'tipo'        => 'comboArreglo',
                'etiqueta'    => 'Temporalidad',
                'campoNombre' => 'temporalidad',
                'campoTabla'  => 'temporalidad',
                'arreglo'     => array('ANTES' => 'ANTES', 'DURANTE' => 'DURANTE', 'DESPUÉS' => 'DESPUÉS'),
                'soloLectura' => 'false',
                'ancho'       => '280',
                'onclick'     => '',
            ),


            array(
                'tipo'        => 'textArea',
                'etiqueta'    => 'Instrucción',
                'campoTabla'  => 'descripcion',
                'ancho'       => '400',
                'alto'        => '200',
                'maxChar'     => '500',
                'mayusculas'  => '',
                'soloLectura' => 'false'
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

    public function getFormularioDgoInstruccionesOrden($datos, $idcampo, $opc)
    {
        echo $this->getFormulario(
            ($this->getCamposDgoInstruccionesOrden()),
            $datos,
            $idcampo,
            $opc,
            $btnNuevo = true,
            $btnGraba = true,
            $btnImprime = false
        );
    }
    public function getGrillaDgoInstruccionesOrden()
    {
        $gridS = array(
            'Código'      => 'idDgoDetalleInstrucciones',
            'Temporalidad' => 'temporalidad',
            'Descripción' => 'descripcion',
        );

        return $gridS;
    }
}
