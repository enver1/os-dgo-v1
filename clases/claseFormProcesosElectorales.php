<?php

class FormProcesosElectorales extends Form
{

    public function getCamposProcesosElectorales()
    {
        $formulario = array(

            array(
                'tipo'        => 'text',
                'etiqueta'    => 'Descripción:',
                'campoTabla'  => 'descProcElecc',
                'ancho'       => '220',
                'alto'        => '50',
                'maxChar'     => '',
                'mayusculas'  => 'S',
                'soloLectura' => 'false'),

            array(
                'tipo'        => 'date',
                'etiqueta'    => 'Fecha Inicio Proceso*:',
                'campoTabla'  => 'fechaInici',
                'ancho'       => '220',
                'maxChar'     => '',
                'ayuda'       => '',
                'soloLectura' => 'true'),

            array(
                'tipo'        => 'date',
                'etiqueta'    => 'Fecha Fin Proceso*:',
                'campoTabla'  => 'fechaFin',
                'ancho'       => '220',
                'maxChar'     => '',
                'ayuda'       => '',
                'soloLectura' => 'true'),
            array(
                'tipo'        => 'arbol',
                'etiqueta'    => 'Lugar Evento:',
                'campoTabla'  => 'idGenGeoSenplades',
                'campoValor'  => 'senpladesDescripcion',
                'pais'        => '',
                'niveles'     => '4',
                'tabla'       => 'genGeoSenplades',
                'ancho'       => '200',
                'descripcion' => 'senpladesDescripcion'),

            array(
                'tipo'        => 'comboArreglo',
                'etiqueta'    => 'Tipo Evento:',
                'campoTabla'  => 'tipo',
                'arreglo'     => array('N' => 'NACIONAL', 'L' => 'LOCAL'),
                'soloLectura' => 'false',
                'ancho'       => '220'),

            array(
                'tipo'        => 'comboSQL',
                'etiqueta'    => 'Estado:',
                'tabla'       => 'genEstado',
                'campoTabla'  => 'idGenEstado',
                'ancho'       => '220',
                'sql'         => "SELECT idGenEstado, descripcion FROM genEstado",
                'soloLectura' => 'false',
                'onclick'     => ''),

        );
        return $formulario;

    }

    public function getFormularioProcesosElectorales($datos, $idcampo, $opc)
    {
        echo $this->getFormulario(
            ($this->getCamposProcesosElectorales()),
            $datos,
            $idcampo,
            $opc,
            $btnNuevo = true,
            $btnGraba = true,
            $btnImprime = true);
    }

    public function getGrillaProcesosElectorales()
    {
        $gridS = array(
            'Código'       => 'idDgoProcElec',
            'Tipo'         => 'tipo',
            'Lugar'        => 'descripcion',
            'Descripcion'  => 'descProcElecc',
            'Fecha Inicio' => 'fechaInici',
            'Fecha Fin'    => 'fechaFin',
            'Estado'       => 'estado',
        );
        return $gridS;
    }

}
