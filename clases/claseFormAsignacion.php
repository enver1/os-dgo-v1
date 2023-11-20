<?php
class FormAsignacion extends FormAsignacionArbol
{
    public function getCamposFormAsignacion()
    {
        $arrayMeses = array(
            '1' => 'Enero',
            '2' => 'Febrero',
            '3' => 'Marzo',
            '4' => 'Abril',
            '5' => 'Mayo',
            '6' => 'Junio',
            '7' => 'Julio',
            '8' => 'Agosto',
            '9' => 'Septiembre',
            '10' => 'Octubre',
            '11' => 'Noviembre',
            '12' => 'Diciembre',
            '13' => 'Todos',
        );
        $formulario = array(
            array(
                'tipo'        => 'text',
                'etiqueta'    => 'Año:',
                'campoTabla'  => 'anio',
                'soloLectura' => 'false',
                'onclick'     => '',
                'ancho'       => '220'
            ),
            array(
                'tipo'        => 'arbol',
                'etiqueta'    => 'Distribución Senplades',
                'campoTabla'  => 'idGenGeoSenplades',
                'campoValor'  => 'senpladesDescripcion',
                'ancho'       => '400',
                'pais'        => 'N',
                'niveles'     => '3',
                'tabla'       => 'genGeoSenplades',
                'descripcion' => 'senpladesDescripcion'
            ),
            array(
                'tipo' => 'checkArreglo',
                'etiqueta' => 'Meses:',
                'campoTabla' => 'meses',
                'columnas' => '6',
                'valores' => $arrayMeses
            ),

            array(
                'tipo'         => 'file',
                'etiqueta'     => '(*)Documento (Max 1000 Kbytes)',
                'campoTabla'   => 'icono',
                'pathFile'     => '../../../descargas/operaciones/appDgscop/imagenes/',
                'fileSize'     => '100000000',
                'fileTypes'    => 'pdf',
                'accept'       => 'pdf',
                'obligatorio'  => 'N',
                'nombreObjeto' => 'imgAlb'
            ),

            array(
                'tipo'        => 'hidden',
                'etiqueta'    => 'usuario:',
                'campoTabla'  => 'usuario',
                'soloLectura' => 'false',
                'onclick'     => '',
                'ancho'       => '350'
            ),
            array(
                'tipo'        => 'hidden',
                'etiqueta'    => 'persona:',
                'campoTabla'  => 'persona',
                'soloLectura' => 'false',
                'onclick'     => '',
                'ancho'       => '350'
            ),
            array(
                'tipo' => 'hidden',
                'etiqueta' => 'senplades',
                'campoTabla' => 'senplades',
                'ancho' => '300',
                'maxChar' => '',
                'align' => 'left',
                'soloLectura' => 'false'
            ),
        );

        return $formulario;
    }

    public function getGrillaFormAsignacion()
    {
        $gridS = array(
            'Código' => 'idDgoAsignacion',
            'Cursante' => 'cursante',
            'Unidad' => 'descripcion',
            'Nomenclatura' => 'siglasGeoSenplades',
            'Meses' => 'mes',
        );
        return $gridS;
    }

    public function getFormularioFormAsignacion($datos, $idcampo, $opc)
    {
        echo $this->getFormulario(
            ($this->getCamposFormAsignacion()),
            $datos,
            $idcampo,
            $opc,
            $btnNuevo = true,
            $btnGraba = true,
            $btnImprime = false,
        );
    }
}
