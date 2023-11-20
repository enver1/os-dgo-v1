<?php
class GenModeloForm extends Form
{


    public function getFormGenModelo($datos, $idcampo, $opc)
    {
        $this->getFormulario($this->getCampos(), $datos, $idcampo, $opc, 1, 1, 1, 1);
    }



    public function getCampos()
    {


        $formulario  = array(
            array(
                'tipo'        => 'hidden',
                'etiqueta'    => 'Xxxx',
                'campoTabla'  => 'idGenModelo',
                'ancho'       => '250',
                'maxChar'     => '300',
                'soloLectura' => 'false'
            ),

            array(
                'tipo'        => 'comboSQL',
                'etiqueta' => 'Marca',
                'tabla'       => 'genMarca',
                'campoTabla' => 'idGenMarca',
                'campoValor' => 'descripcion',
                'sql'         => "SELECT idGenMarca, descripcion FROM genMarca order by 1",
                'onclick'     => '',
                'soloLectura' => 'false',
                'ancho'       => '300'
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