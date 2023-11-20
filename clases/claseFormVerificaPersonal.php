<?php

class FormTipoServicioOp extends Form
{

    public function getCamposTipoServicioOp()
    {
        $formulario = array(
            array(
                'tipo'        => 'text',
                'etiqueta'    => 'Tipo Servicio:',
                'campoTabla'  => 'descripcion',
                'ancho'       => '200',
                'maxChar'     => '',
                'mayusculas'  => 'N',
                'soloLectura' => 'false'),

        );

        return $formulario;

    }

    public function getFormularioTipoServicioOp( $datos, $idcampo, $opc)
    {
        echo $this->getFormulario(
            ($this->getCamposTipoServicioOp()),
            $datos,
            $idcampo,
            $opc,
            $btnNuevo = true,
            $btnGraba = true,
            $btnImprime = true,
            $campoId = false);
    }
    public function getGrillaTipoServicioOp()
    {
        $gridS = array(
            'Código'      => 'idHdrTipoServicio',
            'Descripción' => 'descripcion',

        );

        return $gridS;
    }
}
