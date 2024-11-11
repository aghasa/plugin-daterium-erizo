<?php

defined('ABSPATH') or die();


/**
 * Función para añadir el head
 */
function daterium_get_title($producto, $categoria, $marca, $userID)
{
    global $imagen;
    if ($producto == 0 && $categoria <> 0 && $marca == 0) {
        $xml = simplexml_load_file("https://api.dateriumsystem.com/catalogo_fc_xml.php?catID=" . $categoria . "&userID=" . $userID . "&ref=0");
        return strval($xml->nombre ?? "Catálogo") /*. " – " . get_bloginfo("name")*/;
    } else if ($producto <> 0 && $categoria == 0 && $marca == 0) {
        $xml = simplexml_load_file("https://api.dateriumsystem.com/producto_mini_fc_xml.php?pID=" . $producto . "&userID=" . $userID . "&ref=0");
        return isset($xml->nombre) ? strval($xml->nombre . " (" . $xml->marca . ")") : "Catálogo" /*. " – " . get_bloginfo("name")*/;
    } else if ($producto == 0 && $categoria == 0 && $marca <> 0) {
        $xml = simplexml_load_file("https://api.dateriumsystem.com/marcas.php?userID=" . $userID);
        return strval($xml->xpath('//marca[@id="' . $marca . '"][1]/nombre[1]')[0] ?? "Catálogo");
        //return isset($xml->nombre) ? strval($xml->nombre . " (" . $xml->marca . ")") : "Catálogo" /*. " – " . get_bloginfo("name")*/;
    } else {
        return "Catálogo" /*. " – " . get_bloginfo("name")*/;
    }
}
