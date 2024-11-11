<?php defined('ABSPATH') or die();

if ($carga_busqueda_erronea == false) {
    if (count($datos_productos) > 0) { ?>
        <h3 class="daterium-titulo-busqueda">Mostrando resultados de: <?php echo $info; ?></h3>
        <div class="wrap">
            <div class="daterium-lista-categorias">
                <?php foreach ($datos_productos as $dato) { ?>
                    <div class="daterium-categoria" id="<?php echo $dato["pID"] ?>">
                        <a href="<?php echo get_permalink() ?>/producto/<?php echo $dato["pID"] . '/' . $dato["url"]; ?>"
                            alt="<?php echo $dato["nombre"]; ?>">
                            <div class="daterium-list-inner">
                                <div class="daterium-list-brand">
                                    <img src="https://tarifa.aghasaturis.com/img/marcas/<?php echo $dato["id_marca"]; ?>.svg"
                                        decoding="async" alt="<?php echo $dato["marca"]; ?>" />
                                </div>
                                <img src="<?php echo $dato["imagen"]; ?>" decoding="async" alt="<?php echo $dato["nombre"]; ?>" />
                                <div class="daterium-list-title-container">
                                    <h5 class="daterium-list-title">
                                        <?php echo $dato["nombre"]; ?>
                                    </h5>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php } ?>
            </div>
        </div>

    <?php } else { ?>
        <p class="resaltado-buscador">La búsqueda de <b><?php echo $info; ?></b> no obtuvo ningún resultado.</p>
    <?php }
} else {
    echo '<h3 style="text-align: center;">No es posible conectar con el catálogo online</h3>';
}
