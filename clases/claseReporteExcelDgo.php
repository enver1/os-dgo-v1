<?php

class ReporteExcelDgo
{
    public function getImprimeExcel($datos, $titulo, $fecha = '', $headers = array(), $column = array())
    {
        $ht = '<table id="my-tbl" width="100%" border="1">
        <tr><td colspan="' . count($column) . '"><span style="font-size:14px;font-weight:bold;color:#d61818">' . $titulo . '</span></td>
        <tr>';
        for ($i = 0; $i < count($headers); $i++) {
            $ht .= '<th class="data-th">' . $headers[$i] . '</th>';
        }
        $ht .= '</tr>';
        foreach ($datos as $key => $value) {

            $ht .= '<tr>';
            for ($j = 0; $j < count($column); $j++) {
                $datoF = $this->specialChars($value[$column[$j]]);
                if (is_numeric($datoF)) {
                    $ht .= '<td align="left" style="text-align:left;mso-number-format:\@;">' . $datoF . '</td>';
                } else {
                    $ht .= '<td  align="left">' . $datoF . '</td>';
                }
            }
            $ht .= '</tr>';
        }
        $ht .= '</table>';
        echo $ht;
    }

    public function specialChars($texto = '')
    {
        $p = array('/á/', '/é/', '/í/', '/ó/', '/ú/', '/Á/', '/É/', '/Í/', '/Ó/', '/Ú/', '/à/', '/è/', '/ì/', '/ò/', '/ù/', '/ñ/', '/Ñ/');
        $r = array('a', 'e', 'i', 'o', 'u', 'A', 'E', 'I', 'O', 'U', 'a', 'e', 'i', 'o', 'u', 'n', 'N');
        $x = preg_replace($p, $r, $texto);
        return $x;
    }
}
