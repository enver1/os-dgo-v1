<?php

class FormFuerzasAlternativas extends Form
{

    public function getCamposFuerzasAlternativas()
    {
        $formulario = array(
            array(
                'tipo'        => 'text',
                'etiqueta'    => 'Fuerza Alternativa',
                'campoTabla'  => 'descripcion',
                'ancho'       => '220',
                'maxChar'     => '',
                'mayusculas'  => 'S',
                'soloLectura' => 'false'
            ),

            array(
                'tipo'        => 'comboSQL',
                'etiqueta'    => 'Estado:',
                'tabla'       => 'genEstado',
                'campoTabla'  => 'idGenEstado',
                'ancho'       => '235',
                'sql'         => "SELECT idGenEstado, descripcion FROM genEstado",
                'soloLectura' => 'false',
                'onclick'     => ''
            ),

        );

        return $formulario;
    }

    public function getFormularioFuerzasAlternativas($datos, $idcampo, $opc)
    {
        echo $this->getFormulario(
            ($this->getCamposFuerzasAlternativas()),
            $datos,
            $idcampo,
            $opc,
            $btnNuevo = true,
            $btnGraba = true,
            $btnImprime = true
        );
    }
    public function getGrillaFuerzasAlternativas()
    {
        $gridS = array(
            'Código'      => 'idDgoTipoFuerzasAlternativas',
            'Descripción' => 'descripcion',
            'Estado'      => 'estado',
        );

        return $gridS;
    }
}
