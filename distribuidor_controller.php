<?php

defined('ABSPATH') or die();

$existe_nombre = false;
$existe_url_logo = false;
$existe_orden = false;
$existe_eliminar = false;
$existe_url_web = false;
$existe_mostrar_en_productos = false;
$result = 0;
$resultado = 0;

if (isset($_POST['name']) && $_POST['name'] != "") {
    $existe_nombre = true;
}

if (isset($_POST['url_foto']) && $_POST['url_foto'] != "") {
    $existe_url_logo = true;
}

if (isset($_POST['url_web']) && (int) $_POST['url_web'] != "") {
    $existe_url_web = true;
}

if (isset($_POST['orden']) && (int) $_POST['orden'] > 0) {
    $existe_orden = true;
}

if (isset($_POST['id_dis']) && (int) $_POST['id_dis'] > 0) {
    $existe_eliminar = true;
}

if (isset($_POST['mostrar_en_productos'])) {
    $existe_mostrar_en_productos = true;
}

if ($existe_nombre == true && $existe_url_logo == true && $existe_orden == true && $existe_url_web == true) {
    $result = $metodos_bbdd->nuevo_distribuidor(trim($_POST['name']), trim($_POST['url_distri']), trim($_POST['url_foto']), trim($_POST['orden']), trim($_POST['url_web']), $existe_mostrar_en_productos);
}

if ($existe_eliminar == true) {
    $resultado = $metodos_bbdd->borrar_distribuidor($_POST['id_dis']);
}

if ($modificar_distribuidor == true) {

    $resultado = 0;

    $id_aux = $_POST['id_distribuidor'];
    $aux_nombre = trim($_POST['valor_nuevo_nombre']);
    $aux_url_distribuidor = trim($_POST['valor_distribuidor_nuevo']);
    $aux_logo = trim($_POST['valor_logo_nuevo']);
    $aux_orden = $_POST['valor_orden_nuevo'];
    $aux_web = trim($_POST['valor_web_nuevo']);
    $aux_mostrar = $_POST['valor_mostrar_en_producto_nuevo'];

    if ($aux_mostrar != "mostrar_en_producto") {
        $aux_mostrar = 0;
    } else {
        $aux_mostrar = 1;
    }

    if ($id_aux != 0 && $aux_nombre != "" && filter_var($aux_url_distribuidor, FILTER_VALIDATE_URL) && filter_var($aux_logo, FILTER_VALIDATE_URL) && $aux_orden > 0 && filter_var($aux_web, FILTER_VALIDATE_URL)) {
        $resultado = $metodos_bbdd->modificar_valor_distribuidor($id_aux, $aux_nombre, $aux_url_distribuidor, $aux_logo, $aux_orden, $aux_web, $aux_mostrar);
    } else {

        echo "<script>alert('Revise sus datos, hay alguno erroneo.');</script>";
    }
}
