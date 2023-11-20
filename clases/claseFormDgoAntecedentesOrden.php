<?php

class FormDgoAntecedentesOrden extends Form
{

    public function getCamposDgoAntecedentesOrden()
    {
        $formulario = array(
            array(
                'tipo'        => 'textArea',
                'etiqueta'    => 'Antecedente:',
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

    public function getFormularioDgoAntecedentesOrden($datos, $idcampo, $opc)
    {
        echo $this->getFormulario(
            ($this->getCamposDgoAntecedentesOrden()),
            $datos,
            $idcampo,
            $opc,
            $btnNuevo = true,
            $btnGraba = true,
            $btnImprime = false
        );
    }
    public function getGrillaDgoAntecedentesOrden()
    {
        $gridS = array(
            'Código'      => 'idDgoAntecedentes',
            'Descripción' => 'descripcion',
        );

        return $gridS;
    }
}
