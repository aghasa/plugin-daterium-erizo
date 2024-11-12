<?php
defined('ABSPATH') or exit;
?>

<main id="primary" class="site-main">

  <?php if ($carga_producto_erronea == false) { ?>

    <div class="wrap">
      <?php if ($pid_erroneo == true) { ?>
        <h3>Producto no encontrado</h3>
        <p>La página que estás buscando no está disponible en estos momentos.</p>
      <?php } else { ?>
        <div class="daterium-cabecera-producto">
          <h2 class="daterium-titulo-producto">
            <?php echo $nombre_producto; ?>
          </h2>
        </div>

        <div class="daterium-info-producto">

          <?php if (count($imagenes_producto) > 1) { ?>

            <div class="slideshow-container">

              <?php foreach ($imagenes_producto as $imagenes) { ?>

                <div class="daterium-producto-slide daterium-producto-slide-fade">
                  <img alt="<?php echo $nombre_producto; ?>" class="daterium-imagen-producto"
                    src="<?php echo $imagenes['path']; ?>" loading="auto" />
                </div>
              <?php } ?>
              <div class="daterium-producto-img-buttons">
                <a class="prev" onclick="plusSlides(-1)"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                    viewBox="0 0 24 24" fill="none" stroke="#1f1d1d" stroke-width="2.5" stroke-linecap="round"
                    stroke-linejoin="round" class="feather feather-arrow-left">
                    <line x1="19" y1="12" x2="5" y2="12"></line>
                    <polyline points="12 19 5 12 12 5"></polyline>
                  </svg>
                </a>
                <a class="next" onclick="plusSlides(1)"><svg xmlns="http://www.w3.org/2000/svg"
                    class="icon icon-tabler icon-tabler-arrow-right" width="24" height="24" viewBox="0 0 24 24"
                    stroke-width="3" stroke="#2c3e50" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <line x1="5" y1="12" x2="19" y2="12" />
                    <line x1="13" y1="18" x2="19" y2="12" />
                    <line x1="13" y1="6" x2="19" y2="12" />
                  </svg>
                </a>
              </div>
            </div>
            <script>
              mostrar_carrusel();
            </script>
          <?php } else { ?>
            <div class="daterium-imagen-centrada">
              <img alt="<?php echo $nombre_producto; ?>" class="daterium-imagen-producto" decoding="async"
                src="<?php echo $imagenes_producto[0]['path']; ?>" alt="<?php echo $nombre_producto; ?>" loading="auto" />
            </div>
          <?php } ?>

          <div class="text-cabecera">
            <?php if (count($puntos_clave) > 0) {
              ?>
              <ul class="daterium-puntos-clave">
                <?php
                foreach ($puntos_clave as $punto) { ?>
                  <li>
                    <?php echo $punto; ?>
                  </li>
                <?php } ?>
              </ul>
            <?php }
            ?>
            <p>
              <?php echo $descripcion; ?>
            </p>

          </div>
        </div>

        <div class="daterium-tabla-articulos-container">
          <table class="tabla-articulos" cellspacing="0" cellpadding="0">
            <thead class="cabecera-articulos">
              <tr>
                <th class="daterium-elementos-cabecera-productos nowrap daterium-elemento-tabla-fixed">Referencia</th>
                <?php if ($datos_referencias[0]['nombres_atributos_diferenciadores'] != '') {
                  foreach ($datos_referencias[0]['nombres_atributos_diferenciadores'] as $nombre_descriminador) {
                    if ($nombre_descriminador != '') { ?>
                      <th class="daterium-elementos-cabecera-productos daterium-elementos-cabecera-atributos">
                        <?php echo $nombre_descriminador; ?>
                      </th>
                    <?php }
                  }
                } ?>
                <?php if ($datos_referencias[0]['nombre_caracteristicas'] != '') {
                  foreach ($datos_referencias[0]['nombre_caracteristicas'] as $nombre) {
                    if ($nombre != '') { ?>
                      <th class="daterium-elementos-cabecera-productos daterium-elementos-cabecera-caracteristicas">
                        <?php echo $nombre; ?>
                      </th>
                    <?php }
                  }
                } ?>
                <th class="daterium-elementos-cabecera-productos nowrap">PVR€*</th>
                <th class="daterium-elementos-cabecera-productos daterium-elemento-tabla-adicional">
                  €*/Ud.<br><small>envase</small></th>
                <th class="daterium-elementos-cabecera-productos daterium-elemento-tabla-adicional">
                  Mult.<br><small>compra</small></th>
                <th class="daterium-elementos-cabecera-productos daterium-elemento-tabla-adicional">
                  Uds.<br><small>embalaje</small></th>
              </tr>
            </thead>

            <tbody class="daterium-producto-referencias">
              <?php
              $contador_i = 0;
              foreach ($referencias as $referencia) {
                ?>
                <?php
                $valor_cant_contenido = $referencia->datos_packaging->cantidad_contenido;
                if ($valor_cant_contenido == 0) {
                  $valor_cant_contenido = 1;
                }
                $precio_pvr = $referencia->tarifa->precio_recomendado;
                $precio_cant_contenido = $precio_pvr / $valor_cant_contenido;
                $mostrar = 1;
                if ($metodos_bbdd->get_compra($referencia->codiart) == 0) {
                  $mostrar = 0;
                }
                ?>
                <tr id="<?php echo $referencia->ref; ?>">
                  <td
                    class="daterium-elementos-lista daterium-resaltado-producto daterium-ref daterium-ref-resaltado daterium-elemento-tabla-fixed">
                    <span class="daterium-ref-container">
                      <span onclick="copiar_portapapeles('<?php echo $referencia->ref; ?>')">
                        <?php echo $referencia->ref; ?>
                      </span>
                    </span>
                  </td>
                  <?php
                  if ($datos_referencias[$contador_i]['datos_atributos_diferenciadores'] != '') {
                    foreach ($datos_referencias[$contador_i]['datos_atributos_diferenciadores'] as $dato) {
                      if ($dato != '') { ?>
                        <td class="daterium-elementos-lista daterium-element-align daterium-element-atributos">
                          <?php echo $dato; ?>
                        </td>
                      <?php }
                    }
                  }

                  if ($datos_referencias[$contador_i]['datos_caracteristicas'] != '') {
                    foreach ($datos_referencias[$contador_i]['datos_caracteristicas'] as $dato) {
                      if ($dato != '') { ?>
                        <td class="daterium-elementos-lista daterium-element-align daterium-element-caracteristicas">
                          <?php echo $dato; ?>
                        </td>
                      <?php }
                    }
                  }
                  ?>

                  <td class="daterium-elementos-lista daterium-resaltado-producto daterium-ref-resaltado">
                    <?php
                    if ($mostrar == 1) {
                      echo number_format((float) $precio_pvr, 2, ',', '.');
                    } else {
                      echo '-';
                    }
                    ?>
                  </td>

                  <td
                    class="daterium-elementos-lista daterium-element-align daterium-elementos-border daterium-elementos-cantidad">
                    <?php
                    if ($mostrar == 1) {
                      echo number_format((float) $precio_cant_contenido, 3, ',', '.');
                    } else {
                      echo '-';
                    }
                    ?>
                  </td>
                  <td
                    class="daterium-elementos-lista daterium-element-align daterium-elementos-border daterium-elementos-cantidad">
                    <?php if ($mostrar == 1) {
                      echo '×' . $referencia->datos_logisticos->unidad_entrega->ue_cantidad;
                    } else {
                      echo '-';
                    } ?>
                  </td>
                  <td
                    class="daterium-elementos-lista daterium-element-align daterium-elementos-border daterium-elementos-cantidad">
                    <?php if ($mostrar == 1) {
                      echo $referencia->datos_logisticos->unidad_preparacion->up_cantidad;
                      if ($referencia->datos_packaging->cantidad_contenido > 1) { ?><small>
                          <?php echo '(×' . number_format((int) $referencia->datos_packaging->cantidad_contenido) . ')';
                      } ?>
                      </small>
                      <?php
                    } else {
                      echo '-';
                    } ?>
                  </td>
                </tr>

          </div>
          </a>

          <?php ++$contador_i;
              } ?>
        </tbody>
        </table>
      </div>

      <div class="daterium-leyenda">
        <div class="leyenda-articulos-descriptivo">
          <div class="alerta-wishlist"><span><b>*</b></span><small> Precio antes de
              impuestos.</small>
          </div>

        </div>

        <div class="daterium-info-div-cabecera">
          <span><span onclick="mostrar_datos('masinfo')">Información de la referencia:</span>
            <?php if (count($referencias) > 1) { ?>
              <select title="Seleccione una referencia para ver su información adicional" class="select-ref"
                onchange="ver_datos(value);">
                <?php
                $i = 0;
                foreach ($referencias as $referencia) { ?>
                  <option value="<?php echo $i; ?>">
                    <?php echo $referencia->ref; ?>
                  </option>
                  <?php
                  $i = $i + 1;
                } ?>
              </select>

            <?php } else { ?>
              <span onclick="mostrar_datos('masinfo')">
                <?php echo $referencias[0]->ref; ?>
              </span>
            <?php } ?>
          </span>
          <div class="daterium-fill-space" alt="Expandir" onclick="mostrar_datos('masinfo')"></div>
          <img class="daterium-img-expandir" id="img-masinfo" src="<?php echo URL_ROOT; ?>public/img/down.svg"
            alt="Expandir" onclick="mostrar_datos('masinfo')">
        </div>

        <div id="masinfo" class="ocultar daterium-info-expand">
          <div class="daterium-info-bloques">
            <h5 class="daterium-info-title">Datos principales:</h5>
            <div class="info-div">
              <p class="daterium-producto-info"><span class="daterium-producto-info-cab">Artículo: </span><span id="deno">
                  <?php echo $datos_referencias[0]['descripcion']; ?>
                </span></p>
            </div>
            <div class="info-div">
              <p class="daterium-producto-info"><span class="daterium-producto-info-cab">Referencia: </span><span
                  id="ref_in">
                  <?php echo $datos_referencias[0]['ref']; ?>
                </span></p>
            </div>
            <div class="info-div">
              <p class="daterium-producto-info"><span class="daterium-producto-info-cab">Código EAN: </span><span id="ean">
                  <?php echo $datos_referencias[0]['ean']; ?>
                </span></p>
            </div>
          </div>

          <?php if ($datos_referencias[0]['caracteristicas'] != '') { ?>
            <div class="daterium-info-bloques">
              <h5 class="daterium-info-title">Caracteristicas</h5>
              <div id="carac">
                <?php echo $datos_referencias[0]['caracteristicas']; ?>
              </div>
            </div>
          <?php } ?>

          <?php if ($datos_referencias[0]['dimensiones'] != '') { ?>
            <div class="daterium-info-bloques">
              <h5 class="daterium-info-title">Dimensiones</h5>
              <div id="rf_dimensiones">
                <?php echo $datos_referencias[0]['dimensiones']; ?>
              </div>
            </div>
          <?php } ?>

          <div class="daterium-info-bloques">
            <h5 class="daterium-info-title">Tarifa</h5>
            <div class="info-div">
              <p class="daterium-producto-info"><span class="daterium-producto-info-cab">PVR (precio antes de impuestos):
                </span><span id="precio">
                  <?php

                  echo $datos_referencias[0]['precio_recomendado'] . '€';

                  ?>
                </span>

              </p>
            </div>
          </div>

          <?php if ($datos_referencias[0]['uni_pre'] != '') { ?>

            <div class="info-div">
              <p class="daterium-producto-info"><span class="daterium-producto-info-cab">Unidad precio: </span><span
                  id="uni_pre">
                  <?php echo $datos_referencias[0]['uni_pre']; ?>
                </span></p>
            </div>
            <div class="info-div">
              <p class="daterium-producto-info"><span class="daterium-producto-info-cab">Condicionante de compra:
                </span> Múltiplos de <span id="un_entrega">
                  <?php echo $datos_referencias[0]['un_entrega']; ?>
                </span></p>
            </div>
          <?php } ?>

          <div class="daterium-info-bloques">
            <h5 class="daterium-info-title">Datos packaging</h5>
            <div class="info-div">
              <p class="daterium-producto-info"><span class="daterium-producto-info-cab">Cantidad de contenido: </span><span
                  id="cant_cont">
                  <?php echo $datos_referencias[0]['cant_cont']; ?>
                </span></p>
            </div>
            <div class="info-div">
              <p class="daterium-producto-info"><span class="daterium-producto-info-cab">Unidad de contenido: </span><span
                  id="uni_cont">
                  <?php echo $datos_referencias[0]['uni_cont']; ?>
                </span></p>
            </div>
            <?php if (strlen($datos_referencias[0]['peso']) > 2) { ?>
              <div class="info-div">
                <p class="daterium-producto-info"><span class="daterium-producto-info-cab">Peso: </span><span id="peso">
                    <?php echo $datos_referencias[0]['peso']; ?>
                  </span></p>
              </div>
            <?php } ?>
            <?php if (strlen($datos_referencias[0]['largo']) > 2) { ?>
              <div class="info-div">
                <p class="daterium-producto-info"><span class="daterium-producto-info-cab">Largo: </span><span id="largo">
                    <?php echo $datos_referencias[0]['largo']; ?>
                  </span></p>
              </div>
            <?php } ?>

            <?php if (strlen($datos_referencias[0]['ancho']) > 2) { ?>
              <div class="info-div">
                <p class="daterium-producto-info"><span class="daterium-producto-info-cab">Ancho: </span><span id="ancho">
                    <?php echo $datos_referencias[0]['ancho']; ?>
                  </span></p>
              </div>
            <?php } ?>
            <?php if (strlen($datos_referencias[0]['alto']) > 2) { ?>
              <div class="info-div">
                <p class="daterium-producto-info"><span class="daterium-producto-info-cab">Alto: </span><span id="alto">
                    <?php echo $datos_referencias[0]['alto']; ?>
                  </span></p>
              </div>
            <?php } ?>
            <?php if (strlen($datos_referencias[0]['presentacion']) > 2) { ?>
              <div class="info-div">
                <p class="daterium-producto-info"><span class="daterium-producto-info-cab">Presentacion: </span><span
                    id="presentacion">
                    <?php echo $datos_referencias[0]['presentacion']; ?>
                  </span></p>
              </div>
            <?php } ?>
          </div>

          <div class="daterium-info-bloques">
            <h5 class="daterium-info-title">Datos logísticos</h5>

            <?php if (strlen($datos_referencias[0]['up_ean']) > 0) { ?>
              <div class="info-div">
                <p class="daterium-producto-info"><span class="daterium-producto-info-cab">Unidad de preparación - código EAN:
                  </span><span id="up_ean">
                    <?php echo $datos_referencias[0]['up_ean']; ?>
                  </span></p>
              </div>
            <?php } ?>

            <?php if ($datos_referencias[0]['up_cantidad'] != 0) { ?>
              <div class="info-div">
                <p class="daterium-producto-info"><span class="daterium-producto-info-cab">Unidades contenidas en un embalaje
                    (Master Carton):
                  </span><span id="up_cantidad">
                    <?php echo $datos_referencias[0]['up_cantidad']; ?>
                  </span></p>
              </div>
            <?php } ?>

            <?php if ($datos_referencias[0]['up_peso'] != 0) { ?>
              <div class="info-div">
                <p class="daterium-producto-info"><span class="daterium-producto-info-cab">Unidad de preparación - peso:
                  </span><span id="up_peso">
                    <?php echo $datos_referencias[0]['up_peso']; ?>
                  </span></p>
              </div>
            <?php } ?>

            <?php if ($datos_referencias[0]['up_largo'] != 0) { ?>
              <div class="info-div">
                <p class="daterium-producto-info"><span class="daterium-producto-info-cab">Unidad de preparación - largo:
                  </span><span id="up_largo">
                    <?php echo $datos_referencias[0]['up_largo']; ?>
                  </span></p>
              </div>
            <?php } ?>

            <?php if ($datos_referencias[0]['up_ancho'] != 0) { ?>
              <div class="info-div">
                <p class="daterium-producto-info"><span class="daterium-producto-info-cab">Unidad de preparación - ancho:
                  </span><span id="up_ancho">
                    <?php echo $datos_referencias[0]['up_ancho']; ?>
                  </span></p>
              </div>
            <?php } ?>

            <?php if ($datos_referencias[0]['up_alto'] != 0) { ?>
              <div class="info-div">
                <p class="daterium-producto-info"><span class="daterium-producto-info-cab">Unidad de preparación - alto:
                  </span><span id="up_alto">
                    <?php echo $datos_referencias[0]['up_alto']; ?>
                  </span></p>
              </div>
            <?php } ?>
          </div>

          <div class="daterium-info-bloques">
            <h5 class="daterium-info-title">Estado artículo</h5>
            <div class="info-div">
              <p class="daterium-producto-info"><span class="daterium-producto-info-cab">Estado: </span><span id="estado">
                  <?php echo $datos_referencias[0]['estado']; ?>
                </span></p>
            </div>
            <div class="info-div">
              <p class="daterium-producto-info"><span class="daterium-producto-info-cab">Fecha: </span><span id="estado">
                  <?php echo $datos_referencias[0]['estado_fecha']; ?>
                </span></p>
            </div>
          </div>
          
          <?php
          if ($datos_referencias[0]['docu_ref'] != '') { ?>
            <h5 class="daterium-info-title">Descargas y enlaces adicionales de la referencia</h5>
            <div class="info-div">
              <span id="docu_ref">
                <?php echo $datos_referencias[0]['docu_ref']; ?>
              </span>
            </div>
          <?php } ?>
        </div>

        <?php if ($numero_adjuntos > 0) { ?>

          <div class="daterium-info-div-cabecera" onclick="mostrar_datos('descargas')">
            <span>Descargas y enlaces </span>
            <img class="daterium-img-expandir" id="img-descargas" src="<?php echo URL_ROOT; ?>public/img/down.svg"
              alt="Expandir">
          </div>
          <div id="descargas" class="ocultar daterium-info-expand">

            <?php foreach ($adjuntos as $adjunto) { ?>
              <div class="info-div">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-external-link" width="20"
                  height="20" viewBox="0 0 24 24" stroke-width="2" stroke="#0b0b0b" fill="none" stroke-linecap="round"
                  stroke-linejoin="round">
                  <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                  <path d="M11 7h-5a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-5" />
                  <line x1="10" y1="14" x2="20" y2="4" />
                  <polyline points="15 4 20 4 20 9" />
                </svg> <a href="<?php echo $adjunto['url']; ?>" alt="<?php echo $adjunto['nombre']; ?>" target="_blank">
                  <?php echo $adjunto['nombre']; ?>
                </a>
              </div>
            <?php } ?>
          </div>

        <?php } ?>


        <?php if ($numero_relacionados > 0) { ?>
          <div class="daterium-info-div-cabecera daterium-info-expand-cabecera">
            <span>Productos relacionados</span>

          </div>
          <div id="relacionados" class="daterium-info-expand">
            <div class="daterium-productos-relacionados">
              <?php foreach ($datos_relacionados as $relacionado) { ?>

                <div class="daterium-producto-relacionado">
                  <a href="<?php echo get_permalink() . '/' . $relacionado['pID']; ?>">
                    <div class="daterium-producto-relacionado-inner">
                      <div class="daterium-producto-relacionado-foto">
                        <img class="imagen-relacionados" decoding="async" src="<?php echo $relacionado['imagen']; ?>"
                          alt="<?php echo $relacionado['nombre']; ?>" />
                      </div>
                      <div class="daterium-producto-relacionado-titulo">
                        <p class="texto-producto-relacionado">
                          <?php echo $relacionado['nombre']; ?>
                        </p>
                      </div>
                    </div>
                  </a>

                </div>

              <?php } ?>
            </div>
          </div>


        <?php } ?>

        <?php if ($numero_videos > 0) { ?>


          <div class="daterium-info-div-cabecera daterium-info-expand-cabecera">
            <span>Vídeos</span>
          </div>
          <div id="videos" class="daterium-info-expand">
            <div class="daterium-productos-relacionados">
              <?php foreach ($videos as $video) { ?>

                <div class="daterium-producto-relacionado">
                  <iframe src="https://www.youtube-nocookie.com/embed/<?php echo $video->semilla; ?>" frameborder="0"
                    allow="autoplay; encrypted-media"></iframe>
                  <small class="texto-producto-relacionado">
                    <?php echo $video->titulo; ?>
                  </small>
                </div>

              <?php } ?>
            </div>
          </div>
        <?php } ?>

      <?php } ?>
      <?php echo $script_schema_producto; ?>

    <?php } else { ?>
      <h3>Producto no encontrado</h3>
      <p>La página que estás buscando no está disponible en estos momentos.</p>
    <?php } ?>


</main>