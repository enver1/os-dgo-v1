<?php

class FormClasificacionOrden extends Form
{

    public function getCamposClasificacionOrden()
    {
        $formulario = array(
            array(
                'tipo'        => 'text',
                'etiqueta'    => 'Descripción Calificación',
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

    public function getFormularioClasificacionOrden($datos, $idcampo, $opc)
    {
        echo $this->getFormulario(
            ($this->getCamposClasificacionOrden()),
            $datos,
            $idcampo,
            $opc,
            $btnNuevo = true,
            $btnGraba = true,
            $btnImprime = true
        );
    }
    public function getGrillaMatriz()
    {
        $gridS = array(
            'Código'      => 'idDgoTipoCalificacion',
            'Descripción' => 'descripcion',
            'Estado'      => 'estado',
        );

        return $gridS;
    }
}
