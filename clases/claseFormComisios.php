<?php

class FormComisios extends Form
{

    public function getCamposComisios()
    {

        $formulario = array(
            array(
                'tipo'        => 'comboSQL',
                'etiqueta'    => '<span style="display:block" id="etProceso">Proceso:</span>',

                'tabla'       => 'dgoProcElec',
                'campoTabla'  => 'idDgoProcElec',
                'ancho'       => '260',
                'sql'         => "SELECT idDgoProcElec,descProcElecc descripcion FROM dgoProcElec WHERE delLog='N' AND idGenEstado=1",
                'soloLectura' => 'false',
                'onclick'     => ''),

            array(
                'tipo'        => 'text',
                'etiqueta'    => '<span style="display:block" id="etNumero">Número de Electores:</span>',
                'campoTabla'  => 'numElectores',
                'ancho'       => '250',
                'alto'        => '50',
                'maxChar'     => '',
                'mayusculas'  => 'S',
                'soloLectura' => 'false'),
            array(
                'tipo'        => 'text',
                'etiqueta'    => '<span style="display:block" id="etJuntasH">Número de Juntas Hombres:</span>',
                'campoTabla'  => 'numJuntMascu',
                'ancho'       => '250',
                'alto'        => '50',
                'maxChar'     => '',
                'mayusculas'  => 'S',
                'soloLectura' => 'false'),

            array(
                'tipo'        => 'text',
                'etiqueta'    => '<span style="display:block" id="etJuntasM">Número de Juntas Mujeres:</span>',
                'campoTabla'  => 'numJuntFeme',
                'ancho'       => '250',
                'alto'        => '50',
                'maxChar'     => '',
                'mayusculas'  => 'S',
                'soloLectura' => 'false'),

            array(
                'tipo'        => 'hidden',
                'etiqueta'    => 'idRecinto',
                'campoTabla'  => 'idDgoReciElect',
                'ancho'       => '250',
                'alto'        => '50',
                'maxChar'     => '',
                'mayusculas'  => 'S',
                'soloLectura' => 'false'),

        );
        return $formulario;

    }

    public function getFormularioComisios($datos, $idcampo, $opc)
    {
        echo $this->getFormulario(
            ($this->getCamposComisios()),
            $datos,
            $idcampo,
            $opc,
            $btnNuevo = true,
            $btnGraba = true,
            $btnImprime = false);
    }

    public function getGrillaComisios()
    {
        $gridS = array(
            'ID'                => 'idDgoComisios',
            'Proceso Electoral' => 'descProcElecc',
            'Código'            => 'codRecintoElec',
            'Nombre'            => 'nomRecintoElec',
            'Total Electores'   => 'numElectores',
            'Juntas Masculinas' => 'numJuntMascu',
            'Juntas Femeninas'  => 'numJuntFeme',
        );
        return $gridS;
    }
    public function getCamposComisiosProceso()
    {

        $formulario = array(

            array(
                'tipo'        => 'hidden',
                'etiqueta'    => 'idDgoProcElec',
                'campoTabla'  => 'idDgoProcElec',
                'ancho'       => '250',
                'alto'        => '50',
                'maxChar'     => '',
                'mayusculas'  => 'S',
                'soloLectura' => 'false'),

        );
        return $formulario;

    }

    public function getFormularioComisiosProceso($datos, $idcampo, $opc)
    {
        echo $this->getFormulario(
            ($this->getCamposComisiosProceso()),
            $datos,
            $idcampo,
            $opc,
            $btnNuevo = false,
            $btnGraba = false,
            $btnImprime = false,
            $codigo = true);
    }

}
