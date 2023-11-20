<?php
class GridDgoAlertaSenderoSeguro
{
    public $idcampo = 'id';
    public $get     = 'getregistro';
    public $del     = 'delregistro';
    public $fSize   = '12px';

    public function showGridS($gridS, $rs, $Editar = true, $Eliminar = true, $Ver = true)
    {
        $html      = '<table id="my-tbl" style="font-size:' . $this->fSize . '"><tr>';

        foreach ($gridS as $campos => $valor) {
            $html .= '<th class="data-th">' . $campos . '</th>';
        }
        if ($Ver) {
            $html .= '<th class="data-th" width="7%">Imagen</th>';
        }
        if ($Editar) {
            $html .= '<th class="data-th" width="7%">Editar</th>';
        }
        if ($Eliminar) {
            $html .= '<th class="data-th" width="7%">Eliminar</th>';
        }

        $html .= '</tr>';
        //loop por cada registro tomando los campos delarreglo $gridS
        while ($row = $rs->fetch(PDO::FETCH_ASSOC)) {
            $html .= '<tr class="data-tr" align="center">';

            foreach ($gridS as $campos => $valor) {
                $html .= '<td>' . $row[$valor] . '</td>';
            }

            if ($Ver) {
                if (isset($_SESSION['privilegios']) and substr($_SESSION['privilegios'], 1, 1) == 1) {

                    $html .= '<td style="text-align:center"><a href="modulos/configDelitos/verimagen.php?idDaiDelito=' . $row[$this->idcampo] . '"onclick="return GB_showPage(\'Imagen Representativa del Tipo de Delito\', this.href)" target="_blank"class="btn btn-danger pull-right"><span class="glyphicon glyphicon-file"</span>Ver</a></td>';
                }
            }

            if ($Editar) {
                if (isset($_SESSION['privilegios']) and substr($_SESSION['privilegios'], 2, 1) == 1) {

                    $html .= '<td style="text-align:center"><a href="javascript:void(0);" onclick="' . $this->get . '(' . $row[$this->idcampo] . ')">Editar</a></td>';
                } else {
                    $html .= '<td>&nbsp;</td>';
                }

                // $html .= '<td style="text-align:center"><a href="javascript:void(0);" onclick="' . $this->get . '(\'' . $encriptar->getEncriptar(strip_tags($row[$this->idcampo]), $_SESSION['usuarioAuditar']) . '\' )">Editar</a></td>';} else { $html .= '<td>&nbsp;</td>';}
            }

            if ($Eliminar) {
                if (isset($_SESSION['privilegios']) and substr($_SESSION['privilegios'], 3, 1) == 1) {
                    $html .= '<td style="text-align:center"><a href="javascript:void(0);" onclick="return ' . $this->del . '(' . $row[$this->idcampo] . ')">Eliminar</a></td>';
                } else {
                    $html .= '<td>&nbsp;</td>';
                }
                //   $html .= '<td style="text-align:center"><a href="javascript:void(0);" onclick="return ' . $this->del . '(\'' . $encriptar->getEncriptar(strip_tags($row[$this->idcampo]), $_SESSION['usuarioAuditar']) . '\' )">Eliminar</a></td>';} else { $html .= '<td>&nbsp;</td>';}
            }

            $html .= '</tr>';
        }
        $html .= '</table><br />';
        return $html;
    }
    public function showGridTareas($gridS, $rs, $Editar = true, $Eliminar = true)
    {
        $html      = '<table id="my-tbl" style="font-size:' . $this->fSize . '"><tr>';

        foreach ($gridS as $campos => $valor) {
            $html .= '<th class="data-th">' . $campos . '</th>';
        }


        if ($Editar) {
            $html .= '<th class="data-th" width="7%">Editar</th>';
        }
        if ($Eliminar) {
            $html .= '<th class="data-th" width="7%">Eliminar</th>';
        }

        $html .= '</tr>';
        //loop por cada registro tomando los campos delarreglo $gridS
        while ($row = $rs->fetch(PDO::FETCH_ASSOC)) {
            $html .= '<tr class="data-tr" align="center">';

            foreach ($gridS as $campos => $valor) {
                $html .= '<td>' . $row[$valor] . '</td>';
            }


            if ($Editar) {
                if (isset($_SESSION['privilegios']) and substr($_SESSION['privilegios'], 2, 1) == 1) {

                    $html .= '<td style="text-align:center"><a href="javascript:void(0);" onclick="' . $this->get . '(' . $row[$this->idcampo] . ')">Editar</a></td>';
                } else {
                    $html .= '<td>&nbsp;</td>';
                }

                // $html .= '<td style="text-align:center"><a href="javascript:void(0);" onclick="' . $this->get . '(\'' . $encriptar->getEncriptar(strip_tags($row[$this->idcampo]), $_SESSION['usuarioAuditar']) . '\' )">Editar</a></td>';} else { $html .= '<td>&nbsp;</td>';}
            }

            if ($Eliminar) {
                if (isset($_SESSION['privilegios']) and substr($_SESSION['privilegios'], 3, 1) == 1) {
                    $html .= '<td style="text-align:center"><a href="javascript:void(0);" onclick="return ' . $this->del . '(' . $row[$this->idcampo] . ')">Eliminar</a></td>';
                } else {
                    $html .= '<td>&nbsp;</td>';
                }
                //   $html .= '<td style="text-align:center"><a href="javascript:void(0);" onclick="return ' . $this->del . '(\'' . $encriptar->getEncriptar(strip_tags($row[$this->idcampo]), $_SESSION['usuarioAuditar']) . '\' )">Eliminar</a></td>';} else { $html .= '<td>&nbsp;</td>';}
            }

            $html .= '</tr>';
        }
        $html .= '</table><br />';
        return $html;
    }
    public function showGridSe($gridS, $rs, $Editar = true, $Eliminar = true)
    {
        $html      = '<table id="my-tbl" style="font-size:' . $this->fSize . '"><tr>';

        foreach ($gridS as $campos => $valor) {
            $html .= '<th class="data-th">' . $campos . '</th>';
        }
        if ($Eliminar) {
            $html .= '<th class="data-th" width="7%">Eliminar</th>';
        }

        $html .= '</tr>';
        //loop por cada registro tomando los campos delarreglo $gridS
        while ($row = $rs->fetch(PDO::FETCH_ASSOC)) {
            $html .= '<tr class="data-tr" align="center">';

            foreach ($gridS as $campos => $valor) {
                $html .= '<td>' . $row[$valor] . '</td>';
            }

            if ($Eliminar) {
                if (isset($_SESSION['privilegios']) and substr($_SESSION['privilegios'], 3, 1) == 1) {
                    $html .= '<td style="text-align:center"><a href="javascript:void(0);" onclick="return ' . $this->del . '(' . $row[$this->idcampo] . ')">Eliminar</a></td>';
                } else {
                    $html .= '<td>&nbsp;</td>';
                }
                //  $html .= '<td style="text-align:center"><a href="javascript:void(0);" onclick="return ' . $this->del . '(\'' . $encriptar->getEncriptar(strip_tags($row[$this->idcampo]), $_SESSION['usuarioAuditar']) . '\' )">Eliminar</a></td>';} else { $html .= '<td>&nbsp;</td>';}
            }

            $html .= '</tr>';
        }
        $html .= '</table><br />';
        return $html;
    }
}