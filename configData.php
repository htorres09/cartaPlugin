<?php
/** ARCHIVO DE CONFIGURACION
 * configGenerl -> General configurations of the plugin
 * image -> Images dictionary path
 * decission -> Editorial decission about a Submission <<status>>
 */

$configGeneral = array(
    "pathFPDF" => "fpdf.php",
    "typeLetter" => "Arial",
    "sizeLetter" => "12"
);

$image = array(
    "Header" => "imagenes/CartaAceptacion.png",
    "Firm" => "FirmaAceptacion.png",
    "institutionLogo" => "logoUanl.png",
    "otherLogo" => "conference.png",
);

$decission => array(
    1 => "<<Aceptada>>";
    2 => "considerada <<Publicable con modificaciones>>";
    3 => "considerada <<Reevlauable>>";
    4 => "considerada >>";
);

?>
