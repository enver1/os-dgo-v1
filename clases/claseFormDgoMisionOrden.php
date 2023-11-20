<?php

class FormDgoMisionOrden extends Form
{

    public function getCamposDgoMisionOrden()
    {
        $formulario = array(
            array(
                'tipo'        => 'textArea',
                'etiqueta'    => 'Misión:',
                'campoTabla'  => 'descripcion',
                'ancho'       => '400',
                'alto'        => '200',
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

    public function getFormularioDgoMisionOrden($datos, $idcampo, $opc)
    {
        echo $this->getFormulario(
            ($this->getCamposDgoMisionOrden()),
            $datos,
            $idcampo,
            $opc,
            $btnNuevo = true,
            $btnGraba = true,
            $btnImprime = false
        );
    }
    public function getGrillaDgoMisionOrden()
    {
        $gridS = array(
            'Código'      => 'idDgoDetalleMision',
            'Descripción' => 'descripcion',
        );

        return $gridS;
    }
}
