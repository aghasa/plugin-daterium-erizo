<?php

defined('ABSPATH') or exit;
global $daterium_userid;
$dato = 11266;
$productos_hijos = [];

$carga_marca_erronea = true;

echo 'ID de marca: ' . $dato . '<br>';

$url_marca = 'https://api.dateriumsystem.com/productos_marca_xml.php?idmarca=' . $dato . '&userID=' . $daterium_userid;

$xml_marca = $metodos_daterium->daterium_get_data_url($url_marca);

if ($xml_marca != 'error') {
    $productos_hijos = $metodos_daterium->daterium_get_list_products_marca($xml_marca);

    $nombre_marca = $metodos_daterium->get_nombre_marca($dato);
    $carga_marca_erronea = false;

} else {
    echo 'Hubo un error al cargar la marca.<br>';
    $carga_marca_erronea = true;
}
include DATERIUM_PLUGIN_DIR . 'public/views/marca_view.php';
