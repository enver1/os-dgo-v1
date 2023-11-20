<?php

class FormGrupoResumen extends Form
{

    public function getCamposGrupoResumen()
    {
        $formulario = array(
            array(
                'tipo'        => 'text',
                'etiqueta'    => 'Tipo Servicio:',
                'campoTabla'  => 'desHdrGrupResum',
                'ancho'       => '200',
                'maxChar'     => '',
                'mayusculas'  => 'N',
                'soloLectura' => 'false'
            ),

            array(
                'tipo'        => 'text',
                'etiqueta'    => 'Categorizacion:',
                'campoTabla'  => 'categorizacion',
                'ancho'       => '200',
                'maxChar'     => '',
                'mayusculas'  => 'N',
                'soloLectura' => 'false'
            ),

        );

        return $formulario;
    }

    public function getFormularioGrupoResumen($datos, $idcampo, $opc)
    {
        echo $this->getFormulario(
            ($this->getCamposGrupoResumen()),
            $datos,
            $idcampo,
            $opc,
            $btnNuevo = true,
            $btnGraba = true,
            $btnImprime = true,
            $campoId = false
        );
    }
    public function getGrillaGrupoResumen()
    {
        $gridS = array(
            'Código'         => 'idHdrGrupResum',
            'Descripción'    => 'desHdrGrupResum',
            'Categorizacion' => 'categorizacion',

        );

        return $gridS;
    }
}
