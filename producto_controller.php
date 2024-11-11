<?php
defined('ABSPATH') or exit;
$pID = intval($producto);

include_once 'public/models/metodos_daterium.php';
$metodos_daterium = new Metodos_Daterium();

require_once DATERIUM_PLUGIN_DIR . 'public/models/metodos_bbdd.php';
$metodos_bbdd = new Metodos_bbdd();

global $daterium_userid;

// URL para la llamada a la API
$url_producto = 'https://api.dateriumsystem.com/producto_fc_xml.php?pID=' . $pID . '&userID=' . $daterium_userid;

// Tratamos y transformamos el XML devuelto por la API
$xml_producto = $metodos_daterium->daterium_get_data_url($url_producto);

$carga_producto_erronea = true;

// Compruebo que exista el producto
if ($xml_producto != 'error') {
    if (!empty($xml_producto)) {
        $imagenes_producto = $metodos_daterium->get_images($xml_producto);

        // Busco el nodo imagenes/imagen
        $nombre_producto = $xml_producto->nombre;

        $nombre_marca = $xml_producto->marca;
        $logo_marca = $xml_producto->logo_marca;
        $id_marca = $xml_producto->marca['id'];
        $atributo_discriminante = $xml_producto->atributos->atributo1;

        $familia = $xml_producto->familia;
        $subfamilia = $xml_producto->subfamilia;

        $rutas_para_categoria = $xml_producto->xpath('rutas/otrasrutas/ruta/paso');
        $pos_catID_producto = count($rutas_para_categoria) - 1;
        $catID = $rutas_para_categoria[$pos_catID_producto]->catID;

        $ruta = $metodos_daterium->get_migas_de_pan($xml_producto, false);

        // Busco los nodos referencias/referencia
        $referencias = $xml_producto->xpath('referencias/referencia');

        $puntos_clave = $metodos_daterium->get_puntos_clave($xml_producto);
        $descripcion = $metodos_daterium->get_descripcion($xml_producto);

        $descripcion_des = $metodos_daterium->clean_descripcion($descripcion);

        $descripcion_texto_plano = $metodos_daterium->clean_descripcion($xml_producto->descripcion_textoplano);

        $datos_referencias = $metodos_daterium->get_datos_referencias($xml_producto);
        $url = htmlspecialchars($_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'], ENT_QUOTES, 'UTF-8');
        $script_schema_producto = $metodos_daterium->get_script_ProductGroup($nombre_marca, $descripcion_texto_plano, $url, $datos_referencias, $familia, $subfamilia);
        $script_migas_pan = $metodos_daterium->get_script_migas($xml_producto, false);

        $ruta_aecoc = $metodos_daterium->get_clasificacion_aecoc($xml_producto);

        $adjuntos = $metodos_daterium->get_adjuntos($xml_producto);
        $numero_adjuntos = count($adjuntos);

        // Busco los nodos de productos relacionados
        $relacionados_xml = $xml_producto->xpath('productos_relacionados/pID');
        $datos_relacionados = $metodos_daterium->get_related($relacionados_xml, $daterium_userid, 6);
        $numero_relacionados = count($datos_relacionados);

        // Busco los nodos de los videos
        $videos = $xml_producto->xpath('videos/video');
        $numero_videos = count($videos);
        $da_re_json = json_encode($datos_referencias);
        $codificado = base64_encode($da_re_json);
        ?>
        <script type="text/javascript">
            let jsVar_producto = <?php echo json_encode($codificado); ?>;
        </script>
        <?php
        $pid_erroneo = false;
    } else {
        $pid_erroneo = true;
    }
    $carga_producto_erronea = false;
} else {
    $carga_producto_erronea = true;
}
require_once DATERIUM_PLUGIN_DIR . 'public/views/producto_view.php';
?>