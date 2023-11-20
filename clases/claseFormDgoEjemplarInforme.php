<?php

class FormDgoEjemplarInforme extends Form
{

    public function getCamposDgoEjemplarInforme()
    {
        $formulario = array(
            array(
                'tipo'        => 'comboArreglo',
                'etiqueta'    => 'Tipo Ejemplar',
                'campoNombre' => 'destino',
                'campoTabla'  => 'destino',
                'arreglo'     => array('PARA INFORMACIÓN' => 'PARA INFORMACIÓN', 'PARA EJECUCIÓN' => 'PARA EJECUCIÓN'),
                'soloLectura' => 'false',
                'ancho'       => '280',
                'onclick'     => '',
            ),
            array(
                'tipo'        => 'text',
                'etiqueta'    => 'Unidad de Destino:',
                'campoTabla'  => 'descripcion',
                'ancho'       => '280',
                'maxChar'     => '800',
                'mayusculas'  => '',
                'soloLectura' => 'false'
            ),

            array(
                'tipo'        => 'hidden',
                'etiqueta'    => 'idDgoInfOrdenServicio:',
                'campoTabla'  => 'idDgoInfOrdenServicio',
                'ancho'       => '250',
                'maxChar'     => '',
                'mayusculas'  => 'S',
                'soloLectura' => 'false',
            ),

        );

        return $formulario;
    }

    public function getFormularioDgoEjemplarInforme($datos, $idcampo, $opc)
    {
        echo $this->getFormulario(
            ($this->getCamposDgoEjemplarInforme()),
            $datos,
            $idcampo,
            $opc,
            $btnNuevo = true,
            $btnGraba = true,
            $btnImprime = false
        );
    }
    public function getGrillaDgoEjemplarInforme()
    {
        $gridS = array(
            'Código'      => 'idDgoEjemplarInforme',
            'Destino' => 'destino',
            'Descripción' => 'descripcion',
        );

        return $gridS;
    }
}
