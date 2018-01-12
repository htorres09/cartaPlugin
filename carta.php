<?php
include "configData.php";
require_once($configGeneral["pathFPDF"]);

class carta extends FPDF{
    function Header(){
        $this->Image($image["Header"], 0, 0, 200, 300, "PNG");
    }

    function Footer(){
        $this->SetY(-30);
        $this->Image($image["Firm"], NULL, NULL, 60, 0, "PNG");
    }
}
?>
