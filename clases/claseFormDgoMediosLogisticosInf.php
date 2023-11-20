<?php

class FormDgoMediosLogisticosInf extends Form
{
    public function getCamposDgoMediosLogisticosInf()
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

    public function getFormularioDgoMediosLogisticosInf($datos, $idcampo, $opc)
    {
        echo $this->getFormulario(
            ($this->getCamposDgoMediosLogisticosInf()),
            $datos,
            $idcampo,
            $opc,
            $btnNuevo = true,
            $btnGraba = true,
            $btnImprime = false
        );
    }
    public function getGrillaDgoMediosLogisticosInf()
    {
        $gridS = array(
            'Código'      => 'idDgoMediosLogisticosInf',
            'Medio Logístico' => 'descripcion',
            'Cantidad' => 'cantidad',
        );

        return $gridS;
    }
}
