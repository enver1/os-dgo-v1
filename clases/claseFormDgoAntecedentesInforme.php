<?php

class FormDgoAntecedentesInforme extends Form
{

    public function getCamposDgoAntecedentesInforme()
    {
        $formulario = array(
            array(
                'tipo'        => 'textArea',
                'etiqueta'    => 'Antecedente',
                'campoTabla'  => 'descripcion',
                'ancho'       => '400',
                'alto'        => '200',
                'maxChar'     => '500',
                'mayusculas'  => '',
                'soloLectura' => 'false'
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

    public function getFormularioDgoAntecedentesInforme($datos, $idcampo, $opc)
    {
        echo $this->getFormulario(
            ($this->getCamposDgoAntecedentesInforme()),
            $datos,
            $idcampo,
            $opc,
            $btnNuevo = true,
            $btnGraba = true,
            $btnImprime = false
        );
    }
    public function getGrillaDgoAntecedentesInforme()
    {
        $gridS = array(
            'Código'      => 'idDgoAntecedentesInforme',
            'Descripción' => 'descripcion',
        );

        return $gridS;
    }
}
