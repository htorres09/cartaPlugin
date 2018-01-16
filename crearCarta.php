<?php
//Include configuration archive and class carta
/* Importar FPDF*/
require('fpdf/fpdf.php');

/* class carta*/
class Carta extends FPDF{
    // PDF Header
    function Header(){
        $this->Image("CartaAceptacion.png", 0, 0, 200, 300, "PNG");
    }

    // PDF Footer
    function Footer(){
        $this->SetY(-50);
        $this->SetX(75);
        $this->Image("FirmaAceptacion.png", NULL, NULL, 60, 0, "PNG");
    }
}

/* function crearcarta */
function crearCarta($data){
    $lineCount = 0;
    $params = json_decode($data, true);
    $titulo = $params['titulo'];
    switch($params['status']){
        case 1:
            $status = "<<aceptada>>";
            break;
        case 2:
            $status = "<<publicable con modificacions>>";
            break;
        case 3:
            $status = "<<reevaluable>>";
            break;
        default:
            $status = "<<Declinada>>";
            break;
    }

    $pdf = new Carta();
    $pdf->AddPage();
    $pdf->SetFont("Arial", "", 12);
    $pdf->Ln(65);
    $pdf->Cell(165, 10, $params['fechaAceptada'], 0, 0, "R");
    $pdf->Ln(35);
    foreach ($params['autores'] as &$nombre) {
        $pdf->Cell(200, 5, $nombre, 0, 1, "C");
        $lineCount += 1;
    }
    $pdf->Ln(43 - $lineCount);
    $pdf->Cell(200, 5, $titulo, 0, 1, "C");
    $pdf->Ln(10- $lineCount);
    $pdf->Cell(240, 5, $status, 0, 0);

    //Option I direct to browser
    //Opcion D direct download
    //Option F save file in local
    //Option S send document as string chain
    $pdf->Output("I", $fechaSubmit+"_"+$titulo, true);
}

/* MAIN*/
switch($_SERVER["REQUEST_METHOD"]){
    case 'GET':
        $data = base64_decode( $_GET['data'] );
        break;
    case 'POST':
        $data = base64_decode( $_POST['data'] );
        break;
}
crearCarta($data);

?>
