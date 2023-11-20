<?php

class FormMediosLogisticosOrden extends Form
{

    public function getCamposMediosLogisticosOrden()
    {
        $formulario = array(
            array(
                'tipo'        => 'text',
                'etiqueta'    => 'Medio Logístico',
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

    public function getFormularioMediosLogisticosOrden($datos, $idcampo, $opc)
    {
        echo $this->getFormulario(
            ($this->getCamposMediosLogisticosOrden()),
            $datos,
            $idcampo,
            $opc,
            $btnNuevo = true,
            $btnGraba = true,
            $btnImprime = true
        );
    }
    public function getGrillaMediosLogisticosOrden()
    {
        $gridS = array(
            'Código'      => 'idDgoMediosLogisticos',
            'Descripción' => 'descripcion',
            'Estado'      => 'estado',
        );

        return $gridS;
    }
}
