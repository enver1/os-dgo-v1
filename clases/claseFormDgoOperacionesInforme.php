<?php

class FormDgoOperacionesInforme extends Form
{

    public function getCamposDgoOperacionesInforme()
    {
        $formulario = array(
            array(
                'tipo'        => 'textArea',
                'etiqueta'    => 'Operaciones Realizadas',
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

    public function getFormularioDgoOperacionesInforme($datos, $idcampo, $opc)
    {
        echo $this->getFormulario(
            ($this->getCamposDgoOperacionesInforme()),
            $datos,
            $idcampo,
            $opc,
            $btnNuevo = true,
            $btnGraba = true,
            $btnImprime = false
        );
    }
    public function getGrillaDgoOperacionesInforme()
    {
        $gridS = array(
            'Código'      => 'idDgoOperacionesInf',
            'Descripción' => 'descripcion',
        );

        return $gridS;
    }
}
