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

$imagenes = array(
    "Header" => "CartaAceptacion.png",
    "Firm" => "FirmaAceptacion.png",
    "institutionLogo" => "uanl-logo.png",
    "otherLogo" => "conference.png",
);

$decission = array(
    1 => "<<Aceptada>>",
    2 => "considerada <<Publicable con modificaciones>>",
    3 => "considerada <<Reevlauable>>",
    4 => "considerada >>",
);

?>
