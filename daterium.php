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
$daterium_catalogo_inicial;
$daterium_catalogo_inicial = $metodos_bbdd->get_catalogo_inicial();

$imagen = "";



/*******************************
 * Definición de los shortcode *
 ******************************/
add_shortcode('daterium_catalogo', 'daterium_print');
add_shortcode('daterium_bloque_categorias', 'daterium_bloque_categorias_print');




/************************************************
 * Funciones para crear el slider de categorías *
 ***********************************************/
function daterium_bloque_categorias()
{
    global $daterium_catalogo_inicial;
    global $daterium_userid;

    include_once(DATERIUM_PLUGIN_DIR . 'public/models/metodos_daterium.php');
    $metodos_daterium = new Metodos_Daterium();
    $estado_daterium_bloque = $metodos_daterium->get_status_daterium();
    $carga_bloque_erronea = true;

    if ($estado_daterium_bloque == 'activo') {
        require_once(DATERIUM_PLUGIN_DIR . 'public/models/metodos_bbdd.php');
        $url_bloque_categoria = "https://api.dateriumsystem.com/catalogo_fc_xml.php?catID=\". $daterium_catalogo_inicial . \"&userID=" . $daterium_userid . "&ref=0";
        $xml = $metodos_daterium->daterium_get_data_url($url_bloque_categoria);
        if ($xml != "error") {
            $categorias_hijas = $metodos_daterium->daterium_get_list_categories($xml);
            $carga_bloque_erronea = false;
        }
        include_once(DATERIUM_PLUGIN_DIR . 'public/views/bloque_categoria_view.php');
    }
}

function daterium_bloque_categorias_print()
{
    ob_start();
    daterium_bloque_categorias();
    return ob_get_clean();
}


/********************************************
 * Funciones para crear los puntos de venta *
 *******************************************/
function daterium_puntos_venta_online()
{
    require_once(DATERIUM_PLUGIN_DIR . 'public/models/metodos_bbdd.php');
    $metodos_bbdd = new Metodos_bbdd();
    $distribuidores_online = $metodos_bbdd->get_distribuidores_online();
    include_once(DATERIUM_PLUGIN_DIR . 'public/views/distribuidores_online.php');
}

function daterium_puntos_venta_online_print()
{
    ob_start();
    daterium_puntos_venta_online();
    return ob_get_clean();
}


/**********************************************
 * Función principal que contrala el catálogo *
 *********************************************/
function daterium()
{

    global $daterium_catalogo_inicial;
    include_once(DATERIUM_PLUGIN_DIR . 'public/models/metodos_daterium.php');
    $metodos_daterium = new Metodos_Daterium();

    $estado_daterium = $metodos_daterium->get_status_daterium();

    if ($estado_daterium == 'activo') {
        require_once(DATERIUM_PLUGIN_DIR . 'public/models/metodos_bbdd.php');
        $metodos_bbdd = new Metodos_bbdd();
        $distribuidores_productos = $metodos_bbdd->get_distribuidores_productos();

        $es_catalogo_inicial = false;
        $categoria = intval(get_query_var('apartado'));
        $producto = intval(get_query_var('producto'));
        $marca = intval(get_query_var('marca'));


        if ($producto == 0 && $categoria == 0 && $marca == 0) { // Catálogo inicial
            $es_catalogo_inicial = true;
            $categoria = $daterium_catalogo_inicial;
            require_once(DATERIUM_PLUGIN_DIR . 'marca_controller.php');
        } else if ($producto == 0 && $categoria <> 0 && $marca == 0) { // Entramos en una categoría       
            require_once(DATERIUM_PLUGIN_DIR . 'categoria_controller.php');
        } else if ($producto == 0 && $categoria == 0 && $marca <> 0) { // Entramos en una categoría       
            require_once(DATERIUM_PLUGIN_DIR . 'marca_controller.php');
        } else { // Entramos en un producto       
            require_once(DATERIUM_PLUGIN_DIR . 'producto_controller.php');
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

    $categoria = intval(get_query_var('apartado'));
    $producto = intval(get_query_var('producto'));
    $marca = intval(get_query_var('marca'));

    if ($producto != 0 || $categoria != 0 || $marca != 0) {
        require_once(DATERIUM_PLUGIN_DIR . 'title_controller.php');
        $title = daterium_get_title($producto, $categoria, $marca, $daterium_userid);
    }
    return $title;
}
add_filter("pre_get_document_title", "set_title", 20);


/*************************************************
 * Función para eliminar los links shortlink y canonical de la cabecera *
 ************************************************/
function daterium_remove_links()
{
    $categoria = intval(get_query_var('apartado'));
    $producto = intval(get_query_var('producto'));
    $marca = intval(get_query_var('marca'));

    if ($producto != 0 || $categoria != 0 || $marca != 0) {
        remove_action('wp_head', 'wp_shortlink_wp_head'); // 
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
    $categoria = intval(get_query_var('apartado'));
    $producto = intval(get_query_var('producto'));
    $marca = intval(get_query_var('marca'));

    if ($producto != 0 || $categoria != 0 || $marca != 0) {
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
    $categoria = intval(get_query_var('apartado'));
    $producto = intval(get_query_var('producto'));
    $marca = intval(get_query_var('marca'));

    if ($producto != 0 || $categoria != 0 || $marca != 0) {
        $quitar = false;
    }
    return $quitar;
}

function daterium_url()
{
    $categoria = intval(get_query_var('apartado'));
    $producto = intval(get_query_var('producto'));
    $marca = intval(get_query_var('marca'));

    if ($producto != 0 || $categoria != 0 || $marca != 0) {

        if ($producto == 0 && $marca == 0 && $categoria <> 0) {
            return get_permalink() . '/' . $categoria;
        } elseif ($producto == 0 && $marca <> 0 && $categoria == 0) {
            return get_permalink() . '/marca/' . $marca;
        } else {
            return get_permalink() . '/producto/' . $producto;
        }
    }
}

function daterium_activo_array($quitar)
{
    $categoria = intval(get_query_var('apartado'));
    $producto = intval(get_query_var('producto'));
    $marca = intval(get_query_var('marca'));

    if ($producto != 0 || $categoria != 0 || $marca != 0) {
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

    $categoria = intval(get_query_var('apartado'));
    $producto = intval(get_query_var('producto'));

    if ($producto != 0 || $categoria != 0) {
        if ($producto == 0 && $categoria <> 0) {
            echo '<link rel="canonical" href="' . get_permalink() . '/' . $categoria . '">' . "\n";
            echo '<link rel="shortlink" href="' . get_permalink() . '/' . $categoria . '">' . "\n";
            echo '<meta property="og:image" content="' . $imagen . '" />' . "\n";
        } else {
            echo '<link rel="canonical" href="' . get_permalink() . '/producto/' . $producto . '">' . "\n";
            echo '<link rel="shortlink" href="' . get_permalink() . '/producto/' . $producto . '">' . "\n";
            echo '<meta property="og:image" content="' . $imagen . '" />' . "\n";
        }
    }
}
//add_action('wp_head', 'set_meta_tags');




/****************************************************
 * Función para añadir los scripts en los productos *
 ***************************************************/
function set_js()
{
    $producto = intval(get_query_var('producto'));
    $marca = intval(get_query_var('marca'));
    if ($producto != 0) {
        wp_register_script('imagenes_function', plugins_url('public/script/imagenes_function.js', __FILE__), array(), '', false);
        wp_register_script('producto_function', plugins_url('public/script/producto_function.js', __FILE__), array(), '', true);
        wp_enqueue_script('imagenes_function');
        wp_enqueue_script('producto_function');
    } else if ($marca != 0) {
        wp_register_script('marca_function', plugins_url('public/script/marca_function.js', __FILE__), array(), '', true);
        wp_enqueue_script('marca_function');
    }
}
add_action('wp_print_scripts', 'set_js');


/*********************************************************** 
 *  Funciones necesarias para la carga correcta del plugin *
 *         Que son llamadas a través de add_action         * 
 **********************************************************/
function daterium_endpoint()
{
    add_rewrite_endpoint('apartado', EP_PAGES);
    add_rewrite_endpoint('producto', EP_PAGES);
    add_rewrite_endpoint('marca', EP_PAGES);
}

function daterium_rewrite()
{
    
    add_rewrite_rule(
        '^productos/producto/?/([^/]*)',
        'index.php?page_id=24&producto=$matches[1]',
        'top'
    );


    add_rewrite_rule(
        '^productos/marca/?/([^/]*)',
        'index.php?page_id=24&marca=11266',
        'top'
    );


    add_rewrite_rule(
        '^productos/?/([^/]*)',
        'index.php?page_id=24&marca=11266',
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
 * Función que muestra los distribuidores
 */
function show_distribuidores()
{
    require_once(DATERIUM_PLUGIN_DIR . 'public/models/metodos_bbdd.php');
    $metodos_bbdd = new Metodos_bbdd();
    $distribuidores = $metodos_bbdd->get_distribuidores();
    require_once(DATERIUM_PLUGIN_DIR . 'public/views/distribuidores_view.php');
}


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

    if (in_array('contributor', (array) $user->roles)) {
        add_menu_page('Distribuidores', 'Distribuidores', 'contributor', 'distribuidores_view.php', 'show_distribuidores', 'dashicons-groups');
    }

    if (in_array('editor', (array) $user->roles)) {
        add_menu_page('Distribuidores', 'Distribuidores', 'editor', 'distribuidores_view.php', 'show_distribuidores', 'dashicons-groups');
    }

    if (in_array('administrator', (array) $user->roles)) {
        add_menu_page('Distribuidores', 'Distribuidores', 'administrator', 'distribuidores_view.php', 'show_distribuidores', 'dashicons-groups');
        add_menu_page('Variables Entorno', 'Variables Entorno', 'administrator', 'variables_view.php', 'show_variables', 'dashicons-smiley');
    }
}
add_action('admin_menu', 'show_items_menu');
