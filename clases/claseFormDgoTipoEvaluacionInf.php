<?php

class FormDgoTipoEvaluacionInf extends Form
{

    public function getCamposDgoTipoEvaluacionInf()
    {
        $formulario = array(
            array(
                'tipo'        => 'text',
                'etiqueta'    => 'Tipo Evaluación:',
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

    public function getFormularioDgoTipoEvaluacionInf($datos, $idcampo, $opc)
    {
        echo $this->getFormulario(
            ($this->getCamposDgoTipoEvaluacionInf()),
            $datos,
            $idcampo,
            $opc,
            $btnNuevo = true,
            $btnGraba = true,
            $btnImprime = true
        );
    }
    public function getGrillaDgoTipoEvaluacionInf()
    {
        $gridS = array(
            'Código'      => 'idDgoTipoEvaluacionInf',
            'Descripción' => 'descripcion',
            'Estado'      => 'estado',
        );

        return $gridS;
    }
}
