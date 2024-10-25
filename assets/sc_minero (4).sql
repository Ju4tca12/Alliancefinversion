-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 03-10-2024 a las 00:45:15
-- Versión del servidor: 8.0.31
-- Versión de PHP: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `sc_minero`
--

DELIMITER $$
--
-- Procedimientos
--
DROP PROCEDURE IF EXISTS `data`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `data` ()   BEGIN
DECLARE usuarios int;
DECLARE aprendiz int;
DECLARE programas int;
DECLARE fichas int;
DECLARE reintegros int;

SELECT COUNT(*) INTO usuarios FROM usuario;
SELECT COUNT(*) INTO aprendiz FROM aprendiz;
SELECT COUNT(*) INTO programas FROM programa;
SELECT COUNT(*) INTO fichas FROM ficha;
SELECT COUNT(*) INTO reintegros FROM reintegro;



SELECT usuarios,aprendiz, programas, fichas , reintegros;

END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `aprendiz`
--

DROP TABLE IF EXISTS `aprendiz`;
CREATE TABLE IF NOT EXISTS `aprendiz` (
  `id_apre` int NOT NULL AUTO_INCREMENT,
  `nomb_apre` varchar(100) NOT NULL,
  `apell_apre` varchar(100) NOT NULL,
  `tip_doc` enum('Seleccione','CC','TI') CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `doc_apre` varchar(20) NOT NULL,
  `horas` int NOT NULL,
  `programa_nom` int NOT NULL,
  `num_fich` int NOT NULL,
  `correo` varchar(1000) NOT NULL,
  `descrip` varchar(1000) NOT NULL,
  `fecha_rep` datetime DEFAULT CURRENT_TIMESTAMP,
  `des_novedad` int DEFAULT NULL,
  `estado_apren` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `usuario_id` int NOT NULL,
  `fecha_not` datetime DEFAULT NULL,
  `notificado` tinyint(1) DEFAULT '0',
  `aprob` enum('seleccione','aprobar','rechazar') CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  PRIMARY KEY (`id_apre`),
  KEY `num_fich` (`num_fich`),
  KEY `usuario_id` (`usuario_id`)
) ENGINE=InnoDB AUTO_INCREMENT=345367 DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `aprendiz`
--

INSERT INTO `aprendiz` (`id_apre`, `nomb_apre`, `apell_apre`, `tip_doc`, `doc_apre`, `horas`, `programa_nom`, `num_fich`, `correo`, `descrip`, `fecha_rep`, `des_novedad`, `estado_apren`, `usuario_id`, `fecha_not`, `notificado`, `aprob`) VALUES
(10, 'prueba cinco', 'cortes|', '', '987654321', 100, 1, 1, 'jtel@gmail.com', 'no volvio a formacion', '0000-00-00 00:00:00', 1, '4', 11, NULL, 0, 'seleccione'),
(12, 'jaun', 'uhbdsod', '', '7493943743', 988, 1, 1, 'jtel@gmail.com', 'no volvio a formacion', '0000-00-00 00:00:00', 11, '5', 10, NULL, 0, 'seleccione'),
(17, 'Angela ', 'Neita', '', '1023847543', 355, 1, 5, 'angelaneita2015@gmail.com', 'No volvió a la formación a la formación se le escribió dijo que quería el retiro voluntario, se indico tramite de novedad en Sofia plus. ', '0000-00-00 00:00:00', 3, '1', 10, '2024-09-23 00:00:00', 1, 'rechazar'),
(21, 'Pruebas estudiante adso', 'tellez ochoa', 'CC', '1023035333', 323, 1, 5, 'jtellezochoa11@gmail.com', 'El estudiante se fue para europa conn su ma que el ofrecio alejarse las pukgas que estaba en su coebrtiso por la cual se fue para alemania y esta contento ', '2024-07-31 14:14:50', 3, '4', 9, '2024-09-10 00:00:00', 1, 'rechazar'),
(24, 'jerry lassi', 'tellez ochoa', '', '1723737011', 323, 4, 1, 'lassijerry@gmail.com', 'El estudiante se fue para europa conn su ma que el ofrecio alejarse las pukgas que estaba en su coebrtiso por la cual se fue para alemania y esta contento ', '2024-07-31 14:14:50', 1, '4', 9, NULL, 0, 'seleccione'),
(25, 'Estafania Collazos', 'Collazos', 'CC', '1023349353', 23, 1, 5, 'lauracubides0126@gmail.com', 'El aprendiz no volvio a la formacio9n ', '2024-08-20 15:23:03', 3, '4', 12, '2024-08-29 00:00:00', 1, 'rechazar'),
(345, 'Pruebas estudiante adso', 'ochoa Tellez', 'TI', '1023035333', 12, 1, 5, 'jtellezochoa11@gmail.com', 'El estudiante se fue para europa conn su ma que el ofrecio alejarse las pukgas que estaba en su coebrtiso por la cual se fue para alemania y esta contento ', '2024-07-31 14:14:50', 3, '4', 9, '2024-09-10 00:00:00', 0, 'aprobar'),
(678, 'jaun', 'uhbdsod', '', '749394372', 988, 1, 1, 'jtel@gmail.com', 'no volvio a formacion', '0000-00-00 00:00:00', 11, '5', 10, NULL, 0, 'seleccione'),
(3232, 'Daniel Pinilla', 'Pinilla ', '', '876543212', 100, 1, 5, 'danielpinillawh832@gmail.com', 'no volvio a formacion', '2024-09-03 08:12:13', 2, '4', 9, NULL, NULL, ''),
(3656, 'juan', 'tellez', '', '93746463', 29, 1, 2, 'juantellez@kreaftware.com', 'no volvio a formacion el aprendiz', '2024-09-04 22:08:05', 2, '4', 10, '2024-08-29 00:00:00', 1, ''),
(23423, 'holaaa', 'tellez ochoa', '', '172373700', 323, 1, 4, 'lassijerry@gmail.com', 'El estudiante se fue para europa conn su ma que el ofrecio alejarse las pukgas que estaba en su coebrtiso por la cual se fue para alemania y esta contento ', '2024-07-31 14:14:50', 1, '4', 9, NULL, 0, 'seleccione'),
(345346, 'Angela ', 'Neita', '', '102384753', 355, 1, 5, 'angelaneita2015@gmail.com', 'No volvió a la formación a la formación se le escribió dijo que quería el retiro voluntario, se indico tramite de novedad en Sofia plus. ', '2024-09-08 22:08:05', 3, '4', 10, NULL, NULL, 'aprobar'),
(345347, 'Pruebas estudiante adso', 'tellez ochoa', '', '1023035', 323, 1, 3, 'jtellezochoa11@gmail.com', 'El estudiante se fue para europa conn su ma que el ofrecio alejarse las pukgas que estaba en su coebrtiso por la cual se fue para alemania y esta contento ', '2024-07-31 14:14:50', 3, '2', 9, '2024-09-03 00:00:00', 0, 'aprobar'),
(345348, 'jerry lassi', 'tellez ochoa', '', '17237', 323, 4, 1, 'lassijerry@gmail.com', 'El estudiante se fue para europa conn su ma que el ofrecio alejarse las pukgas que estaba en su coebrtiso por la cual se fue para alemania y esta contento ', '2024-07-31 14:14:50', 1, '4', 9, NULL, 0, 'seleccione'),
(345349, 'juan', 'telllez', '', '10233', 23, 1, 4, 'lauracubides0126@gmail.com', 'El aprendiz no volvio a la formacio9n ', '2024-08-20 15:23:03', 3, '4', 12, NULL, 0, 'rechazar'),
(345350, 'Pruebas estudiante adso', 'tellez ochoa', '', '102303534', 323, 1, 3, 'jtellezochoa11@gmail.com', 'El estudiante se fue para europa conn su ma que el ofrecio alejarse las pukgas que estaba en su coebrtiso por la cual se fue para alemania y esta contento ', '2024-07-31 14:14:50', 3, '2', 9, NULL, 0, 'seleccione'),
(345351, 'holaaa', 'tellez ochoa', '', '172373700', 323, 1, 4, 'lassijerry@gmail.com', 'El estudiante se fue para europa conn su ma que el ofrecio alejarse las pukgas que estaba en su coebrtiso por la cual se fue para alemania y esta contento ', '2024-07-31 14:14:50', 1, '4', 9, NULL, 0, 'seleccione'),
(345354, 'Jerry', 'Tellez', '', '999999999', 12, 5, 1, 'kreaftwareinnovative@gmail.com', 'No volvio a morder jugetes en clase', '2024-09-15 18:06:03', 2, '1', 12, '2024-09-15 00:00:00', 1, 'seleccione'),
(345355, 'gustavo ', 'tellez', '', '79324684', 133, 5, 2, 'jtellezochoa11@gmail.com', 'no volvio a formacion', '2024-09-19 12:39:06', 3, '1', 12, '2024-09-26 00:00:00', 1, 'aprobar'),
(345356, 'Gina', 'Epellido', 'Seleccione', '2039923', 45, 1, 5, 'porrasgina48@gmail.com', 'no volvio a formacion ', '2024-09-23 08:46:13', 2, '1', 12, '2024-09-23 00:00:00', 0, 'aprobar'),
(345357, 'sara ', 'saavedra', '', '6328649793', 55, 1, 5, 'saracrisroa09@gmail.com', 'isghfojsbh bn', '2024-09-26 09:12:01', 4, '1', 10, NULL, NULL, 'aprobar'),
(345358, 'pepita', 'perezq', '', '8855555', 120, 1, 4, 'jtellezochoa11@gmail.com', 'no olvio', '2024-09-26 09:37:13', 4, '1', 12, '2024-09-26 00:00:00', 1, 'aprobar'),
(345359, 'nelly', 'torres ', 'Seleccione', '655555', 40, 1, 5, 'nellycamy@hotmail.com', 'no volvio ', '2024-09-26 09:45:15', 4, '1', 12, NULL, NULL, 'aprobar'),
(345360, 'Daniel ', 'Fernandez', 'Seleccione', '5598255', 80, 1, 5, 'dfernedez_1@yahoo.com', 'no olvio, no se reporto', '2024-09-26 10:09:10', 2, '1', 12, '2024-09-26 00:00:00', 1, 'aprobar'),
(345361, 'Jorge', 'Rodriguez', '', '6666657512', 80, 1, 1, 'jtellezochoa11@gmail.com', 'no volvió, no se reporto', '2024-09-26 11:00:08', 4, '1', 12, '2024-09-26 00:00:00', 1, 'aprobar'),
(345362, 'dayana ', 'Perez', 'Seleccione', '12366555', 80, 1, 5, 'jtellezochoa11@gmail.com', 'no volvio, no se reporto', '2024-09-26 11:21:37', 2, '4', 12, '2024-09-26 00:00:00', 1, 'aprobar'),
(345363, 'Sergio e Jesus ', 'Santa', '', '3453240734', 80, 5, 3, 'ssantab@sena.edu.co', 'No volvio formacion', '2024-09-27 11:24:52', 4, '1', 12, '2024-09-27 00:00:00', 1, 'aprobar'),
(345364, 'Juan', 'tellez', '', '102303666', 655, 5, 1, 'jtellezochoa11@gmail.com', 'no volvio a la formasicon', '2024-09-27 13:04:18', 2, '1', 12, '2024-09-27 00:00:00', 1, 'aprobar'),
(345365, 'keiki', 'murasigeu', '', '1023789987', 584, 1, 2, 'lauracubides0126@gmail.com', 'no regreso a formación', '2024-10-02 10:10:32', 2, '1', 12, '2024-10-02 10:19:31', 1, 'aprobar'),
(345366, 'ginna', 'Porras', '', '234567890', 65, 5, 2, 'porrasgina48@gmail.com', 'No volvió a formación ', '2024-10-02 11:23:23', 2, '1', 11, NULL, NULL, 'aprobar');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado_apre`
--

DROP TABLE IF EXISTS `estado_apre`;
CREATE TABLE IF NOT EXISTS `estado_apre` (
  `id_estado` int NOT NULL AUTO_INCREMENT,
  `cod_estado` int NOT NULL,
  `estado_apren` varchar(250) NOT NULL,
  PRIMARY KEY (`id_estado`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `estado_apre`
--

INSERT INTO `estado_apre` (`id_estado`, `cod_estado`, `estado_apren`) VALUES
(1, 0, 'Formación'),
(2, 0, 'Cencelado'),
(3, 0, 'Retiro voluntario'),
(4, 0, 'Aplazado'),
(5, 0, 'Condicionado'),
(6, 2335, 'Seleccione');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ficha`
--

DROP TABLE IF EXISTS `ficha`;
CREATE TABLE IF NOT EXISTS `ficha` (
  `ficha_id` int NOT NULL AUTO_INCREMENT,
  `num_fich` int NOT NULL,
  `usuario_id` int NOT NULL,
  `fecha_ini` date NOT NULL,
  `fecha_fin` date NOT NULL,
  `actividad` enum('seleccione','activo','inactivo') CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  PRIMARY KEY (`ficha_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `ficha`
--

INSERT INTO `ficha` (`ficha_id`, `num_fich`, `usuario_id`, `fecha_ini`, `fecha_fin`, `actividad`) VALUES
(1, 2338894, 11, '0000-00-00', '0000-00-00', 'activo'),
(2, 1803586, 9, '2024-07-24', '2026-07-24', 'inactivo'),
(3, 977797, 9, '0000-00-00', '0000-00-00', 'activo'),
(4, 967675, 10, '0000-00-00', '0000-00-00', 'activo'),
(5, 2024, 9, '0000-00-00', '0000-00-00', NULL),
(6, 2026, 9, '0000-00-00', '0000-00-00', NULL),
(7, 2024, 9, '0000-00-00', '0000-00-00', NULL),
(11, 0, 11, '0000-00-00', '0000-00-00', 'activo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mensajes`
--

DROP TABLE IF EXISTS `mensajes`;
CREATE TABLE IF NOT EXISTS `mensajes` (
  `idmensaje` int NOT NULL AUTO_INCREMENT,
  `idremitente` int NOT NULL,
  `iddestinatario` int NOT NULL,
  `mensaje` text CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci NOT NULL,
  `fecha` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idmensaje`),
  KEY `idremitente` (`idremitente`),
  KEY `iddestinatario` (`iddestinatario`)
) ENGINE=InnoDB AUTO_INCREMENT=86 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

--
-- Volcado de datos para la tabla `mensajes`
--

INSERT INTO `mensajes` (`idmensaje`, `idremitente`, `iddestinatario`, `mensaje`, `fecha`) VALUES
(51, 9, 12, 'Hola', '2024-09-13 14:00:16'),
(52, 12, 9, 'hola', '2024-09-13 14:00:45'),
(53, 9, 12, 'Por favor reportar aprendices ene deserción...  a mas tardar el dia martes.   ', '2024-09-13 14:04:14'),
(54, 12, 9, 'hola', '2024-09-13 14:04:19'),
(55, 12, 9, 'okey perfecto mañana hago el reporte, gracias\r\n ', '2024-09-13 14:04:40'),
(56, 9, 12, 'Por favor reportar aprendices ene deserción...  a mas tardar el dia martes.   ', '2024-09-13 14:04:43'),
(57, 9, 12, 'hola', '2024-09-13 14:05:04'),
(58, 12, 9, 'ya los subi', '2024-09-13 14:51:48'),
(59, 9, 12, 'Instructora por favor reportar el aprendiz urgentemente, cargar sus horas', '2024-09-15 11:18:37'),
(60, 9, 12, 'holaaa que paso aprendiz', '2024-09-19 21:26:22'),
(61, 9, 12, 'Hola\r\n', '2024-09-23 15:35:09'),
(62, 9, 12, 'Hola\r\n', '2024-09-23 15:35:30'),
(63, 9, 12, 'Hola\r\n', '2024-09-23 15:38:19'),
(64, 9, 12, 'holaaa\r\n', '2024-09-26 08:46:43'),
(65, 9, 12, 'hoplssss pdnbbvm ', '2024-09-26 08:56:28'),
(66, 9, 12, 'holaa a yefer no volvio a formacion', '2024-09-26 09:03:19'),
(67, 12, 9, 'Okey ya saco del sistema', '2024-09-26 09:03:37'),
(68, 9, 10, 'holaaa\r\n', '2024-09-26 09:21:23'),
(69, 9, 12, 'holaaa como estas', '2024-09-26 09:25:45'),
(70, 12, 9, 'holla\r\n', '2024-09-26 09:26:07'),
(71, 9, 12, 'Hola por favor aprendices que no volvieron a formacion', '2024-09-26 09:35:39'),
(72, 12, 9, 'pepeita prez 123455 no ovlio', '2024-09-26 09:36:06'),
(73, 9, 12, 'hols jusnito si volvio a formacion', '2024-09-26 10:18:23'),
(74, 12, 9, 'no volvio a la formacion sacarla del sistema', '2024-09-26 10:18:44'),
(75, 12, 9, 'Buen dia reporte un aprendiz', '2024-09-26 11:00:45'),
(76, 9, 12, 'okey, recibido', '2024-09-26 11:01:16'),
(77, 9, 12, 'Hola dayanaa si volvio a formacion', '2024-09-26 11:19:45'),
(78, 12, 9, 'no no volvio', '2024-09-26 11:20:01'),
(79, 9, 12, 'Hola isntructor, aprendiz a formación', '2024-09-27 11:20:15'),
(80, 12, 9, 'no no volvio', '2024-09-27 11:20:36'),
(81, 12, 9, 'Buen día, \r\n\r\nTeniendo presente la inasistencia continua del aprendiz keiki, se realiza reporte para iniciar proceso de deserción', '2024-10-02 10:16:04'),
(82, 9, 12, 'okey\r\n', '2024-10-02 10:18:00'),
(83, 9, 10, 'holaaa\r\n', '2024-10-02 11:30:40'),
(84, 9, 10, 'validar', '2024-10-02 11:30:46'),
(85, 12, 9, 'holaaaa, como  estas', '2024-10-02 11:31:27');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `novedad`
--

DROP TABLE IF EXISTS `novedad`;
CREATE TABLE IF NOT EXISTS `novedad` (
  `id_novedad` int NOT NULL AUTO_INCREMENT,
  `des_novedad` varchar(450) NOT NULL,
  `cod_novedad` int DEFAULT NULL,
  PRIMARY KEY (`id_novedad`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `novedad`
--

INSERT INTO `novedad` (`id_novedad`, `des_novedad`, `cod_novedad`) VALUES
(2, 'FORMACIÓN\r\n', 123),
(3, 'RETIRO VOLUNTARIO', 543344),
(4, 'des_novedad', 2121312);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `programa`
--

DROP TABLE IF EXISTS `programa`;
CREATE TABLE IF NOT EXISTS `programa` (
  `id_programa` int NOT NULL AUTO_INCREMENT,
  `programa_nom` varchar(250) NOT NULL,
  `usuario_id` int NOT NULL,
  PRIMARY KEY (`id_programa`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `programa`
--

INSERT INTO `programa` (`id_programa`, `programa_nom`, `usuario_id`) VALUES
(1, 'adso', 9),
(3, 'sst', 9),
(4, 'maquinaria', 9),
(5, 'Quimica aplicada a la industria. ', 9);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reintegro`
--

DROP TABLE IF EXISTS `reintegro`;
CREATE TABLE IF NOT EXISTS `reintegro` (
  `cod_reintegro` int NOT NULL AUTO_INCREMENT,
  `doc_reintegro` int NOT NULL,
  `nom_rein` varchar(2000) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `fech_rein` date NOT NULL,
  `ficha_anterior` int NOT NULL,
  `ficha_reinte` int NOT NULL,
  PRIMARY KEY (`cod_reintegro`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `reintegro`
--

INSERT INTO `reintegro` (`cod_reintegro`, `doc_reintegro`, `nom_rein`, `fech_rein`, `ficha_anterior`, `ficha_reinte`) VALUES
(1, 1029299283, 'juan ', '2024-08-08', 2900003, 2900004);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

DROP TABLE IF EXISTS `rol`;
CREATE TABLE IF NOT EXISTS `rol` (
  `idrol` int NOT NULL AUTO_INCREMENT,
  `rol` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci NOT NULL,
  PRIMARY KEY (`idrol`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`idrol`, `rol`) VALUES
(1, 'Administrador'),
(2, 'Instructor'),
(3, 'apoyo'),
(4, 'Mesa_directiva');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

DROP TABLE IF EXISTS `usuario`;
CREATE TABLE IF NOT EXISTS `usuario` (
  `idusuario` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci NOT NULL,
  `correo` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci NOT NULL,
  `usuario` varchar(20) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci NOT NULL,
  `clave` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci NOT NULL,
  `rol` int NOT NULL,
  PRIMARY KEY (`idusuario`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`idusuario`, `nombre`, `correo`, `usuario`, `clave`, `rol`) VALUES
(1, 'Seleccione', '', '', '', 2),
(6, 'Maria Perez Miranda', 'maria@gmail.com', 'maria', '827ccb0eea8a706c4c34a16891f84e7b', 3),
(9, 'Juan  Téllez', 'pepe@kreaftware.com', 'Juan', '829c943f10aaa5f9ace9440fe56bdebc', 1),
(10, 'isntr1', 'isntr1@krea.com', 'isntr1', '827ccb0eea8a706c4c34a16891f84e7b', 2),
(11, 'isntr2', 'jutell@solo.com', 'isntr2', '827ccb0eea8a706c4c34a16891f84e7b', 2),
(12, 'laura cubides', 'laura@soy.laura.com', 'laura0128', '9d5484a5b9998977a600ab9505f08eba', 2),
(13, 'apoyo', 'apo@sena.com', 'apoyoone', '4b6d474e9035bf00c9a1dbccc36450fb', 3),
(14, 'natali', 'nata@sena.edu.co', 'nata12', '285fa51c4a53fb0d1b8a4ce89c672478', 1);

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `aprendiz`
--
ALTER TABLE `aprendiz`
  ADD CONSTRAINT `aprendiz_ibfk_1` FOREIGN KEY (`num_fich`) REFERENCES `ficha` (`ficha_id`),
  ADD CONSTRAINT `aprendiz_ibfk_2` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`idusuario`);

--
-- Filtros para la tabla `mensajes`
--
ALTER TABLE `mensajes`
  ADD CONSTRAINT `mensajes_ibfk_1` FOREIGN KEY (`idremitente`) REFERENCES `usuario` (`idusuario`),
  ADD CONSTRAINT `mensajes_ibfk_2` FOREIGN KEY (`iddestinatario`) REFERENCES `usuario` (`idusuario`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
