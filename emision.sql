-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 26-10-2018 a las 08:43:08
-- Versión del servidor: 5.6.17
-- Versión de PHP: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `emision`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `autorizaciones`
--

CREATE TABLE IF NOT EXISTS `autorizaciones` (
  `idAutorizacion` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  PRIMARY KEY (`idAutorizacion`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Volcado de datos para la tabla `autorizaciones`
--

INSERT INTO `autorizaciones` (`idAutorizacion`, `nombre`) VALUES
(1, 'Autorización de escaneo sin dedo'),
(2, 'Autorización de cancelación folio PVC'),
(3, 'Autorización de omitir un documento'),
(4, 'Autorización de escaneo sin iris');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `biometrico`
--

CREATE TABLE IF NOT EXISTS `biometrico` (
  `idBiometrico` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `clave` varchar(2) NOT NULL DEFAULT '',
  `keyAware` varchar(20) NOT NULL,
  `nombre` varchar(100) NOT NULL DEFAULT '',
  `tipo` enum('huella','iris','rostro') NOT NULL DEFAULT 'huella',
  `controlID` int(11) NOT NULL,
  PRIMARY KEY (`idBiometrico`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Volcado de datos para la tabla `biometrico`
--

INSERT INTO `biometrico` (`idBiometrico`, `clave`, `keyAware`, `nombre`, `tipo`, `controlID`) VALUES
(1, 'DM', 'RIGHT_LITTLE', 'Meñique Derecho', 'huella', 9),
(2, 'DA', 'RIGHT_RING', 'Anular Derecho', 'huella', 8),
(3, 'DE', 'RIGHT_MIDDLE', 'Medio Derecho', 'huella', 7),
(4, 'DI', 'RIGHT_INDEX', 'Índice Derecho', 'huella', 6),
(5, 'IM', 'LEFT_LITTLE', 'Meñique Izquierdo', 'huella', 0),
(6, 'IA', 'LEFT_RING', 'Anular Izquierdo', 'huella', 1),
(7, 'IE', 'LEFT_MIDDLE', 'Medio Izquierdo', 'huella', 2),
(8, 'II', 'LEFT_INDEX', 'Índice Izquierdo', 'huella', 3),
(9, 'DP', 'RIGHT_THUMB', 'Pulgar Derecho', 'huella', 5),
(10, 'IP', 'LETF_THUMB', 'Pulgar Izquierdo', 'huella', 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `login_user`
--

CREATE TABLE IF NOT EXISTS `login_user` (
  `id_login` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) NOT NULL,
  `user_name` varchar(50) NOT NULL,
  `password` char(128) NOT NULL,
  `salt` char(128) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(210) NOT NULL,
  `id_rol` int(11) NOT NULL,
  `id_recaudacion` int(11) NOT NULL,
  `email` varchar(200) NOT NULL,
  `estatus` enum('activo','inactivo') NOT NULL DEFAULT 'activo',
  PRIMARY KEY (`id_login`),
  UNIQUE KEY `username` (`user_name`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla `login_user`
--

INSERT INTO `login_user` (`id_login`, `id_usuario`, `user_name`, `password`, `salt`, `first_name`, `last_name`, `id_rol`, `id_recaudacion`, `email`, `estatus`) VALUES
(2, 1, 'usuario@insha.com', '343b2840b75797ecc9f1b53df18be3cee0fd4c2d97a45555624fc8d6784d7fc09e45224fea07a7829aafeb21f50afc667bd6ae2c3f2ad35f18561d6f3610f84f', '6b8ec8a25e04bfdce50197fe5897cf30dece37d82920d8eb5ffc800507aa95618e045b1074a6dd4e2b65e20d213b481c957cb2d45a4977f6466475ff64e6d8dc', 'Usuario ', 'INSHA ', 5, 0, 'usuario@insha.com', 'activo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `persona`
--

CREATE TABLE IF NOT EXISTS `persona` (
  `idPersona` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idResponseWSFTOFRM` int(10) unsigned NOT NULL DEFAULT '0',
  `primerAp` varchar(50) NOT NULL,
  `segundoAp` varchar(50) NOT NULL,
  `nombres` varchar(50) NOT NULL,
  `segundoNombre` varchar(50) NOT NULL,
  `fechaNacimiento` date NOT NULL,
  `genero` enum('M','H') NOT NULL,
  `CURP` varchar(18) NOT NULL,
  `email` varchar(100) NOT NULL,
  `codigoPais` varchar(3) NOT NULL,
  `ladaTel` varchar(3) NOT NULL,
  `telCasa` varchar(10) NOT NULL,
  `telMovil` varchar(10) NOT NULL,
  `estadoCivil` int(10) NOT NULL,
  `RFC` varchar(10) NOT NULL,
  `homoclave` varchar(3) NOT NULL,
  `nacionalidad` enum('mex','ext') NOT NULL DEFAULT 'mex',
  `nacCveEnt` varchar(2) NOT NULL,
  `nacCveMun` varchar(3) NOT NULL,
  `nacCveLoc` varchar(4) NOT NULL,
  `enrolamientoBiometricoHuellas` enum('s','n') NOT NULL DEFAULT 'n',
  `enrolamientoBiometricoIris` enum('s','n') NOT NULL DEFAULT 'n',
  `enrolamientoBiometricoRostro` enum('s','n') NOT NULL DEFAULT 'n',
  `firma` enum('s','n') NOT NULL DEFAULT 'n',
  `problematica` enum('s','n') NOT NULL DEFAULT 'n',
  `completa` enum('s','n') NOT NULL DEFAULT 'n',
  `CURPProblematico` varchar(18) NOT NULL,
  `AstraSubjectId` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`idPersona`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=321 ;

--
-- Volcado de datos para la tabla `persona`
--

INSERT INTO `persona` (`idPersona`, `idResponseWSFTOFRM`, `primerAp`, `segundoAp`, `nombres`, `segundoNombre`, `fechaNacimiento`, `genero`, `CURP`, `email`, `codigoPais`, `ladaTel`, `telCasa`, `telMovil`, `estadoCivil`, `RFC`, `homoclave`, `nacionalidad`, `nacCveEnt`, `nacCveMun`, `nacCveLoc`, `enrolamientoBiometricoHuellas`, `enrolamientoBiometricoIris`, `enrolamientoBiometricoRostro`, `firma`, `problematica`, `completa`, `CURPProblematico`, `AstraSubjectId`) VALUES
(1, 533, 'MARTINEZ ', 'MENESES', 'JOEL EDUARDO', '', '1978-05-22', 'H', 'MAMJ780522HDFRNL00', '', '', '', '', '', 0, '', '', 'mex', '', '', '', 's', 's', 'n', 'n', 'n', 'n', '', 0),
(320, 741, 'PACHECO ', 'SALINAS', 'JOSE ANTONIO', '', '1983-07-27', 'H', 'PASA830727HGTCLN06', '', '', '', '', '', 0, '', '', 'mex', '', '', '', 's', 's', 's', 's', 'n', 'n', '', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `persona_biometrico`
--

CREATE TABLE IF NOT EXISTS `persona_biometrico` (
  `idPersonaBiometrico` int(11) NOT NULL AUTO_INCREMENT,
  `idPersona` int(10) NOT NULL,
  `idBiometrico` int(10) NOT NULL,
  `archivo` varchar(150) NOT NULL,
  `estatusCaptura` enum('disponible','nodisponible','dedovenda') NOT NULL DEFAULT 'disponible',
  `idOperacionAutoriza` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`idPersonaBiometrico`),
  KEY `idPersona` (`idPersona`),
  KEY `idBiometrico` (`idBiometrico`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
