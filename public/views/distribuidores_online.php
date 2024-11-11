<?php
defined('ABSPATH') or die();
?>

<?php if (count($distribuidores_online) > 0) { ?>
  <div class="daterium-info-distribuidores">
    <?php foreach ($distribuidores_online as $distribuidor_online) { ?> <a id="daterium-info-distribuidor" href="<?php echo $distribuidor_online->url_web; ?>" alt="<?php echo $distribuidor_online->nombre; ?>" target="_blank">

        <div class="daterium-distribuidores-online">
          <img class="daterium-img-distribuidores" decoding="async" src="<?php echo $distribuidor_online->url_logo; ?>" alt="<?php echo $distribuidor_online->nombre; ?>" />

        </div>
      </a>
      </ul>
    <?php } ?>
  <?php } ?>
  </div>