<?php

class FormNovedadesEje extends Form
{

    public function getGrillaNovedadesEje()
    {
        $gridS = array(
            'ID'                  => 'idDgoNovedadesEje',
            'Tipo Eje'            => 'tipoEje',
            'Descripción Novedad' => 'descripcion',
            'Estado'              => 'estado',

        );
        return $gridS;
    }
    public function getCamposNovedadesEje()
    {

        $formulario = array(
            array(
                'tipo'        => 'comboSQL',
                'etiqueta'    => 'Eje',
                'tabla'       => 'dgoTipoEje',
                'campoTabla'  => 'idDgoTipoEje1',
                'ancho'       => '313',
                'sql'         => "SELECT a.idDgoTipoEje as idDgoTipoEje1, a.descripcion FROM dgoTipoEje a  WHERE a.dgo_idDgoTipoEje is null AND a.delLog='N'",
                'soloLectura' => 'false',
                'onclick'     => 'onchange="cargaCmbEje(this.value)"'
            ),

            array(
                'tipo'          => 'comboDependiente',
                'etiqueta'      => '<span style="display:block" id="etTipoEje">Tipo Eje:</span>',
                'tabla'         => 'dgoTipoEje',
                'campoTabla'    => 'idDgoTipoEje2',
                'campoTablaDep' => 'idDgoTipoEje1',
                'sqlDep'        => "SELECT a.idDgoTipoEje as idDgoTipoEje2, a.descripcion FROM dgoTipoEje a  WHERE a.dgo_idDgoTipoEje=",
                'ancho'         => '313',
                'soloLectura'   => 'false',
                'onclick'       => 'onchange="cargaCmbEje1(this.value)"'
            ),

            array(
                'tipo'          => 'comboDependiente',
                'etiqueta'      => '<span style="display:block" id="etUnidad">Unidad:</span>',
                'tabla'         => 'dgoTipoEje',
                'campoTabla'    => 'idDgoTipoEje',
                'campoTablaDep' => 'idDgoTipoEje2',
                'sqlDep'        => "SELECT a.idDgoTipoEje, a.descripcion FROM dgoTipoEje a  WHERE a.delLog='N' AND a.dgo_idDgoTipoEje=",
                'ancho'         => '313',
                'soloLectura'   => 'false',
                'onclick'       => ''
            ),

            array(
                'tipo'        => 'hidden',
                'etiqueta'    => 'idDgoNovedadesElect',
                'campoTabla'  => 'idDgoNovedadesElect',
                'ancho'       => '250',
                'alto'        => '50',
                'maxChar'     => '',
                'mayusculas'  => 'S',
                'soloLectura' => 'false'
            ),

            array(
                'tipo'        => 'hidden',
                'etiqueta'    => 'auxiliar',
                'campoTabla'  => 'auxiliar',
                'ancho'       => '250',
                'alto'        => '50',
                'maxChar'     => '',
                'mayusculas'  => 'S',
                'soloLectura' => 'false'
            ),
            array(
                'tipo'        => 'text',
                'etiqueta'      => '<span style="display:block" id="etDescripcion">descripcion:</span>',
                'campoTabla'  => 'descripcion',
                'ancho'       => '250',
                'alto'        => '50',
                'maxChar'     => '',
                'mayusculas'  => 'S',
                'soloLectura' => 'true'
            ),
            array(
                'tipo'        => 'comboSQL',
                'etiqueta'      => '<span style="display:block" id="etEstado">estado:</span>',
                'tabla'       => 'genEstado',
                'campoTabla'  => 'idGenEstado',
                'ancho'       => '235',
                'sql'         => "SELECT idGenEstado, descripcion FROM genEstado",
                'soloLectura' => 'false',
                'onclick'     => ''
            ),

        );
        return $formulario;
    }

    public function getFormularioNovedadesEje($datos, $idcampo, $opc)
    {
        echo $this->getFormulario(
            ($this->getCamposNovedadesEje()),
            $datos,
            $idcampo,
            $opc,
            $btnNuevo = false,
            $btnGraba = false,
            $btnImprime = false,
            $codigo = true
        );
    }
}
