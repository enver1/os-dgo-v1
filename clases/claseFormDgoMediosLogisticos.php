<?php

class FormDgoMediosLogisticos extends Form
{
    public function getCamposDgoMediosLogisticos()
    {
        $formulario = array(

            array(
                'tipo'        => 'comboSQL',
                'etiqueta'    => 'Medio Logistico:',
                'tabla'       => 'dgoMediosLogisticos',
                'campoTabla'  => 'idDgoMediosLogisticos',
                'ancho'       => '260',
                'sql'         => "SELECT a.idDgoMediosLogisticos,a.descripcion FROM  dgoMediosLogisticos a WHERE a.idGenEstado=1 AND a.delLog='N'",
                'soloLectura' => 'false',
                'onclick'     => ''
            ),
            array(
                'tipo'        => 'text',
                'etiqueta'    => 'Cantidad:',
                'campoTabla'  => 'cantidad',
                'ancho'       => '250',
                'maxChar'     => '4',
                'mayusculas'  => 'S',
                'soloLectura' => 'false',
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

    public function getFormularioDgoMediosLogisticos($datos, $idcampo, $opc)
    {
        echo $this->getFormulario(
            ($this->getCamposDgoMediosLogisticos()),
            $datos,
            $idcampo,
            $opc,
            $btnNuevo = true,
            $btnGraba = true,
            $btnImprime = false
        );
    }
    public function getGrillaDgoMediosLogisticos()
    {
        $gridS = array(
            'Código'      => 'idDgoDetalleMediosLogisticos',
            'Medio Logístico' => 'descripcion',
            'Cantidad' => 'cantidad',
        );

        return $gridS;
    }
}
