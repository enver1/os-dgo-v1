<?php
class FormDiscriminacion extends Form
{
    public function getFormulario($campos, $datos, $idcampo, $opc, $btnNuevo = true, $btnGraba = true, $btnImprime = true, $codigoOculto = false)
    {
        if (isset($datos['idHdrEvento'])) {
            $btnGraba = false;
        }
        echo '<form name="edita" id="edita" method="post">';
        echo '<table width="100%" border="0">
                <tr>
                    <td class="etiqueta" width="25%">Nro. Operativo</td>
                    <td width="25%"><input type="text" name="codigoEvento" id="codigoEvento" value="' . (isset($datos['idHdrEvento']) ? $datos['idHdrEvento'] : '') . '" class="inputSombra" style="width: 150px"></td>
                    <td class="etiqueta" width="25%">Nro. Cédula</td>
                    <td width="25%"><input type="text" name="documento" id="documento" value="' . (isset($datos['documento']) ? $datos['documento'] : '') . '" class="inputSombra" style="width: 150px"></td>
                    <td width="25%"><input type="button" name="nuevo" onclick="buscarRegistro()" value="Buscar" class="boton_busqueda"></td>
                </tr>
            </table><hr>';
        echo '<table width="100%" border="0"><tr>';
        if ($codigoOculto) {
            echo '<td><input type="hidden" id="' . $idcampo . '" name="' . $idcampo . '" readonly="readonly" ';
            echo 'value="' . (isset($datos[$idcampo]) ? $datos[$idcampo] : '') . '" ';
            echo 'class="inputSombra" style="width:150px" />';
        } else {
            echo '<td class="etiqueta">C&oacute;digo:</td>';
            echo '<td><input type="text" id="' . $idcampo . '" name="' . $idcampo . '" readonly="readonly" ';
            echo 'value="' . (isset($datos[$idcampo]) ? $datos[$idcampo] : '') . '" ';
            echo 'class="inputSombra" style="width:150px" />';
        }
        echo '<input type="hidden" name="fechaHoy"  id="fechaHoy" value="" /></td></tr>';
        $this->campoFormulario($campos, $datos);
        echo '<tr><td colspan="2" ><hr /><input type="hidden" name="opc" value="' . $opc . '" />';
        echo '</td></tr></table>';
        $swf = false;
        foreach ($campos as $campo) {
            if ($campo['tipo'] == 'file') {
                $swf = true;
            }
        }
        if ($swf) {
            //            idCampo nuevo graba impri file    ***false si no quiere mostrar el boton
            $this->Botonera($idcampo, $btnNuevo, $btnGraba, $btnImprime, true);
        } else {
            $this->Botonera($idcampo, $btnNuevo, $btnGraba, $btnImprime, false);
        }
        echo '</form>';
    }

    public function getEstructuraFormulario()
    {
        $formulario = array(
            array(
                'tipo'        => 'text',
                'etiqueta'    => 'Fecha y Hora Operativo:',
                'campoTabla'  => 'fechaEvento',
                'ancho'       => '150',
                'maxChar'     => '150',
                'mayusculas'  => '',
                'soloLectura' => 'true'
            ),

            array(
                'tipo'        => 'text',
                'etiqueta'    => 'Tipo Operativo<span class="texto_red">*</span>:',
                'campoTabla'  => 'descTipoTipificacion',
                'ancho'       => '250',
                'maxChar'     => '150',
                'mayusculas'  => '',
                'soloLectura' => 'true'
            ),

            array(
                'tipo'        => 'text',
                'etiqueta'    => 'Policía Que Realizo Operativo<span class="texto_red">*</span>:',
                'campoTabla'  => 'policia',
                'ancho'       => '300',
                'maxChar'     => '250',
                'mayusculas'  => '',
                'soloLectura' => 'true'
            ),

            array(
                'tipo'        => 'hidden',
                'etiqueta'    => 'idHdrEventoResum<span class="texto_red">*</span>:',
                'campoTabla'  => 'idHdrEventoResum',
                'ancho'       => '150',
                'maxChar'     => '150',
                'mayusculas'  => '',
                'soloLectura' => 'true'
            ),

            array(
                'tipo'        => 'text',
                'etiqueta'    => 'Persona Sancionada<span class="texto_red">*</span>:',
                'campoTabla'  => 'apenom',
                'ancho'       => '300',
                'maxChar'     => '250',
                'mayusculas'  => '',
                'soloLectura' => 'true'
            ),

            array(
                'tipo'        => 'hidden',
                'etiqueta'    => 'Tipo Sancion:',
                'campoTabla'  => 'idHdrTipoResum',
                'ancho'       => '150',
                'maxChar'     => '150',
                'mayusculas'  => '',
                'soloLectura' => 'true'
            ),

            array(
                'tipo'        => 'text',
                'etiqueta'    => 'Tipo Sanción<span class="texto_red">*</span>:',
                'campoTabla'  => 'desHdrTipoResum',
                'ancho'       => '250',
                'maxChar'     => '150',
                'mayusculas'  => '',
                'soloLectura' => 'true'
            ),

            array(
                'tipo'        => 'comboArreglo',
                'etiqueta'    => 'Sanción Por:<span class="texto_red">*</span>:',
                'campoTabla'  => 'causa',
                'arreglo'     => array(1 => 'TOQUE DE QUEDA', 2 => 'RESTRICCIÓN VEHÍCULAR', 3 => 'MAL USO DEL SALVOCONDUCTO'),
                'soloLectura' => 'false',
                'ancho'       => '250'
            ),

            array(
                'tipo'        => 'text',
                'etiqueta'    => 'Nro. Parte Web<span class="texto_red">*</span>:',
                'campoTabla'  => 'nroParteWeb',
                'ancho'       => '150',
                'maxChar'     => '150',
                'mayusculas'  => '',
                'soloLectura' => 'false'
            ),

            array(
                'tipo'                => 'persona',
                'etiqueta'            => 'Persona Que Realiza El Parte<span class="texto_red">*</span>:',
                'campoTabla'          => 'idGenPersona',
                'campoCedula'         => 'cedula',
                'campoNombre'         => 'nombrePersona',
                'ancho'               => '80',
                'maxChar'             => '10',
                'onclick'             => 'buscaPersona()',
                'botonBuscar'         => 'S',
                'botonOculto'         => 'true',
                'buscaxNombres'       => 'S',
                'soloLectura'         => 'false',
                'buscarTipoDocumento' => 'N',
                'esPolicia'           => 1,
                'limpiar'             => 'limpiarR()',
            ),

            array(
                'tipo'        => 'textArea',
                'etiqueta'    => 'Justificación<span class="texto_red">*</span>:',
                'campoTabla'  => 'justificacion',
                'maxChar'     => '2000',
                'ancho'       => '300',
                'alto'        => '100',
                'mayusculas'  => 'S',
                'soloLectura' => 'false'
            ),

            array(
                'tipo'         => 'file',
                'etiqueta'     => 'Parte Web PDF (Tamaño 5MB)*:',
                'campoTabla'   => 'pathPdf',
                'pathFile'     => '../../../descargas/operaciones/discriminarrosm/',
                'fileSize'     => '5242880',
                'fileTypes'    => 'pdf',
                'accept'       => 'application/pdf',
                'obligatorio'  => 'S',
                'nombreObjeto' => 'myfile'
            ),

            array(
                'tipo'        => 'hidden',
                'etiqueta'    => 'idGenUsuario<span class="texto_red">*</span>:',
                'campoTabla'  => 'idGenUsuario',
                'ancho'       => '150',
                'maxChar'     => '150',
                'mayusculas'  => '',
                'soloLectura' => 'true'
            ),

            array(
                'tipo'        => 'text',
                'etiqueta'    => 'Usuario Que Registra El Error<span class="texto_red">*</span>:',
                'campoTabla'  => 'usuario',
                'ancho'       => '250',
                'maxChar'     => '150',
                'mayusculas'  => '',
                'soloLectura' => 'true'
            ),

            array(
                'tipo'        => 'text',
                'etiqueta'    => 'Fecha y Hora Registro<span class="texto_red">*</span>:',
                'campoTabla'  => 'fechaRegistro',
                'ancho'       => '150',
                'maxChar'     => '150',
                'mayusculas'  => '',
                'soloLectura' => 'true'
            ),

        );
        return $formulario;
    }
    public function getGrilla()
    {
        $gridS = array(
            'Nro. Operativo'                             => 'cero',
            'Fecha Operativo'                            => 'uno',
            'Tipo Operativo'                             => 'dos',
            'Servidor Policial Que Solicita El Registro' => 'cuatro',
            'Cedula Persona Sancionada'                  => 'seis',
            'Nombre Persona Sancionada'                  => 'siete',
            'Usuario Que Registra Error De Sancion'      => 'nueve',
        );
        return $gridS;
    }

    public function getForma($datos, $idCampo, $opc)
    {
        $this->getFormulario($this->getEstructuraFormulario(), $datos, $idCampo, $opc, true, true, true, true);
    }
}
