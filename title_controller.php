<?php

defined('ABSPATH') or die();


/**
 * Función para añadir el head
 */
function daterium_get_title($producto, $userID)
{
    global $imagen;
    if ($producto <> 0) {
        $xml = simplexml_load_file("https://api.dateriumsystem.com/producto_mini_fc_xml.php?pID=" . $producto . "&userID=" . $userID . "&ref=0");
        return isset($xml->nombre) ? strval($xml->nombre) : "Catálogo" /*. " – " . get_bloginfo("name")*/ ;
    } else {
        return "Catálogo" /*. " – " . get_bloginfo("name")*/ ;
    }
}
