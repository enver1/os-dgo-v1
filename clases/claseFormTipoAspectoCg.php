<?php

class FormTipoAspectoCg extends Form
{
    public function getCamposTipoAspectoCg()
    {
        $formulario = array(

            array(
                'tipo'        => 'text',
                'etiqueta'    => 'Cod. Padre:',
                'campoTabla'  => 'cg_idCgTipoAspecto',
                'ancho'       => '243',
                'maxChar'     => '',
                'soloLectura' => 'true'
            ),

            array(
                'tipo'        => 'text',
                'etiqueta'    => 'Descripción Padre:',
                'campoTabla'  => 'descripcionPadre',
                'ancho'       => '243',
                'maxChar'     => '',
                'soloLectura' => 'true'
            ),
            array(
                'tipo'        => 'textArea',
                'etiqueta'    => 'Tipo Aspecto:',
                'campoTabla'  => 'descripcion',
                'ancho'       => '240',
                'alto'        => '50',
                'maxChar'     => '',
                'mayusculas'  => 'N',
                'soloLectura' => 'false'
            ),
            array(
                'tipo'        => 'comboSQL',
                'etiqueta'    => 'Estado:',
                'tabla'       => 'genEstado',
                'campoTabla'  => 'idGenEstado',
                'ancho'       => '255',
                'campoValor'  => 'descripcion',
                'sql'         => "SELECT a.idGenEstado , a.descripcion FROM genEstado a",
                'soloLectura' => 'false',
                'onclick'     => ''
            ),

        );

        return $formulario;
    }

    public function getFormularioTipoAspectoCg($datos, $idcampo, $opc)
    {
        echo $this->getFormulario(
            ($this->getCamposTipoAspectoCg()),
            $datos,
            $idcampo,
            $opc,
            $btnNuevo = true,
            $btnGraba = true,
            $btnImprime = true
        );
    }
    public function getForma($datos, $idCampo, $opc, $directorioArbol, $tituloArbol = '', $check = '', $altoArbol = '350')
    {
        $this->getFormularioArbol($this->getCamposTipoAspectoCg(), $datos, $idCampo, $opc, false, false, false, false, $directorioArbol, $tituloArbol, $check, $altoArbol);
    }
    public function getGrillaTipoAspectoCg()
    {
        $gridS = array(
            'Código'            => 'idCgTipoAspecto',
            'Descripción'       => 'descrip1',
            'Detalle'      => 'descripcion',
        );
        return $gridS;
    }
}
