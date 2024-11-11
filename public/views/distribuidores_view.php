<?php defined('ABSPATH') or die(); ?>

<head>
  <link rel="stylesheet" href="<?php echo URL_ROOT ?>public/css/daterium-admin.css" />
  <script src="<?php echo URL_ROOT ?>public/script/admin_function.js"></script>
</head>

<div class="wrap">
  <h1 class="wp-heading-inline"> Distribuidores:</h1>
  <a class="page-title-action" onclick="mostrar_datos('formulario')">Añadir nuevo</a>
</div>


<div id="formulario" class="daterium-admin-ocultar">
  <h3>Formulario para insertar nuevos distribuidores online</h3>
  <form action="" method="post">
    <table class="form-table" role="presentation">
      <tbody>
        <tr>
          <th scope="row">Nombre</th>
          <td>
            <input type="text" name="name" class="regular-text" required>
          </td>
        </tr>
        <tr>
          <th scope="row">Url busqueda distribuidor</th>
          <td>
            <input type="url" name="url_distri" class="regular-text">
          </td>
        </tr>
        <tr>
          <th scope="row">Url logo</th>
          <td>
            <input type="url" name="url_foto" class="regular-text" required>
          </td>
        </tr>
        <tr>
          <th scope="row">Url Web</th>
          <td>
            <input type="url" name="url_web" class="regular-text" required>
          </td>
        </tr>
        <tr>
          <th scope="row">Mostrar en productos</th>
          <td>
            <input type="checkbox" name="mostrar_en_productos" class="regular-text">
          </td>
        </tr>
        <tr>
          <th scope="row">Orden</th>
          <td>
            <input type="number" name="orden" class="regular-text" min="1" max="100" required>
          </td>
        </tr>
      </tbody>

    </table>
    <p class="submit"><input type="submit" name="pulsado" id="pulsado" class="button button-primary" value="Guardar cambios"></p>
  </form>
</div>


<?php
if (isset($_POST['pulsado'])) {
  require_once(DATERIUM_PLUGIN_DIR . 'distribuidor_controller.php');

  if ($result == 1) {
    echo "<script>alert('Insertado correctamente');</script>";
    echo "<script>location.reload();</script>";
  } else {
    echo "<script>alert('Fallo al insertar el nuevo distribuidor');</script>";
  }
}
?>

<table class="wp-list-table widefat fixed striped table-view-list users">
  <thead>
    <tr>
      <th scope="col" class="manage-column column-name">Logo</th>
      <th scope="col" class="manage-column column-name">Nombre</th>
      <th scope="col" class="manage-column column-name">Url web</th>
      <th scope="col" class="manage-column column-name">Mostrar en productos</th>
      <th scope="col" class="manage-column column-name">Orden</th>
      <th scope="col" class="manage-column column-posts num">Modificar</th>
      <th scope="col" class="manage-column column-posts num">Eliminar</th>
    </tr>
  </thead>

  <tbody id="the-list">
    <?php
    foreach ($distribuidores as $distribuidor) {
    ?>
      <tr>
        <td class="name column-name " style="vertical-align: inherit;">
          <img class="daterium-admin-distribuidores-img-logo" alt="<?php echo $distribuidor->nombre ?>" src="<?php echo $distribuidor->url_logo ?>" class="avatar avatar-32 photo" loading="auto" decoding="async">
        </td>
        <td class="name column-name sin-vertical" style="vertical-align: inherit;">
          <strong>
            <?php echo $distribuidor->nombre ?>
          </strong>
        </td>
        <td class="name column-name sin-vertical" style="vertical-align: inherit;">
          <strong>
            <?php echo $distribuidor->url_web ?>
          </strong>
        </td>
        <td class="name column-name sin-vertical " style="vertical-align: inherit;">
          <strong>
            <?php echo $distribuidor->mostrar_en_productos ?>
          </strong>
        </td>
        <td class="name column-name sin-vertical " style="vertical-align: inherit;">
          <span aria-hidden="true">
            <?php echo $distribuidor->orden ?>
          </span>
        </td>
        <td class="posts column-posts num sin-vertical" style="vertical-align: inherit;">
          <img class="daterium-admin-img-variable" onclick="open_modal('<?php echo $distribuidor->id; ?>')" src="<?php echo URL_ROOT; ?>public/img/setting.svg" />
        </td>
        <td class="posts column-posts num sin-vertical" style="vertical-align: inherit;">
          <form action="" method="post">
            <ul>
              <li class="boton-eliminar">
                <input type="hidden" name="id_dis" value="<?php echo $distribuidor->id ?>" placeholder="Nombre">
                <p class="daterium-admin-centrar-texto"><input type="submit" name="eliminar" id="eliminar" class="button button-primary" value="X"></p>
              </li>
            </ul>
          </form>
        </td>
      </tr>
      <div id="<?php echo $distribuidor->id; ?>" class="daterium-admin-modalmask">
        <div class="daterium-admin-modalbox daterium-admin-movedown">
          <div class="daterium-admin-modalhead">
            <h1>Distribuidor a modificar</h1>
            <img onclick="cerrar_modal('<?php echo $distribuidor->id; ?>')" id="cerrar" src="<?php echo URL_ROOT ?>public/img/close.svg" alt="cerrar">

          </div>
          <p class="daterium-admin-text-variable "><?php echo $distribuidor->nombre; ?></p>

          <form class="form-table" action="" method="post" onclick="cerrar_modal('<?php echo $distribuidor->id; ?>')" type="hidden" method="post">
            <input type="hidden" id="id_distribuidor" name="id_distribuidor" value="<?php echo $distribuidor->id; ?>" />
            <div class="div-env-var">
              <div class="daterium-admin-form">
                <label class="daterium-admin-label" for="fname">Nombre:</label>
                <input class="input-env-var" type="text" id="valor_nuevo_nombre" name="valor_nuevo_nombre" value="<?php echo $distribuidor->nombre; ?>" placeholder="<?php echo $distribuidor->nombre; ?>" />
              </div>
              <div class="daterium-admin-form">
                <label class="daterium-admin-label" for="fname">Url web:</label>
                <input class="input-env-var" type="text" id="valor_web_nuevo" name="valor_web_nuevo" value="<?php echo $distribuidor->url_web; ?>" placeholder="<?php echo $distribuidor->url_web; ?>" />
              </div>
              <div class="daterium-admin-form">
                <label class="daterium-admin-label" for="fname">Url distribuidor:</label>
                <input class="input-env-var" type="text" id="valor_distribuidor_nuevo" name="valor_distribuidor_nuevo" value="<?php echo $distribuidor->url_distribuidor; ?>" placeholder="<?php echo $distribuidor->url_distribuidor; ?>" />
              </div>
              <div class="daterium-admin-form">
                <label class="daterium-admin-label" for="fname">Url logo:</label>
                <input class="input-env-var" type="text" id="valor_logo_nuevo" name="valor_logo_nuevo" value="<?php echo $distribuidor->url_logo; ?>" placeholder="<?php echo $distribuidor->url_logo; ?>" />
              </div>
              <div class="daterium-admin-form">
                <label class="daterium-admin-label" for="fname">Orden:</label>
                <input class="input-env-var" type="text" id="valor_orden_nuevo" name="valor_orden_nuevo" value="<?php echo $distribuidor->orden; ?>" placeholder="<?php echo $distribuidor->orden; ?>" />
              </div>
              <div class="daterium-admin-form">
                <label class="daterium-admin-label" for="fname">Mostrar en producto:</label>
                <input class="input-env-var" type="checkbox" id="valor_mostrar_en_producto_nuevo" name="valor_mostrar_en_producto_nuevo" value="mostrar_en_producto" <?php if ($distribuidor->mostrar_en_productos == 1) {
                                                                                                                                                                        echo "checked";
                                                                                                                                                                      }; ?> />
              </div>
              <div><span><b>*</b></span><small>Modificar únicamente las variables necesarias, el resto se mantendrán.</small></div>
              <p class="sin-mar-pad "><input type="submit" id="pulsado_modidicar_distribuidor" name="pulsado_modidicar_distribuidor" class="button button-primary" value="Modificar"></p>
            </div>
          </form>
        </div>
      </div>
    <?php } ?>
  </tbody>
</table>

<?php
if (isset($_POST['pulsado_modidicar_distribuidor'])) {
  $modificar_distribuidor = true;
  require_once(DATERIUM_PLUGIN_DIR . 'distribuidor_controller.php');
  if ($resultado == 1) {
    echo "<script>alert('Modificado correctamente');</script>";
    echo "<script>location.reload();</script>";
  } else {
    echo "<script>alert('Fallo de Modificación');</script>";
    echo "<script>location.reload();</script>";
  }
}

if (isset($_POST['eliminar'])) {
  require_once(DATERIUM_PLUGIN_DIR . 'distribuidor_controller.php');

  if ($resultado == 1) {
    echo "<script>alert('Eliminado correctamente');</script>";
    echo "<script>location.reload();</script>";
  } else {
    echo "<script>alert('Fallo de eliminación');</script>";
  }
}
?>