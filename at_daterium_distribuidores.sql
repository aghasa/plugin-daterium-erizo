-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 12-04-2023 a las 11:04:47
-- Versión del servidor: 10.3.38-MariaDB-0+deb10u1
-- Versión de PHP: 8.0.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `aghasaturis_web`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `at_daterium_distribuidores`
--

CREATE TABLE IF NOT EXISTS `at_daterium_distribuidores` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(30) DEFAULT NULL,
  `url_distribuidor` varchar(255) DEFAULT NULL,
  `url_logo` varchar(255) DEFAULT NULL,
  `orden` int(11) DEFAULT 1,
  `url_web` varchar(255) DEFAULT NULL,
  `mostrar_en_productos` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Volcado de datos para la tabla `at_daterium_distribuidores`
--

INSERT INTO `at_daterium_distribuidores` (`id`, `nombre`, `url_distribuidor`, `url_logo`, `orden`, `url_web`, `mostrar_en_productos`) VALUES
(29, 'Marketdeferreteria.com', 'https://marketdeferreteria.com/busqueda?orderby=position&orderway=desc&search_query=', 'https://www2.aghasaturis.com/wp-content/uploads/2023/04/304854992_411130127791375_7502815535766814332_n.jpg', 1, 'https://marketdeferreteria.com', 1),
(30, 'Madiferr', 'https://madriferr.com/buscar?controller=search&orderby=position&orderway=asc&search-cat-select=0&search_query=', 'https://www2.aghasaturis.com/wp-content/uploads/2023/04/madriferr_logo_online_866x719.jpg', 2, 'https://madriferr.com', 1),
(31, 'Casbau', 'https://www.casbau.com/es/module/iqitsearch/searchiqit?s=', 'https://www2.aghasaturis.com/wp-content/uploads/2023/04/casbau_logo_online.png', 3, 'https://casbau.com', 1),
(32, 'Rome', 'https://suministrosindustrialesrome.com/module/rfcnavegacion/buscador?search_query=', 'https://www2.aghasaturis.com/wp-content/uploads/2023/04/rome_logo_online.png', 4, 'https://suministrosindustrialesrome.com', 1),
(33, 'Suincas', 'https://suincas.com/advanced_search_result.php?seleccionado=todos&keywords=', 'https://www2.aghasaturis.com/wp-content/uploads/2023/04/Suincas_Logo2.png', 5, 'https://suincas.com', 1),
(35, 'Anserjo', 'https://www.anserjo.com/buscador?search_query=', 'https://www2.aghasaturis.com/wp-content/uploads/2023/04/anserjo_logo_online.png', 6, 'https://www.anserjo.com', 1),
(37, 'Materiales de Fábrica', '', 'https://www2.aghasaturis.com/wp-content/uploads/2023/04/materialesdefabrica_online_866x719.png', 8, 'https://materialesdefabrica.com/', 0),
(38, 'De Frutos', '', 'https://www2.aghasaturis.com/wp-content/uploads/2023/04/DE_FRUTOS_FERRETERIAS_online.jpg', 8, 'https://ferreteriadefrutos.com/', 0),
(39, 'Ferretería Luma', '', 'https://www2.aghasaturis.com/wp-content/uploads/2023/04/luma_online.png', 9, 'https://www.ferreterialuma.com/', 0),
(40, 'Ferretería Maor', '', 'https://www2.aghasaturis.com/wp-content/uploads/2023/04/maor_online.png', 9, 'https://maorferreteria.es/', 0),
(44, 'Ferreteria.es', '', 'https://www2.aghasaturis.com/wp-content/uploads/2023/04/ferreteria-es_online.png', 7, 'https://ferreteria.es/', 0);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
