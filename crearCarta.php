<?php
function crearCarta(){
    $lineCount = 0;

    $pdf = new Carta();
    $pdf->AddPage();
    $pdf->SetFont("font", "", 12);
    $pdf->Ln(65);
    $pdf->Cell(165, 10, $params['fechaAceptada'], 0, 0, "R");
    $pdf->Ln(35);
    foreach ($params["autores"] as &$nombre) {
        $pdf->Cell(200, 5, $nombre, 0, 1, "C");
        $lineCount += 1;
    }
    $pdf->Ln(46 - $lineCount);
    $pdf->MultiCell(0, 5, $params["titulo"], 0, 0, "C");
    $pdf->Ln(13- $lineCount);
    $pdf->Cell(240, 5, $status, 0, 0);

    $pdf->Output("D", $params["fechaSubmit"]+"_"+$params["titulo"], true);
 ?>
