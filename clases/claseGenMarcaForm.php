<?php
class GenMarcaForm extends Form
{


    public function getFormGenMarca($datos, $idcampo, $opc)
    {
        $this->getFormulario($this->getCampos(), $datos, $idcampo, $opc, 1, 1, 1, 1);
    }



    public function getCampos()
    {


        $formulario  = array(
            array(
                'tipo'        => 'hidden',
                'etiqueta'    => 'Xxxx',
                'campoTabla'  => 'idGenMarca',
                'ancho'       => '250',
                'maxChar'     => '300',
                'soloLectura' => 'false'
            ),
            array(
                'tipo'        => 'text',
                'etiqueta' => 'Descripción',
                'campoTabla' => 'descripcion',
                'ancho' => '300',
                'maxChar' => '50',
                'soloLectura' => 'false'
            ),



        );

        return $formulario;
    }
}