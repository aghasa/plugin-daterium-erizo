<?php defined('ABSPATH') or die();
if ($carga_bloque_erronea == false && count($categorias_hijas) > 0) { ?>

    <div class="daterium-bloque-slider-container">
        <div class="daterium-bloque-slider">
            <div class="daterium-bloque-slider-botones">
                <span class="daterium-bloque-slider-boton" onclick="mostrar_imagenes(-1)"><svg
                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="#1f1d1d" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"
                        class="feather feather-arrow-left">
                        <line x1="19" y1="12" x2="5" y2="12"></line>
                        <polyline points="12 19 5 12 12 5"></polyline>
                    </svg></span>
                <span class="daterium-bloque-slider-boton" onclick="mostrar_imagenes(1)"><svg
                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="#1f1d1d" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"
                        class="feather feather-arrow-right">
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                        <polyline points="12 5 19 12 12 19"></polyline>
                    </svg></span>
            </div>
            <div class="daterium-imagenes-slider" id="daterium-imagenes-slider">
                <?php foreach ($categorias_hijas as $apartado) { ?>
                    <div class="daterium-bloque-categoria daterium-categoria">
                        <a href="<?php echo site_url() ?>/catalogo/<?php echo $apartado["id"]; ?>"
                            title="<?php echo $apartado["nombre"]; ?>">
                            <div class="daterium-bloque-categoria-inner">
                                <img class="daterium-img-slide" loading="auto" src="<?php echo $apartado["imagen"]; ?>"
                                    alt="<?php echo $apartado["nombre"]; ?>" loading="lazy" />
                                <div class="daterium-bloque-slider-title-container">
                                    <h5 class="daterium-list-title">
                                        <?php echo $apartado['nombre']; ?>
                                    </h5>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
    <script src="<?php echo URL_ROOT ?>public/script/bloque_categoria.js"></script>
<?php } ?>