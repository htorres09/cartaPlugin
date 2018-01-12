<?php
//Include configuration archive and class carta
//Require FPDF
include "configData.php";
include "carta.php";
//require_once($configGeneral["pathFPDF"]);
/* Importar FPDF*/
require('fpdf/fpdf.php');

function crearCarta($titulo, $autores, $fechaSubmit, $fechaAceptada, $status){
    $lineCount = 0;

    $pdf = new Carta();
    $pdf->AddPage();
    $pdf->SetFont($configGeneral["typeLetter"], "", $configGeneral["sizeLetter"]);
    $pdf->Ln(65);
    $pdf->Cell(165, 10, $fechaAceptada, 0, 0, "R");
    $pdf->Ln(35);
    foreach ($autores as &$nombre) {
        $pdf->Cell(200, 5, $nombre, 0, 1, "C");
        $lineCount += 1;
    }
    $pdf->Ln(46 - $lineCount);
    $pdf->MultiCell(0, 5, $titulo, 0, 0, "C");
    $pdf->Ln(13- $lineCount);
    $pdf->Cell(240, 5, $status, 0, 0);

    //Opcion D es para forzar a descarga directa f
    $pdf->Output("D", $fechaSubmit+"_"+$titulo, true);
}
?>
