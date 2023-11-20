<?php

class FormDgoAnexosInforme extends Form
{

    public function getCamposDgoAnexosInforme()
    {
        $formulario = array(

            array(
                'tipo'        => 'text',
                'etiqueta'    => 'Descripción Anexo:',
                'campoTabla'  => 'descripcion',
                'ancho'       => '280',
                'maxChar'     => '800',
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

    public function getFormularioDgoAnexosInforme($datos, $idcampo, $opc)
    {
        echo $this->getFormulario(
            ($this->getCamposDgoAnexosInforme()),
            $datos,
            $idcampo,
            $opc,
            $btnNuevo = true,
            $btnGraba = true,
            $btnImprime = false
        );
    }
    public function getGrillaDgoAnexosInforme()
    {
        $gridS = array(
            'Código'      => 'idDgoAnexosInforme',
            'Descripción' => 'descripcion',
        );

        return $gridS;
    }
}
