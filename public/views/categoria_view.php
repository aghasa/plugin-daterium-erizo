<?php
defined('ABSPATH') or die();
?>
<main id="primary" class="site-main">
    <?php if ($carga_categoria_erronea == false) { ?>
        <header class="page-header<?php if (has_post_thumbnail()): ?> page-header-thumbnail<?php endif; ?>">
            <div class="container-page-header">
                <div class="title-page-header">
                    <div class="wrap <?php if (has_post_thumbnail()): ?>title-page-thumbnail<?php endif; ?>">
                        <?php
                        if (count($categorias_hijas) > 0) { ?>
                            <?php
                            echo $ruta;
                            if ($es_catalogo_inicial == false) { ?>
                                <h2 class="daterium-category-title">
                                    <?php echo $nombre_categoria; ?>
                                </h2>
                            <?php }
                        } ?>
                    </div>
                </div>
            </div>
        </header>

        <div class="wrap">
            <?php if (count($categorias_hijas) > 0) { ?>
                <div class="daterium-lista-categorias">
                    <?php foreach ($categorias_hijas as $apartado) { ?>
                        <div class="daterium-categoria" id="<?php echo $apartado["id"]; ?>">
                            <a href="<?php echo $apartado['url'] ?>" title="<?php echo $apartado['nombre']; ?>">
                                <div class="daterium-list-inner">
                                    <img loading="auto" src="<?php echo $apartado['imagen']; ?>"
                                        alt="<?php echo $apartado['nombre']; ?>" />
                                    <div class="daterium-list-title-container">
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
            <?php
            } else { ?>
            <h3>Categoría no encontrada</h3>
            <p>La página que estás buscando no está disponible en estos momentos.</p>
        <?php } ?>
    <?php } else {
        echo '<h3 style="text-align: center;">No es posible conectar con el catálogo online</h3>';
    } ?>
</main>