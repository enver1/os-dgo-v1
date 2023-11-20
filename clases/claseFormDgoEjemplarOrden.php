<?php

class FormDgoEjemplarOrden extends Form
{

    public function getCamposDgoEjemplarOrden()
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
                'etiqueta'    => 'idDgoOrdenServicio:',
                'campoTabla'  => 'idDgoOrdenServicio',
                'ancho'       => '250',
                'maxChar'     => '',
                'mayusculas'  => 'S',
                'soloLectura' => 'false',
            ),

        );

        return $formulario;
    }

    public function getFormularioDgoEjemplarOrden($datos, $idcampo, $opc)
    {
        echo $this->getFormulario(
            ($this->getCamposDgoEjemplarOrden()),
            $datos,
            $idcampo,
            $opc,
            $btnNuevo = true,
            $btnGraba = true,
            $btnImprime = false
        );
    }
    public function getGrillaDgoEjemplarOrden()
    {
        $gridS = array(
            'Código'      => 'idDgoEjemplarOrden',
            'Destino' => 'destino',
            'Descripción' => 'descripcion',
        );

        return $gridS;
    }
}
