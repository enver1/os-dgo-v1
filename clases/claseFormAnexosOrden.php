<?php

class FormAnexosOrden extends Form
{

    public function getCamposAnexosOrden()
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

    public function getFormularioAnexosOrden($datos, $idcampo, $opc)
    {
        echo $this->getFormulario(
            ($this->getCamposAnexosOrden()),
            $datos,
            $idcampo,
            $opc,
            $btnNuevo = true,
            $btnGraba = true,
            $btnImprime = false
        );
    }
    public function getGrillaAnexosOrden()
    {
        $gridS = array(
            'Código'      => 'idDgoAnexosOrden',
            'Descripción' => 'descripcion',
        );

        return $gridS;
    }
}
