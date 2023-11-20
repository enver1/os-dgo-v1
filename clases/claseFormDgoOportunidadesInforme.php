<?php

class FormDgoOportunidadesInforme extends Form
{

    public function getCamposDgoOportunidadesInforme()
    {
        $formulario = array(
            array(
                'tipo'        => 'textArea',
                'etiqueta'    => 'Descripción',
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

    public function getFormularioDgoOportunidadesInforme($datos, $idcampo, $opc)
    {
        echo $this->getFormulario(
            ($this->getCamposDgoOportunidadesInforme()),
            $datos,
            $idcampo,
            $opc,
            $btnNuevo = true,
            $btnGraba = true,
            $btnImprime = false
        );
    }
    public function getGrillaDgoOportunidadesInforme()
    {
        $gridS = array(
            'Código'      => 'idDgoOportunidadesInf',
            'Descripción' => 'descripcion',
        );

        return $gridS;
    }
}
