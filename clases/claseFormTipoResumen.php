<?php

class FormTipoResumen extends Form
{

    public function getCamposTipoResumen()
    {
        $formulario = array(
            array(
                'tipo'        => 'text',
                'etiqueta'    => 'Cod. Padre:',
                'campoTabla'  => 'hdr_idHdrTipoResum',
                'ancho'       => '300',
                'maxChar'     => '',
                'soloLectura' => 'true',
            ),
            array(
                'tipo'        => 'text',
                'etiqueta'    => 'Cat&aacute;logo Padre:',
                'campoTabla'  => 'descripcionPadre',
                'ancho'       => '300',
                'maxChar'     => '',
                'soloLectura' => 'true',
            ),
            array(
                'tipo'        => 'comboSQL',
                'etiqueta'    => 'Grupo Resumen:',
                'tabla'       => 'hdrGrupResum',
                'campoTabla'  => 'idHdrGrupResum',
                'ancho'       => '310',
                'campoValor'  => 'descripcion',
                'sql'         => "SELECT a.idHdrGrupResum , a.desHdrGrupResum as descripcion FROM hdrGrupResum a where a.delLog='N'",
                'soloLectura' => 'false',
                'onclick'     => ''),
            array(
                'tipo'        => 'text',
                'etiqueta'    => 'Nombre:',
                'campoTabla'  => 'desHdrTipoResum',
                'ancho'       => '300',
                'maxChar'     => '50',
                'soloLectura' => 'false',
                'mayusculas'  => 'S',
            ),

            array(
                'tipo'        => 'text',
                'etiqueta'    => 'Clase Actor:',
                'campoTabla'  => 'claseActor',
                'ancho'       => '300',
                'maxChar'     => '10',
                'mayusculas'  => 'S',
                'soloLectura' => 'false',
                'mayusculas'  => 'S',
            ),

        );

        return $formulario;

    }

    public function getFormularioTipoResumen($datos, $idcampo, $opc)
    {
        echo $this->getFormulario(
            ($this->getCamposTipoResumen()),
            $datos,
            $idcampo,
            $opc,
            $btnNuevo = true,
            $btnGraba = true,
            $btnImprime = true);
    }

    public function getFormaArbol($datos, $idCampo, $opc, $directorioArbol, $tituloArbol = '', $check = '', $altoArbol = '350')
    {
        $this->getFormularioArbol($this->getCamposTipoResumen(), $datos, $idCampo, $opc, false, false, false, false, $directorioArbol, $tituloArbol, $check, $altoArbol);
    }

    public function getGrillaTipoResumen()
    {
        $gridS = array(
            'Código'        => 'idHdrTipoResum',
            'Grupo Resumen' => 'desHdrGrupResum',
            'Descripción'   => 'descripcionPadre',
            'Detalle'       => 'desHdrTipoResum',
            'Clase Actor'   => 'claseActor',

        );
        return $gridS;
    }

}
