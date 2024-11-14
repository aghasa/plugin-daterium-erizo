<?php

/**
 * Plugin Name: Daterium
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Description: Conexión al catálogo de Daterium
 * Version: 1.0.1
 * Author: Alberto Rodríguez
 * Text Domain: daterium
 */


/*****************************************************************
 * Definición de variables globales a utilizar en todo el plugin *
 ****************************************************************/
defined('ABSPATH') or die();

if (!defined('DATERIUM_PLUGIN_DIR'))
    define('DATERIUM_PLUGIN_DIR', plugin_dir_path(__FILE__));

define('URL_ROOT', plugins_url('/', __FILE__));


require_once(DATERIUM_PLUGIN_DIR . 'public/models/metodos_bbdd.php');
$metodos_bbdd = new Metodos_bbdd();
$daterium_userid;
$daterium_userid = $metodos_bbdd->get_id_rf();
$daterium_id_marca;
$daterium_id_marca = $metodos_bbdd->get_id_marca();
$imagen = "";



/*******************************
 * Definición de los shortcode *
 ******************************/
add_shortcode('daterium_catalogo', 'daterium_print');
add_shortcode('daterium_bloque_familias', 'daterium_bloque_familias_print');


/************************************************
 * Funciones para crear el bloque de familias *
 ***********************************************/
function daterium_bloque_familias()
{
    include_once(DATERIUM_PLUGIN_DIR . 'public/models/metodos_daterium.php');
    $metodos_daterium = new Metodos_Daterium();
    $carga_bloque_erronea = true;

        $url_bloque_familias = "http://erizo.test/wp-content/plugins/plugin-daterium-main/public/daterium-familias.xml";

        $xml_bloque_familias = $metodos_daterium->daterium_get_data_url($url_bloque_familias);

            $nombre_familias = $metodos_daterium->daterium_get_family_names($xml_bloque_familias);
            $carga_bloque_erronea = false;
       include_once(DATERIUM_PLUGIN_DIR . 'public/views/bloque_familia_view.php');
}

function daterium_bloque_familias_print()
{
    ob_start();
    daterium_bloque_familias();
    return ob_get_clean();
}

/**********************************************
 * Función principal que contrala el catálogo *
 *********************************************/
function daterium()
{

    global $daterium_id_marca;
    include_once(DATERIUM_PLUGIN_DIR . 'public/models/metodos_daterium.php');
    $metodos_daterium = new Metodos_Daterium();

    $estado_daterium = $metodos_daterium->get_status_daterium();

    if ($estado_daterium == 'activo') {
        require_once(DATERIUM_PLUGIN_DIR . 'public/models/metodos_bbdd.php');
        $metodos_bbdd = new Metodos_bbdd();

        $producto = intval(get_query_var('producto'));
        $param_familia = intval(get_query_var('familia'));

        if ($producto != 0 || $producto != null) {
            require_once(DATERIUM_PLUGIN_DIR . 'producto_controller.php');
        } else {
            require_once(DATERIUM_PLUGIN_DIR . 'marca_controller.php');
        }
    } else {
        echo '<h3 style="text-align: center;">No es posible conectar con el catálogo online</h3>';
    }
}

function daterium_print()
{
    ob_start();
    daterium();
    return ob_get_clean();
}


/*************************************************
 * Función para modificar el titulo de la página *
 ************************************************/
function set_title($title)
{
    global $daterium_userid;
    global $daterium_id_marca;

    $producto = intval(get_query_var('producto'));

    if ($producto != 0) {
        require_once(DATERIUM_PLUGIN_DIR . 'title_controller.php');
        $title = daterium_get_title($producto, $daterium_userid, $daterium_id_marca);
    }
    return $title;
}
add_filter("pre_get_document_title", "set_title", 20);


/*************************************************
 * Función para eliminar los links shortlink y canonical de la cabecera *
 ************************************************/
function daterium_remove_links()
{
    $producto = intval(get_query_var('producto'));

    if ($producto != 0) {
        remove_action('wp_head', 'wp_shortlink_wp_head');
        remove_action('wp_head', 'rel_canonical');
    }
}

add_filter("pre_get_shortlink", "daterium_remove_links", 10);



/**************************************************
 * Función para eliminar todas las etiquetas meta *
 *              que inserta yoast                 *
 *************************************************/
function wpseo_remove_opengraph($classes)
{
    $producto = intval(get_query_var('producto'));

    if ($producto != 0) {
        $classes = array_filter($classes, function ($class) {
            return strpos($class, 'Open_Graph') === false;
        });
    }

    return $classes;
}

add_filter('wpseo_frontend_presenter_classes', 'wpseo_remove_opengraph');


/***************************************************************
 *     Funciones para el uso del plugin The SEO Framework      * 
 **************************************************************/
function daterium_activo($quitar)
{
    $producto = intval(get_query_var('producto'));

    if ($producto != 0) {
        $quitar = false;
    }
    return $quitar;
}

function daterium_url()
{
    $producto = intval(get_query_var('producto'));

    if ($producto != 0) {
        return get_permalink() . '/' . $producto;

    }
}

function daterium_activo_array($quitar)
{
    $producto = intval(get_query_var('producto'));

    if ($producto != 0) {
        $quitar = array();
    }
    return $quitar;
}


add_filter('wpseo_json_ld_output', 'daterium_activo');

add_filter('the_seo_framework_title_from_custom_field', 'set_title');

add_filter('the_seo_framework_ogurl_output', 'daterium_url');

add_filter('the_seo_framework_rel_canonical_output', 'daterium_url');

add_filter('the_seo_framework_json_breadcrumb_output', 'daterium_activo');

add_filter('the_seo_framework_image_details', 'daterium_activo_array');

/******************************************
 * Función para añadir las meta etiquetas *
 *****************************************/
function set_meta_tags()
{
    global $daterium_userid;
    global $imagen;

    $producto = intval(get_query_var('producto'));

    if ($producto != 0) {
            echo '<link rel="canonical" href="' . get_permalink() . '/' . $producto . '">' . "\n";
            echo '<link rel="shortlink" href="' . get_permalink() . '/' . $producto . '">' . "\n";
            echo '<meta property="og:image" content="' . $imagen . '" />' . "\n";
    }
}
//add_action('wp_head', 'set_meta_tags');




/****************************************************
 * Función para añadir los scripts en los productos *
 ***************************************************/
function set_js() {
    $producto = intval(get_query_var('producto'));
    if ($producto != 0) {
        wp_register_script('imagenes_function', plugins_url('public/script/imagenes_function.js', __FILE__), array(), '', true);
        wp_register_script('producto_function', plugins_url('public/script/producto_function.js', __FILE__), array(), '', true);
        wp_enqueue_script('imagenes_function');
        wp_enqueue_script('producto_function');

        add_filter('script_loader_tag', 'add_defer_attribute', 10, 2);
    }
}

// asegura que los scripts se ejecuten después de que el contenido HTML esté cargado 
function add_defer_attribute($tag, $handle) {
    if ('imagenes_function' === $handle || 'producto_function' === $handle) {
        return str_replace(' src', ' defer="defer" src', $tag);
    }
    return $tag;
}

add_action('wp_print_scripts', 'set_js');



/*********************************************************** 
 *  Funciones necesarias para la carga correcta del plugin *
 *         Que son llamadas a través de add_action         * 
 **********************************************************/
function daterium_endpoint()
{
    add_rewrite_endpoint('producto', EP_PAGES);
    add_rewrite_endpoint('familia', EP_PAGES);

}

function daterium_rewrite()
{


    add_rewrite_rule(
        '^productos/familia/?/([^/]*)',
        'index.php?page_id=24&familia=$matches[1]',
        'top'
    );
    add_rewrite_rule(
        '^productos/?/([^/]*)',
        'index.php?page_id=24&producto=$matches[1]',
        'top'
    );
    add_rewrite_rule(
        '^productos',
        'index.php?page_id=24',
        'top'
    );
}


/********************************************************* 
 * Acciones necesarias para la carga correcta del plugin * 
 ********************************************************/
add_action('init', 'daterium_endpoint');
add_action('init', 'daterium_rewrite');





/***********************************************************
 * Acciones  y funciones para la carga correcta del plugin *
 * de las secciones en el menu de administrador segun rol  * 
 **********************************************************/



/**
 * Función que muestra las variabbles de entorno
 */
function show_variables()
{
    include_once("public/models/metodos_bbdd.php");
    $metodos_bbdd = new Metodos_bbdd();
    $existe_tabla_variables = $metodos_bbdd->existe_tabla_variables_entorno();

    if ($existe_tabla_variables == false) {
        $metodos_bbdd->crear_tabla_variables('variable');
    } else {
        require_once(DATERIUM_PLUGIN_DIR . 'public/models/metodos_bbdd.php');
        $metodos_bbdd = new Metodos_bbdd();
        $variables = $metodos_bbdd->get_variables();
        require_once(DATERIUM_PLUGIN_DIR . 'public/views/variables_view.php');
    }
}


/**
 * Función para mostrar direntes items en el
 * menu de administrador dependiendo del rol
 */
function show_items_menu()
{
    $user = wp_get_current_user();


    if (in_array('administrator', (array) $user->roles)) {
        add_menu_page('Variables Entorno', 'Variables Entorno', 'administrator', 'variables_view.php', 'show_variables', 'dashicons-smiley');
    }
}
add_action('admin_menu', 'show_items_menu');
