<?php

class FormTipoTipificacion extends Form
{

    public function getCamposTipoTipificacion()
    {
        $formulario = array(
            array(
                'tipo'        => 'text',
                'etiqueta'    => 'Cod. Padre:',
                'campoTabla'  => 'gen_idGenTipoTipificacion',
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
                'tipo'        => 'text',
                'etiqueta'    => 'Nombre:',
                'campoTabla'  => 'descripcion',
                'ancho'       => '300',
                'maxChar'     => '50',
                'soloLectura' => 'false',
                'mayusculas'  => 'S',
            ),

            array(
                'tipo'        => 'comboSQL',
                'etiqueta'    => 'Tipo Servicio:',
                'tabla'       => 'hdrTipoServicio',
                'campoTabla'  => 'idHdrTipoServicio',
                'ancho'       => '310',
                'campoValor'  => 'descripcion',
                'sql'         => "SELECT a.idHdrTipoServicio , a.descripcion FROM hdrTipoServicio a",
                'soloLectura' => 'false',
                'onclick'     => ''
            ),
            array(
                'tipo'        => 'textArea',
                'etiqueta'    => 'Detalle:',
                'campoTabla'  => 'detalle',
                'ancho'       => '300',
                'maxChar'     => '300',
                'alto'        => '75',
                'soloLectura' => 'false',
                'mayusculas'  => 'S',
            ),
            array(
                'tipo'        => 'text',
                'etiqueta'    => 'Siglas:',
                'campoTabla'  => 'siglas',
                'ancho'       => '300',
                'maxChar'     => '10',
                'soloLectura' => 'false',
                'mayusculas'  => 'S',
            ),
            array(
                'tipo'        => 'comboSQL',
                'etiqueta'    => 'Estado:',
                'tabla'       => 'genEstado',
                'campoTabla'  => 'idGenEstado',
                'ancho'       => '310',
                'campoValor'  => 'descripcion',
                'sql'         => "SELECT a.idGenEstado , a.descripcion FROM genEstado a",
                'soloLectura' => 'false',
                'onclick'     => ''
            ),

        );

        return $formulario;
    }

    public function getFormularioTipoTipificacion($datos, $idcampo, $opc)
    {
        echo $this->getFormulario(
            ($this->getCamposTipoTipificacion()),
            $datos,
            $idcampo,
            $opc,
            $btnNuevo = true,
            $btnGraba = true,
            $btnImprime = true
        );
    }

    public function getFormaArbol($datos, $idCampo, $opc, $directorioArbol, $tituloArbol = '', $check = '', $altoArbol = '350')
    {
        $this->getFormularioArbol($this->getCamposTipoTipificacion(), $datos, $idCampo, $opc, false, false, false, false, $directorioArbol, $tituloArbol, $check, $altoArbol);
    }

    public function getGrillaTipoTipificacion()
    {
        $gridS = array(
            'Código'                => 'idGenTipoTipificacion',
            'Tipo Tipificación'     => 'descrip1',
            'Descripción'           => 'descripcion',
            'Detalle'               => 'detalle',
            'Servicio Tipificación' => 'servicio',
            'Siglas'                => 'siglas',

        );
        return $gridS;
    }
}
