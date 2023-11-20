<?php

class FormDgoEvaluacionInf extends Form
{

    public function getCamposDgoEvaluacionInf()
    {
        $formulario = array(
            array(
                'tipo'        => 'comboSQL',
                'etiqueta'    => 'Tipo de Evaluación:',
                'tabla'       => 'dgoTipoEvaluacionInf',
                'campoTabla'  => 'idDgoTipoEvaluacionInf',
                'ancho'       => '320',
                'sql'         => "SELECT idDgoTipoEvaluacionInf, descripcion FROM dgoTipoEvaluacionInf WHERE delLog='N'",
                'soloLectura' => 'false',
                'onclick'     => 'onchange="cargaCmbOperativo(this.value);"'
            ),

            array(
                'tipo'        => 'textArea',
                'etiqueta'    => 'Descripción Evaluación:',
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

    public function getFormularioDgoEvaluacionInf($datos, $idcampo, $opc)
    {
        echo $this->getFormulario(
            ($this->getCamposDgoEvaluacionInf()),
            $datos,
            $idcampo,
            $opc,
            $btnNuevo = true,
            $btnGraba = true,
            $btnImprime = false
        );
    }
    public function getGrillaDgoEvaluacionInf()
    {
        $gridS = array(
            'Código'      => 'idDgoEvaluacionInf',
            'Tipo Evaluación' => 'tipo',
            'Descripción' => 'descripcion',
        );

        return $gridS;
    }
}
