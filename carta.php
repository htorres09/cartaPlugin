<?php
//Include configuration archive and class carta
//Require FPDF
include "configData.php";
//require_once($configGeneral["pathFPDF"]);
/* Importar FPDF*/
require('fpdf/fpdf.php');

class carta extends FPDF{
    // PDF Header
    function Header(){
        $this->Image($image["Header"], 0, 0, 200, 300, "PNG");
    }

    // PDF Footer
    function Footer(){
        $this->SetY(-30);
        $this->Image($image["Firm"], NULL, NULL, 60, 0, "PNG");
    }
}
?>
