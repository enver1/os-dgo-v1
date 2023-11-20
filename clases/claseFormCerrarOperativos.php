<?php

class FormCerrarOperativos extends Form
{

    public function getCamposCerrar()
    {

        $formulario = array(
            array(
                'tipo'        => 'text',
                'etiqueta'    => 'Código Operativo',
                'campoTabla'  => 'idHdrEvento',
                'ancho'       => '250',
                'alto'        => '50',
                'maxChar'     => '',
                'mayusculas'  => 'S',
                'soloLectura' => 'true'
            ),
            array(
                'tipo'        => 'text',
                'etiqueta'    => 'Lugar Operativo',
                'campoTabla'  => 'siglasGeoSenplades',
                'ancho'       => '250',
                'alto'        => '50',
                'maxChar'     => '',
                'mayusculas'  => 'S',
                'soloLectura' => 'true'
            ),
            array(
                'tipo'        => 'text',
                'etiqueta'    => 'Tipo Operativo',
                'campoTabla'  => 'descripcion',
                'ancho'       => '250',
                'alto'        => '50',
                'maxChar'     => '',
                'mayusculas'  => 'S',
                'soloLectura' => 'true'
            ),
        );

        return $formulario;
    }
    public function getFormCerrarOperativos($datos, $idcampo, $opc)
    {
        echo $this->getFormulario(
            ($this->getCamposCerrar()),
            $datos,
            $idcampo,
            $opc,
            $btnNuevo = false,
            $btnGraba = true,
            $btnImprime = false
        );
    }
}
