<?php
defined('ABSPATH') or die();

if ($carga_bloque_erronea == false && count($nombre_familias) > 0) { ?>

    <div class="daterium-bloque-familias">

        <?php foreach ($nombre_familias as $familia) { ?>
            
            <div class="daterium-familia">
            <a href="productos/familia/<?php echo $familia['id'] ?>">
                <h5 class="daterium-familia-nombre">
                    <?php echo $familia['nombre']; ?>
                </h5>
                </a>
            </div>
            
        <?php } ?>

    </div>

<?php } ?>