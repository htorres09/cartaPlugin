<?php
/**
 * @file plugins/generic/carta/index.php
 * Héctor Torres - Universidad Autónoma de Nuevo León
 * hector.torresg@uanl.mx
 *
 * @ingroup plugins_generic_carta
 * @brief Crear carta de aceptacion PDF
 */

 require_once('cartaPDF.inc.php');
 return new cartaPDF();
?>
