<?php

class FormUnidadesDgscopApp extends Form
{
    public function getCamposUnidadesDgscopApp()
    {
        $formulario = array(

            array(
                'tipo'        => 'text',
                'etiqueta'    => 'Nombre de Unidad:',
                'campoTabla'  => 'descripcionUnidad',
                'ancho'       => '400',
                'maxChar'     => '',
                'mayusculas'  => 'S',
                'soloLectura' => 'false'
            ),

            array(
                'tipo'        => 'comboSQL',
                'etiqueta'    => 'Estado:',
                'tabla'       => 'genEstado',
                'campoTabla'  => 'idGenEstado',
                'ancho'       => '200',
                'sql'         => "SELECT idGenEstado, descripcion FROM genEstado",
                'soloLectura' => 'false',
                'onclick'     => ''
            ),
            array(
                'tipo'         => 'file',
                'etiqueta'    => '(*) Imagen Unidad: *jpg o png (Max 500 Kbytes)',
                'campoTabla'   => 'imagenUnidad',
                'pathFile'     => '../../../descargas/operaciones/appDgscop/imagenes/',
                'fileSize'     => '5000000',
                'fileTypes'    => 'jpg,png',
                'accept'       => 'image/png,image/jpg,image/jpeg',
                'obligatorio'  => 'N',
                'nombreObjeto' => 'imgAlb'
            ),
        );

        return $formulario;
    }

    public function getFormularioUnidadesDgscopApp($datos, $idCampo, $opc)
    {
        echo ($this->getFormulario($this->getCamposUnidadesDgscopApp(), $datos, $idCampo, $opc, true, true, true, false));
    }
    public function getGrillaUnidadesDgscopApp()
    {
        $gridS = array(
            'Código'            => 'idDnaUnidadApp',
            'Módulo Unidad'     => 'descripcionUnidad',
            'Estado'            => 'estado',
        );

        return $gridS;
    }
}
