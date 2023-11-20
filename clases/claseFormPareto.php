<?php

/**
 *
 */
class FormPareto
{
    private $meses = array('Todos', 'ENE', 'FEB', 'MAR', 'ABR', 'MAY', 'JUN', 'JUL', 'AGO', 'SEP', 'OCT', 'NOV', 'DIC');
    private $anios = array();

    public function __construct()
    {
        $this->anios = $this->getAnios();
    }

    public function getAnios()
    {
        $anios      = array();
        $anioActual = date('Y');

        for ($i = $anioActual; $i >= 2014; $i = $i - 1) {
            $anios[] = $i;
        }

        return $anios;
    }

    public function getBotones()
    {
        $html = '<table width="100%" border="0" cellspacing="4" cellpadding="3">';
        $html .= '</tr>';
        foreach ($this->anios as $key => $value) {
            $html .= '<td class="barMes" id="c' . $value . '"><a href="javascript:void(0)" onclick="selectAnio(\'' . $value . '\')" class="barra">' . $value . '</a></td>';
        }
        $html .= '</tr>';
        $html .= '</tr>';
        foreach ($this->meses as $key => $value) {
            $html .= '<td class="barMes" id="b' . $key . '"><a href="javascript:void(0)" onclick="selectMes(\'' . $key . '\')" class="barra">' . $value . '</a></td>';
        }
        $html .= '</tr>';
        $html .= '</table>';

        return $html;
    }

   
}
