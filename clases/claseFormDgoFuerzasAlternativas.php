<?php

class FormDgoFuerzasAlternativas extends Form
{

    public function getCamposDgoFuerzasAlternativas()
    {
        $formulario = array(

            array(
                'tipo'        => 'comboSQL',
                'etiqueta'    => 'Agregaciones:',
                'tabla'       => 'dgoTipoFuerzasAlternativas',
                'campoTabla'  => 'idDgoTipoFuerzasAlternativas',
                'ancho'       => '260',
                'sql'         => "SELECT a.idDgoTipoFuerzasAlternativas,a.descripcion FROM  dgoTipoFuerzasAlternativas a WHERE a.idGenEstado=1 AND a.delLog='N'",
                'soloLectura' => 'false',
                'onclick'     => ''
            ),
            array(
                'tipo'        => 'text',
                'etiqueta'    => 'Numerico Jefes:',
                'campoTabla'  => 'numericoJefes',
                'ancho'       => '250',
                'maxChar'     => '4',
                'mayusculas'  => 'S',
                'soloLectura' => 'false',
            ),
            array(
                'tipo'        => 'text',
                'etiqueta'    => 'Numerico Subalternos:',
                'campoTabla'  => 'numericoSubalternos',
                'ancho'       => '250',
                'maxChar'     => '4',
                'mayusculas'  => 'S',
                'soloLectura' => 'false',
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

    public function getFormularioDgoFuerzasAlternativas($datos, $idcampo, $opc)
    {
        echo $this->getFormulario(
            ($this->getCamposDgoFuerzasAlternativas()),
            $datos,
            $idcampo,
            $opc,
            $btnNuevo = true,
            $btnGraba = true,
            $btnImprime = false
        );
    }
    public function getGrillaDgoFuerzasAlternativas()
    {
        $gridS = array(
            'Código'      => 'idDgoFuerzasAlternativas',
            'Fuerza Alternativa' => 'descripcion',
            'Numerico Jefes' => 'numericoJefes',
            'Numerico Subalternos' => 'numericoSubalternos',
        );

        return $gridS;
    }
}
