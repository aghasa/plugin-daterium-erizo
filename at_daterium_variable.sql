-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 12-04-2023 a las 11:05:37
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
-- Estructura de tabla para la tabla `at_daterium_variable`
--

CREATE TABLE IF NOT EXISTS `at_daterium_variable` (
  `codigo` varchar(30) NOT NULL,
  `valor` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Volcado de datos para la tabla `at_daterium_variable`
--

INSERT INTO `at_daterium_variable` (`codigo`, `valor`) VALUES
('catalogo-inicial', '1004249'),
('id-raiz-ferretera', '2bc50820b715a600da0423af4c86d03fc0355ed7');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
