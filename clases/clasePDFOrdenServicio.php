<?php
require('../../../claseFPDF.php');
class PDFOrdenServicio extends FPDF
{
    function Header()
    {

        $this->Image('logo.png', 10, 8, 33);

        $this->SetFont('Arial', 'B', 12);

        $this->Cell(30, 10, 'Title', 1, 0, 'C');
    }
}
