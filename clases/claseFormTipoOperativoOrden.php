<?php

class FormTipoOperativoOrden extends Form
{
    public function getCamposTipoOperativoOrden()
    {
        $formulario = array(

            array(
                'tipo'        => 'text',
                'etiqueta'    => 'Cod. Padre:',
                'campoTabla'  => 'genTipoOperativo_idGenTipoOperativo',
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
                'etiqueta'    => 'Tipo Operativo:',
                'campoTabla'  => 'descripcion',
                'ancho'       => '240',
                'alto'        => '50',
                'maxChar'     => '',
                'mayusculas'  => 'S',
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

    public function getFormularioTipoOperativoOrden($datos, $idcampo, $opc)
    {
        echo $this->getFormulario(
            ($this->getCamposTipoOperativoOrden()),
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
        $this->getFormularioArbol($this->getCamposTipoOperativoOrden(), $datos, $idCampo, $opc, false, false, false, false, $directorioArbol, $tituloArbol, $check, $altoArbol);
    }
    public function getGrillaTipoOperativoOrden()
    {
        $gridS = array(
            'Código'            => 'idGenTipoOperativo',
            'Descripción'       => 'descrip1',
            'Detalle'      => 'descripcion',
        );
        return $gridS;
    }
}
