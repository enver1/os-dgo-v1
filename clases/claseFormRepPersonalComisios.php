<?php

class FormRepPersonalComisios extends Form
{

    public function getCamposRepPersonalComisios()
    {

        $formulario = array(

            array(
                'tipo'        => 'comboSQL',
                'etiqueta'    => '<span style="display:block" id="etProceso">Proceso:</span>',
                'tabla'       => 'dgoProcElec',
                'campoTabla'  => 'idDgoProcElec',
                'ancho'       => '300',
                'sql'         => "SELECT idDgoProcElec,descProcElecc descripcion FROM dgoProcElec WHERE delLog='N'",
                'soloLectura' => 'false',
                'onclick'     => ''
            ),

            array(
                'tipo'        => 'comboArreglo',
                'etiqueta'    => 'Tipo Personal:',
                'campoTabla'  => 'tipo',
                'arreglo'     => array('A' => 'ACTIVOS', 'I' => 'INACTIVOS', 'T' => 'TODOS',),
                'soloLectura' => 'false',
                'ancho'       => '300'
            ),
            array(
                'tipo'        => 'date',
                'etiqueta'    => 'Fecha Inicio',
                'campoTabla'  => 'fechaini',
                'ancho'       => '270',
                'maxChar'     => '',
                'ayuda'       => '',
                'onclick'     => 'onchange=""',
                'soloLectura' => 'true'
            ),
            array(
                'tipo'        => 'date',
                'etiqueta'    => 'Fecha Fin',
                'campoTabla'  => 'fechafin',
                'ancho'       => '270',
                'maxChar'     => '',
                'ayuda'       => '',
                'onclick'     => 'onchange=""',
                'soloLectura' => 'true'
            ),


        );
        return $formulario;
    }

    public function getFormularioRepPersonalComisios($datos, $idcampo, $opc)
    {
        echo $this->getFormulario(
            ($this->getCamposRepPersonalComisios()),
            $datos,
            $idcampo,
            $opc,
            $btnNuevo = false,
            $btnGraba = false,
            $btnImprime = false,
            $campo = true
        );
    }

    public function getGrillaRepPersonalComisios()
    {
        $gridS = array(
            'Id. Nov'                 => 'idDgoNovReciElec',
            'Id Operativo'            => 'idDgoCreaOpReci',
            'Nombre Recinto / Unidad' => 'nomRecintoElec',
            'Persona Reporta'         => 'jefe_operativo',
            'Tipo Novedad'            => 'Tipo',
            'Novedad'                 => 'Novedad',
        );
        return $gridS;
    }
}
