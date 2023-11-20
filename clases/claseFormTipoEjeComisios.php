<?php

class FormTipoEjeComisios extends Form
{
    public function getCamposTipoEjeComisios()
    {
        $formulario = array(
            array(
                'tipo'        => 'text',
                'etiqueta'    => 'Cod. Padre:',
                'campoTabla'  => 'dgo_idDgoTipoEje',
                'ancho'       => '240',
                'maxChar'     => '',
                'soloLectura' => 'true'
            ),
            array(
                'tipo'        => 'text',
                'etiqueta'    => 'Descripción Padre:',
                'campoTabla'  => 'descripcionPadre',
                'ancho'       => '240',
                'maxChar'     => '',
                'soloLectura' => 'true'
            ),
            array(
                'tipo'        => 'textArea',
                'etiqueta'    => 'Eje:',
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
                'ancho'       => '250',
                'campoValor'  => 'descripcion',
                'sql'         => "SELECT a.idGenEstado, a.descripcion FROM genEstado a",
                'soloLectura' => 'false',
                'onclick'     => ''
            ),

        );

        return $formulario;
    }

    public function getFormularioTipoEjeComisios($datos, $idcampo, $opc)
    {
        echo $this->getFormulario(
            ($this->getCamposTipoEjeComisios()),
            $datos,
            $idcampo,
            $opc,
            $btnNuevo = true,
            $btnGraba = true,
            $btnImprime = true,
            $btn = false
        );
    }
    public function getForma($datos, $idCampo, $opc, $directorioArbol, $tituloArbol = '', $check = '', $altoArbol = '400')
    {
        $this->getFormularioArbol($this->getCamposTipoEjeComisios(), $datos, $idCampo, $opc, false, false, true, false, $directorioArbol, $tituloArbol, $check, $altoArbol);
    }
    public function getGrillaTipoEjeComisios()
    {
        $gridS = array(
            'Código'      => 'idDgoTipoEje',
            'Tipo Eje'    => 'descrip1',
            'Descripción' => 'descripcion',
            'Estado' => 'estado',

        );
        return $gridS;
    }
}
