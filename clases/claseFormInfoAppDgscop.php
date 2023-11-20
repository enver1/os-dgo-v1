<?php

class FormInfoAppDgscop extends Form
{
    public function getCamposInfoAppDgscop()
    {
        $formulario = array(

            array(
                'tipo'        => 'comboSQL',
                'etiqueta'    => 'Módulo Unidad:',
                'tabla'       => 'dnaUnidadApp',
                'campoTabla'  => 'idDnaUnidadApp',
                'ancho'       => '260',
                'sql'         => "SELECT idDnaUnidadApp, descripcionUnidad as descripcion FROM dnaUnidadApp WHERE delLog='N' AND filtro='APP_DGSCOP'",
                'soloLectura' => 'false',
                'onclick'     => 'onchange="cargaOpcionesUnidad(this.value)"'
            ),

            array(
                'tipo'          => 'comboDependiente',
                'etiqueta'      => '<span style="display:block" id="etUnidad">Menú:</span>',
                'tabla'         => 'dnaInfoApp',
                'campoTabla'    => 'dna_IdDnaInfoApp',
                'campoTablaDep' => 'dna_IdDnaInfoApp',
                'sqlDep'        => "SELECT a.idDnaInfoApp AS dna_IdDnaInfoApp, a.nombreBoton as descripcion FROM dnaInfoApp a  WHERE  filtro='APP_DGSCOP' AND a.idDnaInfoApp=",
                'ancho'         => '260',
                'soloLectura'   => 'false',
                'onclick'       => ''
            ),



            array(
                'tipo'        => 'text',
                'etiqueta'    => 'Nombre Opción:',
                'campoTabla'  => 'nombreBoton',
                'ancho'       => '400',
                'maxChar'     => '',
                'mayusculas'  => 'S',
                'soloLectura' => 'false'
            ),

            array(
                'tipo'        => 'numero',
                'etiqueta'    => 'Orden:',
                'campoTabla'  => 'orden',
                'ancho'       => '150',
                'maxChar'     => '',
                'mayusculas'  => '',
                'soloLectura' => 'false'
            ),

            array(
                'tipo'         => 'file',
                'etiqueta'     => '(*) Icono: *jpg o png (Max 1000 Kbytes)',
                'campoTabla'   => 'icono',
                'pathFile'     => '../../../descargas/operaciones/appDgscop/imagenes/',
                'fileSize'     => '100000000',
                'fileTypes'    => 'jpg,png',
                'accept'       => 'image/png,image/jpg,image/jpeg',
                'obligatorio'  => 'N',
                'nombreObjeto' => 'imgAlb'
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
        );

        return $formulario;
    }

    public function getFormularioInfoAppDgscop($datos, $idCampo, $opc)
    {
        echo ($this->getFormulario($this->getCamposInfoAppDgscop(), $datos, $idCampo, $opc, true, true, true, false));
    }
    public function getGrillaInfoAppDgscop()
    {
        $gridS = array(
            'Código'            => 'idDnaInfoApp',
            'Módulo Unidad'   => 'descripcionUnidad',
            'Menú' => 'menu',
            'Sub Menú' => 'subMenu',
            'Orden' => 'orden',
            'Icono' => 'icono',
            'Estado'            => 'estado',
        );

        return $gridS;
    }
}