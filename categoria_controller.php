<?php

defined('ABSPATH') or exit;

if (isset($_POST['search'])) {
    global $daterium_userid;

    $carga_busqueda_erronea = true;

    $datos_productos = [];
    $info = '';

    if ($_POST['search'] != '') {

        $info = filter_var(trim($_POST['search']), FILTER_SANITIZE_SPECIAL_CHARS);
        $info = substr($info, 0, 1000);
        $info_url = str_replace(' ', '%20', $info);

        $url_busqueda = 'https://api.dateriumsystem.com/busqueda_avanzada_fc_xml.php?userID=' . $daterium_userid . '&searchbox=' . $info_url . '&limite=300&ref=0';
        $xml_busqueda = $metodos_daterium->daterium_get_data_url($url_busqueda);

        if ($xml_busqueda != 'error') {
            $productos_xml = $xml_busqueda->xpath('resultados/ficha');
            foreach ($productos_xml as $producto) {
                $url_producto = $metodos_daterium->daterium_url_title($producto->nombre);
                array_push($datos_productos, ['pID' => $producto->id, 'nombre' => $producto->nombre, 'imagen' => $producto->img500x500, 'url' => $url_producto, 'marca' => $producto->marca, 'id_marca' => $producto->marca['id'], 'descripcion' => $producto->descripcion]);
            }
            $carga_busqueda_erronea = false;
        } else {
            $carga_busqueda_erronea = true;
        }
    }
    include DATERIUM_PLUGIN_DIR . 'public/views/busqueda_view.php';
} else {
    global $daterium_userid;
    $dato = intval($categoria);
    $categorias_hijas = [];
    $ids_nombre_categorias = [];

    $carga_categoria_erronea = true;

    $url_categoria = 'https://api.dateriumsystem.com/catalogo_fc_xml.php?catID=' . $dato . '&userID=' . $daterium_userid . '&ref=0';
    $xml_categoria = $metodos_daterium->daterium_get_data_url($url_categoria);

    if ($xml_categoria != 'error') {
        $ruta = $metodos_daterium->get_migas_de_pan($xml_categoria, true);
        if ($dato > 1) {
            $categorias_hijas = $metodos_daterium->daterium_get_list_categories($xml_categoria);

            if (count($categorias_hijas) == 0) {
                $categorias_hijas = $metodos_daterium->daterium_get_list_products($xml_categoria);
            }
            if (count($categorias_hijas) > 0) {
                $nombre_categoria = $metodos_daterium->get_nombre_categoria($xml_categoria);
            }
        }
        $carga_categoria_erronea = false;
    } else {
        $carga_categoria_erronea = true;
    }
    include DATERIUM_PLUGIN_DIR . 'public/views/categoria_view.php';
}
