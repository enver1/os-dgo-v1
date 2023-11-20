<?php

class FormDetalleInfoAppDgscop extends Form
{
    public function getCamposDetalleInfoAppDgscop()
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
                'campoTabla'    => 'idDnaInfoApp',
                'campoTablaDep' => 'idDnaInfoApp',
                'sqlDep'        => "SELECT a.idDnaInfoApp, a.nombreBoton as descripcion FROM dnaInfoApp a  WHERE  filtro='APP_DGSCOP' AND a.idDnaInfoApp=",
                'ancho'         => '260',
                'soloLectura'   => 'false',
                'onclick'       => 'onchange="cargaOpcionesUnidadHijas(this.value)"'
            ),
            array(
                'tipo'          => 'comboDependiente',
                'etiqueta'      => '<span style="display:block" id="etUnidadHija">Sub Menú:</span>',
                'tabla'         => 'dnaInfoApp',
                'campoTabla'    => 'idDnaInfoAppHija',
                'campoTablaDep' => 'idDnaInfoAppHija',
                'sqlDep'        => "SELECT a.idDnaInfoApp as idDnaInfoAppHija, a.nombreBoton as descripcion FROM dnaInfoApp a  WHERE  filtro='APP_DGSCOP' AND a.idDnaInfoApp=",
                'ancho'         => '260',
                'soloLectura'   => 'false',
                'onclick'       => ''
            ),



            array(
                'tipo'        => 'text',
                'etiqueta'    => 'Detalle Opción:',
                'campoTabla'  => 'detalle',
                'ancho'       => '250',
                'maxChar'     => '',
                'mayusculas'  => 'S',
                'soloLectura' => 'false'
            ),

            array(
                'tipo'        => 'comboArreglo',
                'etiqueta'    => 'Tipo Información',
                'campoNombre' => 'filtro',
                'campoTabla'  => 'filtro',
                'arreglo'     => array('CONTACTO' => 'CONTACTO', 'PDF' => 'PDF', 'URL' => 'URL'),
                'soloLectura' => 'false',
                'ancho'       => '260',
                'onclick'     => 'onclick=verOpcionPDF(this.value);',
            ),

            array(
                'tipo'        => 'text',
                'etiqueta'    => '<span style="display:block" id="etAccion">Detalle Información:</span>',
                'campoTabla'  => 'accion1',
                'ancho'       => '250',
                'maxChar'     => '',
                'mayusculas'  => 'N',
                'soloLectura' => 'false'
            ),

            array(
                'tipo'         => 'file',
                'etiqueta'    => '(*) Documento PDF',
                'campoTabla'   => 'accion',
                'pathFile'     => '../../../descargas/operaciones/appDgscop/archivos/',
                'fileSize'     => '5000000',
                'fileTypes'    => 'pdf',
                'accept'       => '.pdf',
                'obligatorio'  => 'N',
                'nombreObjeto' => 'imgAlb1'
            ),

            array(
                'tipo'        => 'comboSQL',
                'etiqueta'    => 'Tipo Permiso',
                'tabla'       => 'dnaPerfilVer',
                'campoTabla'  => 'idDnaPerfilVer',
                'ancho'       => '260',
                'sql'         => "SELECT idDnaPerfilVer, descripcion FROM dnaPerfilVer WHERE delLog='N' AND idDnaPerfilVer<3",
                'soloLectura' => 'false',
                'onclick'     => ''
            ),

            array(
                'tipo'        => 'comboSQL',
                'etiqueta'    => 'Estado:',
                'tabla'       => 'genEstado',
                'campoTabla'  => 'idGenEstado',
                'ancho'       => '260',
                'sql'         => "SELECT idGenEstado, descripcion FROM genEstado",
                'soloLectura' => 'false',
                'onclick'     => ''
            ),
            array(
                'tipo'         => 'file',
                'etiqueta'    => '(*) Icono Detalle: *jpg o png (Max 500 Kbytes)',
                'campoTabla'   => 'iconoDetalle',
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

    public function getFormularioDetalleInfoAppDgscop($datos, $idCampo, $opc)
    {
        echo ($this->getFormulario($this->getCamposDetalleInfoAppDgscop(), $datos, $idCampo, $opc, true, true, true, false));
    }
    public function getGrillaDetalleInfoAppDgscop()
    {
        $gridS = array(
            'Código'            => 'idDnaInfoDetalleApp',
            'Módulo Unidad'   => 'modulo',
            'Menú' => 'menu',
            'Sub Menú' => 'subMenu',
            'Detalle'   => 'detalle',
            'Información'   => 'accion',
            'Filtro' => 'filtro',
            'Estado'            => 'estado',
        );

        return $gridS;
    }
}
