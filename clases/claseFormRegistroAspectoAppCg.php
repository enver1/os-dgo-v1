<?php

class FormRegistroAspectoAppCg extends Form
{

    public function getCamposRegistroAspectoAppCg()
    {
        $formulario = array(
            /*     array(
                'tipo'                => 'persona',
                'etiqueta'            => 'Servidor Policial Observador',
                'campoTabla'          => 'idGenPersonaJefe',
                'campoCedula'         => 'cedulaPersonaJefe',
                'campoNombre'         => 'nombrePersonaJefe',
                'ancho'               => '80',
                'maxChar'             => '10',
                'onclick'             => 'buscaJefe()',
                'botonBuscar'         => 'S',
                'botonOculto'         => 'true',
                'buscaxNombres'       => 'S',
                'soloLectura'         => 'false',
                'buscarTipoDocumento' => 'N',
                'esPolicia'           => 1,
                'limpiar'             => 'limpiarJefe()',
            ),*/
            array(
                'tipo'                => 'persona',
                'etiqueta'            => 'Cédula Servidor Policial',
                'campoTabla'          => 'idGenPersona',
                'campoCedula'         => 'cedulaPersona',
                'campoNombre'         => 'nombrePersona',
                'ancho'               => '80',
                'maxChar'             => '10',
                'onclick'             => 'buscaPolicia()',
                'botonBuscar'         => 'S',
                'botonOculto'         => 'true',
                'buscaxNombres'       => 'S',
                'soloLectura'         => 'false',
                'buscarTipoDocumento' => 'N',
                'esPolicia'           => 1,
                'limpiar'             => 'limpiar()',
            ),
            array(
                'tipo'        => 'comboSQL',
                'etiqueta'    => 'Tipo Aspecto',
                'tabla'       => 'cgTipoAspecto',
                'campoTabla'  => 'idCgTipoAspecto2',
                'ancho'       => '313',
                'sql'         => "SELECT a.idCgTipoAspecto as idCgTipoAspecto2, a.descripcion FROM cgTipoAspecto a  WHERE a.cg_idCgTipoAspecto is null AND a.delLog='N' AND a.idCgTipoAspecto IN(1,2)  AND a.idGenEstado=1",
                'soloLectura' => 'false',
                'onclick'     => 'onchange="cargaCmbAspectos(this.value)"',
            ),

            array(
                'tipo'          => 'comboDependiente',
                'etiqueta'      => 'Detalle Aspecto',
                'tabla'         => 'cgTipoAspecto',
                'campoTabla'    => 'idCgTipoAspecto1',
                'campoTablaDep' => 'idCgTipoAspecto2',
                'sqlDep'        => "SELECT a.idCgTipoAspecto as idCgTipoAspecto1, a.descripcion FROM cgTipoAspecto a  WHERE  a.delLog='N' AND a.idGenEstado=1 AND a.cg_idCgTipoAspecto=",
                'ancho'         => '313',
                'soloLectura'   => 'false',
                'onclick'       => 'onchange="cargaCmbDetalleAspectos(this.value)"'
            ),
            array(
                'tipo'          => 'comboDependiente',
                'etiqueta'      => 'Aspecto',
                'tabla'         => 'cgTipoAspecto',
                'campoTabla'    => 'idCgTipoAspecto',
                'campoTablaDep' => 'idCgTipoAspecto1',
                'sqlDep'        => "SELECT a.idCgTipoAspecto, a.descripcion FROM cgTipoAspecto a  WHERE  a.delLog='N' AND a.idGenEstado=1 AND a.cg_idCgTipoAspecto=",
                'ancho'         => '313',
                'soloLectura'   => 'false',
                'onclick'       => ''
            ),
            array(
                'tipo'        => 'comboSQL',
                'etiqueta'    => 'Motivo Registro',
                'tabla'       => 'cgTipoAspecto',
                'campoTabla'  => 'idCgTipoAspectoSancion',
                'ancho'       => '313',
                'sql'         => "SELECT a.idCgTipoAspecto as idCgTipoAspectoSancion, a.descripcion FROM cgTipoAspecto a  WHERE a.cg_idCgTipoAspecto=3 AND a.delLog='N'",
                'soloLectura' => 'false',
                'onclick'     => '',
            ),
            array(
                'tipo'        => 'textArea',
                'etiqueta'    => 'Observación:',
                'campoTabla'  => 'observacion',
                'ancho'       => '310',
                'alto'       => '100',
                'maxChar'     => '100',
                'mayusculas'  => 'N',
                'soloLectura' => 'false'
            ),
            array(
                'tipo'        => 'hidden',
                'etiqueta'    => 'idCgAmbitoGestionAppCg:',
                'campoTabla'  => 'idCgAmbitoGestionAppCg',
                'ancho'       => '310',
                'alto'       => '200',
                'maxChar'     => '600',
                'mayusculas'  => 'N',
                'soloLectura' => 'false'
            ),
            array(
                'tipo'        => 'hidden',
                'etiqueta'    => 'idDgpGrado:',
                'campoTabla'  => 'idDgpGrado',
                'ancho'       => '310',
                'alto'       => '200',
                'maxChar'     => '600',
                'mayusculas'  => 'N',
                'soloLectura' => 'false'
            ),
            array(
                'tipo'        => 'hidden',
                'etiqueta'    => 'fechaRegistro:',
                'campoTabla'  => 'fechaRegistro',
                'ancho'       => '310',
                'alto'       => '200',
                'maxChar'     => '600',
                'mayusculas'  => 'N',
                'soloLectura' => 'false'
            ),

            array(
                'tipo'        => 'hidden',
                'etiqueta'    => 'idGenPersonaJefe:',
                'campoTabla'  => 'idGenPersonaJefe',
                'ancho'       => '310',
                'alto'       => '200',
                'maxChar'     => '600',
                'mayusculas'  => 'N',
                'soloLectura' => 'false'
            ),
            array(
                'tipo'        => 'hidden',
                'etiqueta'    => 'idDgpGradoSanciona:',
                'campoTabla'  => 'idDgpGradoSanciona',
                'ancho'       => '310',
                'alto'       => '200',
                'maxChar'     => '600',
                'mayusculas'  => 'N',
                'soloLectura' => 'false'
            ),
            array(
                'tipo'         => 'file',
                'etiqueta'     => 'Imagen',
                'campoTabla'   => 'nombreImagen',
                'pathFile'     => '../../../descargas/comandoGeneral/appCg/',
                'fileSize'     => '5000000',
                'fileTypes'    => 'png,jpg,jpeg',
                'accept'       => 'image/png/jpeg',
                'nombreObjeto' => 'myfile',
                'obligatorio'  => 'N'
            ),

        );

        return $formulario;
    }

    public function getFormularioRegistroAspectoAppCg($datos, $idcampo, $opc)
    {
        echo $this->getFormulario(
            ($this->getCamposRegistroAspectoAppCg()),
            $datos,
            $idcampo,
            $opc,
            $btnNuevo = true,
            $btnGraba = true,
            $btnImprime = false
        );
    }
    public function getGrillaRegistroAspectoAppCg()
    {
        $gridS = array(
            'Id'      => 'idCgRegistroAspecto',
            'Sancionador'      => 'nombrePersonaJefe',
            'Sancionado'      => 'nombrePersona',
            'Tipo Aspecto'      => 'tipo',
            'Detalle'      => 'detalle',
            'Aspecto'      => 'aspecto',
            'Motivo'      => 'motivo',
            'Observación'      => 'observacion',

        );

        return $gridS;
    }
}
