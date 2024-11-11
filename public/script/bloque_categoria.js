let slide_actual = 0; //Variable que controla la primera que está en pantalla

let imagenes_en_pantalla = 3; //Variable que contiene el numero de imagenes a mostrar en pantalla

/**
 * Evento que controla el tamaño de la pantalla actual
 * y llama a la funcion de actualizar imagens en pantalla
 */
window.addEventListener("resize", update_images);

/**
 * Función que actualiza las imagenes
 */
function update_images() {
  let width = window.innerWidth;
  imagenes_en_pantalla = get_number_images(width);

  let container = document.getElementById("daterium-imagenes-slider");
  container.style.gridTemplateColumns =
    "repeat(" + imagenes_en_pantalla + ", 1fr)";
  mostrar_imagenes(0);
}

/**
 * Función para calcular las imagenes en pantallaen la carga principal
 */
function get_current_screen() {
  let width = window.innerWidth;
  imagenes_en_pantalla = get_number_images(width);

  let container = document.getElementById("daterium-imagenes-slider");
  container.style.gridTemplateColumns =
    "repeat(" + imagenes_en_pantalla + ", 1fr)";
}

/**
 * Función para obtener el número de imagenes a
 * mostrar en función del ancho de la pantalla
 */
function get_number_images(pixeles) {
  let number = 1;
  if (pixeles > 1400) {
    number = 4;
  } else if (pixeles > 1040) {
    number = 3;
  } else if (pixeles > 640) {
    number = 2;
  } else {
    number = 1;
  }
  return number;
}

/**
 * Función que nos muestra las imagenes en pantalla
 */
function mostrar_imagenes(n) {
  let es_inicio = true;
  let slides = document.getElementsByClassName("daterium-bloque-categoria");

  slide_actual = slide_actual + n;

  for (i = 0; i < slides.length; i++) {
    slides[i].style.display = "none";
  }

  if (slide_actual + n < 0) {
    for (var i = 0; i < imagenes_en_pantalla; i++) {
      slides[i].style.display = "block";
    }
    slide_actual = 0;
  } else if (slide_actual + imagenes_en_pantalla > slides.length) {
    for (var i = 1; i <= imagenes_en_pantalla; i++) {
      slides[slides.length - i].style.display = "block";
    }
    if (n == 1) {
      slide_actual = slide_actual - n;
    } else if (n == -1) {
      slide_actual = slide_actual + n;
    } else {
      slide_actual = slide_actual - n;
    }
  } else {
    for (var i = 0; i < imagenes_en_pantalla; i++) {
      slides[slide_actual + i].style.display = "block";
    }
  }
}

/******************************************************
 * Funciones que se cargan inicialmente con el script *
 *****************************************************/
get_current_screen();
mostrar_imagenes(slide_actual);
