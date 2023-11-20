<?php

class FormNovedadesElect extends Form
{

    public function getCamposNovedadesElect()
    {
        $formulario = array(
            array(
                'tipo'        => 'text',
                'etiqueta'    => 'Cod. Padre:',
                'campoTabla'  => 'dgo_idDgoNovedadesElect',
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
                'etiqueta'    => 'Novedad:',
                'campoTabla'  => 'descripcion',
                'ancho'       => '240',
                'alto'        => '50',
                'maxChar'     => '',
                'mayusculas'  => 'S',
                'soloLectura' => 'false'
            ),
            array(
                'tipo'        => 'text',
                'etiqueta'    => 'Nombre Corto:',
                'campoTabla'  => 'nomCorto',
                'ancho'       => '200',
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
                'ancho'       => '215',
                'campoValor'  => 'descripcion',
                'sql'         => "SELECT a.idGenEstado, a.descripcion FROM genEstado a",
                'soloLectura' => 'false',
                'onclick'     => ''
            ),

        );

        return $formulario;
    }

    public function getFormularioNovedadesElect($datos, $idcampo, $opc)
    {
        echo $this->getFormulario(
            ($this->getCamposNovedadesElect()),
            $datos,
            $idcampo,
            $opc,
            $btnNuevo = true,
            $btnGraba = true,
            $btnImprime = false
        );
    }
    public function getForma($datos, $idCampo, $opc, $directorioArbol, $tituloArbol = '', $check = '', $altoArbol = '350')
    {
        $this->getFormularioArbol($this->getCamposNovedadesElect(), $datos, $idCampo, $opc, false, false, true, false, $directorioArbol, $tituloArbol, $check, $altoArbol);
    }
    public function getGrillaNovedadesElect()
    {
        $gridS = array(
            'Código'      => 'idDgoNovedadesElect',
            'Tipo Eje'    => 'descrip1',
            'Descripción' => 'descripcion',
            'Estado'      => 'estado',

        );
        return $gridS;
    }
}
