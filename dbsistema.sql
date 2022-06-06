-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 23, 2021 at 09:07 AM
-- Server version: 10.4.20-MariaDB
-- PHP Version: 7.3.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dbpventa`
--
CREATE DATABASE IF NOT EXISTS `dbpventa`;
USE `dbpventa`;
-- --------------------------------------------------------

--
-- Table structure for table `bitacora`
--

CREATE TABLE `bitacora` (
  `idBitacora` int(11) NOT NULL AUTO_INCREMENT,
  `idUsuario` int(11) NOT NULL,
  `fecha` datetime NOT NULL,
  `accion` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  PRIMARY KEY (`idBitacora`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categoria`
--

CREATE TABLE `categoria` (
  `idCateogira` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(30) COLLATE utf8_spanish2_ci NOT NULL,
  `descripcion` varchar(250) COLLATE utf8_spanish2_ci NOT NULL,
  `imagen` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`idCateogira`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

INSERT INTO `categoria` VALUES
(1, 'Alimentos','Articulos de Sobrevivencia','comida.jpg',1),
(2, 'Prendas de Vestir','Articulos personales','ropa.jpg',1),
(3, 'Libreria','Articulos para estudio','libreria.jpg',1),
(4, 'Electrodomesticos','Cosas para el hogar','electro.jpg',1);
-- --------------------------------------------------------

--
-- Table structure for table `cliente`
--

CREATE TABLE `cliente` (
  `idCliente` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `Apellido` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `FechaNacimiento` date,
  `Correo` varchar(45) COLLATE utf8_spanish2_ci,
  `Telefono` int(8) COLLATE utf8_spanish2_ci,
  `Direccion` varchar(150) COLLATE utf8_spanish2_ci,
  `NIT` varchar(8) COLLATE utf8_spanish2_ci NOT NULL,
   `estado` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`idCliente`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

INSERT INTO `cliente` VALUES
(1, 'Bryan','Aguire','2021-10-07','bryanorlando-98@hotmail.com','12345678','Mi casa','6824796',1),
(2, 'Bryana','Aguire','2021-10-07','bryanorlando-98@hotmail.com','12345679','Mi casa','6824797',1),
(3, 'C/F','C/F','','','','','C/F',1);

-- --------------------------------------------------------

--
-- Table structure for table `compradetalle`
--
CREATE TABLE `tipoMoneda`(
	`idTipoMoneda` int(2) NOT NULL AUTO_INCREMENT,
    `moneda` varchar(45) NOT NULL,
    `simbolo` varchar(1) NOT NULL,
    `tipoCambio` double NOT NULL,
    `estado` tinyint(1) NOT NULL DEFAULT '1',
    PRIMARY KEY (`idTipoMoneda`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;
INSERT INTO `tipoMoneda` VALUES
(1, 'Quetzal','Q',1,1),
(2, 'DÃ³lar','$',7.5,1);

CREATE TABLE `compradetalle` (
  `idProducto` int(11) NOT NULL,
  `idCompraEncabezado` int(11) NOT NULL,
  `cantidad` int(5) COLLATE utf8_spanish2_ci NOT NULL,
  `precio` double,
  PRIMARY KEY (`idProducto`,`idCompraEncabezado`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

INSERT INTO `compradetalle` (`idProducto`, `idCompraEncabezado`, `cantidad`) VALUES
(9, 1, 4),
(9, 2, 5),
(2, 3, 3),
(1, 4, 10),
(8, 5, 2),
(10, 6, 5),
(4, 7, 1),
(1, 8, 9),
(6, 9, 5),
(1, 10, 2),
(8, 11, 4),
(1, 12, 2),
(8, 13, 8),
(5, 14, 7),
(2, 15, 9),
(5, 16, 7),
(2, 17, 4),
(9, 18, 8),
(9, 19, 6),
(4, 20, 1),
(8, 21, 1),
(4, 22, 8),
(3, 23, 3),
(2, 24, 3),
(7, 25, 4),
(2, 26, 3),
(8, 27, 5),
(5, 28, 6),
(9, 29, 6),
(3, 30, 1),
(2, 31, 3),
(5, 32, 10),
(2, 33, 3),
(3, 34, 2),
(3, 35, 1),
(1, 36, 8),
(5, 37, 8),
(7, 38, 2),
(10, 39, 1),
(3, 40, 3),
(7, 41, 2),
(3, 42, 2),
(9, 43, 4),
(1, 44, 7),
(8, 45, 3),
(10, 46, 8),
(9, 47, 7),
(2, 48, 77),
(9, 49, 10),
(1, 50, 9),
(7, 51, 5),
(8, 52, 9),
(2, 53, 2),
(3, 54, 7),
(8, 55, 10),
(2, 56, 3),
(10, 57, 9),
(10, 58, 7),
(4, 59, 10),
(3, 60, 9),
(5, 61, 8),
(10, 62, 2),
(2, 63, 9),
(8, 64, 10),
(7, 65, 7),
(10, 66, 7),
(4, 67, 4),
(3, 68, 9),
(4, 69, 7),
(8, 70, 3),
(3, 71, 2),
(8, 72, 10),
(3, 73, 7),
(5, 74, 10),
(5, 75, 6),
(9, 76, 8),
(4, 77, 6),
(9, 78, 2),
(6, 79, 5),
(3, 80, 5),
(10, 81, 7),
(8, 82, 10),
(1, 83, 9),
(1, 84, 8),
(5, 85, 5),
(9, 86, 2),
(3, 87, 9),
(10, 88, 2),
(6, 89, 3),
(7, 90, 5),
(8, 91, 1),
(8, 92, 2),
(1, 93, 10),
(5, 94, 8),
(7, 95, 2),
(8, 96, 10),
(5, 97, 7),
(3, 98, 7),
(3, 99, 5),
(6, 100, 9),
(3, 101, 2),
(4,102,26),
(1,103,27),
(2,104,1),
(3,105,24),
(6,106,1),
(7,107,9),
(8,108,1),
(1,109,8),
(2,110,5),
(5,111,20),
(7,112,18),
(8,113,36),
(10,114,14),
(6,101,31),
(1, 130, 9),
(5, 130, 34),
(7, 130, 13),
(8, 130, 6),
(10, 130, 19),
(2, 131, 47),
(4, 131, 25),
(8, 131, 11),
(9, 131, 4);

-- --------------------------------------------------------

--
-- Table structure for table `compraencabezado`
--

CREATE TABLE `compraencabezado` (
  `idCompraEncabezado` int(11) NOT NULL AUTO_INCREMENT,
  `fecha` datetime NOT NULL,
  `idProveedor` int(11) NOT NULL,
  `total` float NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `idTienda` int(11) NOT NULL,
  `idTipoMoneda` int(2) NOT NULL,
  `impuesto` double NOT NULL,
  `estado` tinyint COLLATE utf8_spanish2_ci NOT NULL DEFAULT '1',
  PRIMARY KEY (idCompraEncabezado)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;
INSERT INTO compraencabezado VALUES
(1, '2021-04-02', 1, 1121.55, 1, 1, 1, 12, 1),
(2, '2020-11-10', 1, 1233.43, 1, 1, 1, 12, 1),
(3, '2021-04-03', 1, 1025.1, 1, 1, 1, 12, 1),
(4, '2021-11-01', 1, 1340.12, 1, 1, 1, 12, 1),
(5, '2021-02-03', 1, 1171.57, 1, 1, 1, 12, 1),
(6, '2021-06-30', 1, 1136.07, 1, 1, 1, 12, 1),
(7, '2020-12-31', 1, 1486.69, 1, 1, 1, 12, 1),
(8, '2021-11-02', 1, 1060.05, 1, 1, 1, 12, 1),
(9, '2020-10-18', 1, 1185.39, 1, 1, 1, 12, 1),
(10, '2021-02-04', 1, 1380.82, 1, 1, 1, 12, 1),
(11, '2021-04-10', 1, 1304.66, 1, 1, 1, 12, 1),
(12, '2021-08-05', 1, 1322.31, 1, 1, 1, 12, 1),
(13, '2021-08-05', 1, 1113.32, 1, 1, 1, 12, 1),
(14, '2021-01-19', 1, 1100.56, 1, 1, 1, 12, 1),
(15, '2020-12-17', 1, 1360.06, 1, 1, 1, 12, 1),
(16, '2021-06-14', 1, 1469.09, 1, 1, 1, 12, 1),
(17, '2021-08-09', 1, 1057.43, 1, 1, 1, 12, 1),
(18, '2021-04-17', 1, 1064.26, 1, 1, 1, 12, 1),
(19, '2021-02-16', 1, 1015.76, 1, 1, 1, 12, 1),
(20, '2021-05-16', 1, 1149.06, 1, 1, 1, 12, 1),
(21, '2021-07-21', 1, 1208.17, 1, 1, 1, 12, 1),
(22, '2021-08-21', 1, 1302.72, 1, 1, 1, 12, 1),
(23, '2020-10-14', 1, 1059.28, 1, 1, 1, 12, 1),
(24, '2021-04-04', 1, 1350.64, 1, 1, 1, 12, 1),
(25, '2020-12-20', 1, 1360.77, 1, 1, 1, 12, 1),
(26, '2021-03-11', 1, 1221.17, 1, 1, 1, 12, 1),
(27, '2021-02-28', 1, 1091.81, 1, 1, 1, 12, 1),
(28, '2021-03-12', 1, 1413.19, 1, 1, 1, 12, 1),
(29, '2020-11-21', 1, 1437.61, 1, 1, 1, 12, 1),
(30, '2021-09-04', 1, 1093.07, 1, 1, 1, 12, 1),
(31, '2021-01-11', 1, 1198.03, 1, 1, 1, 12, 1),
(32, '2021-03-06', 1, 1230.54, 1, 1, 1, 12, 1),
(33, '2021-02-05', 1, 1024.13, 1, 1, 1, 12, 1),
(34, '2021-06-05', 1, 1287.38, 1, 1, 1, 12, 1),
(35, '2021-08-07', 1, 1161.22, 1, 1, 1, 12, 1),
(36, '2021-01-29', 1, 1271.49, 1, 1, 1, 12, 1),
(37, '2020-11-16', 1, 1351.46, 1, 1, 1, 12, 1),
(38, '2021-08-24', 1, 1322.89, 1, 1, 1, 12, 1),
(39, '2021-08-24', 1, 1265.04, 1, 1, 1, 12, 1),
(40, '2021-10-02', 1, 1161.73, 1, 1, 1, 12, 1),
(41, '2021-05-29', 1, 1308.0, 1, 1, 1, 12, 1),
(42, '2021-09-05', 1, 1126.11, 1, 1, 1, 12, 1),
(43, '2021-09-06', 1, 1449.05, 1, 1, 1, 12, 1),
(44, '2021-05-22', 1, 1461.55, 1, 1, 1, 12, 1),
(45, '2021-06-23', 1, 1240.73, 1, 1, 1, 12, 1),
(46, '2021-01-31', 1, 1296.29, 1, 1, 1, 12, 1),
(47, '2021-01-22', 1, 1319.84, 1, 1, 1, 12, 1),
(48, '2021-11-01', 1, 1292.81, 1, 1, 1, 12, 1),
(49, '2021-07-16', 1, 1482.09, 1, 1, 1, 12, 1),
(50, '2020-12-05', 1, 1409.56, 1, 1, 1, 12, 1),
(51, '2021-08-24', 1, 1112.48, 1, 1, 1, 12, 1),
(52, '2020-10-25', 1, 1425.65, 1, 1, 1, 12, 1),
(53, '2021-01-20', 1, 1401.1, 1, 1, 1, 12, 1),
(54, '2021-08-17', 1, 1183.36, 1, 1, 1, 12, 1),
(55, '2021-03-27', 1, 1198.49, 1, 1, 1, 12, 1),
(56, '2020-12-24', 1, 1275.32, 1, 1, 1, 12, 1),
(57, '2020-12-08', 1, 1428.47, 1, 1, 1, 12, 1),
(58, '2021-03-14', 1, 1037.49, 1, 1, 1, 12, 1),
(59, '2021-01-04', 1, 1017.56, 1, 1, 1, 12, 1),
(60, '2021-08-01', 1, 1326.64, 1, 1, 1, 12, 1),
(61, '2021-03-19', 1, 1186.17, 1, 1, 1, 12, 1),
(62, '2020-11-30', 1, 1157.77, 1, 1, 1, 12, 1),
(63, '2020-11-07', 1, 1498.19, 1, 1, 1, 12, 1),
(64, '2021-04-27', 1, 1000.69, 1, 1, 1, 12, 1),
(65, '2021-08-26', 1, 1121.96, 1, 1, 1, 12, 1),
(66, '2021-10-01', 1, 1491.52, 1, 1, 1, 12, 1),
(67, '2021-02-14', 1, 1421.89, 1, 1, 1, 12, 1),
(68, '2020-12-14', 1, 1237.28, 1, 1, 1, 12, 1),
(69, '2021-09-07', 1, 1378.21, 1, 1, 1, 12, 1),
(70, '2021-04-28', 1, 1316.22, 1, 1, 1, 12, 1),
(71, '2021-07-01', 1, 1080.7, 1, 1, 1, 12, 1),
(72, '2021-02-14', 1, 1332.42, 1, 1, 1, 12, 1),
(73, '2020-12-06', 1, 1469.55, 1, 1, 1, 12, 1),
(74, '2020-11-29', 1, 1205.55, 1, 1, 1, 12, 1),
(75, '2021-03-01', 1, 1230.86, 1, 1, 1, 12, 1),
(76, '2021-03-02', 1, 1477.37, 1, 1, 1, 12, 1),
(77, '2020-11-25', 1, 1233.85, 1, 1, 1, 12, 1),
(78, '2021-01-20', 1, 1499.06, 1, 1, 1, 12, 1),
(79, '2021-08-19', 1, 1187.36, 1, 1, 1, 12, 1),
(80, '2021-08-18', 1, 1342.74, 1, 1, 1, 12, 1),
(81, '2021-06-15', 1, 1017.65, 1, 1, 1, 12, 1),
(82, '2021-09-15', 1, 1476.06, 1, 1, 1, 12, 1),
(83, '2020-11-21', 1, 1020.65, 1, 1, 1, 12, 1),
(84, '2020-10-11', 1, 1236.09, 1, 1, 1, 12, 1),
(85, '2021-03-29', 1, 1094.35, 1, 1, 1, 12, 1),
(86, '2021-08-07', 1, 1422.38, 1, 1, 1, 12, 1),
(87, '2021-06-24', 1, 1022.2, 1, 1, 1, 12, 1),
(88, '2021-03-09', 1, 1183.49, 1, 1, 1, 12, 1),
(89, '2021-09-24', 1, 1280.77, 1, 1, 1, 12, 1),
(90, '2021-06-12', 1, 1109.54, 1, 1, 1, 12, 1),
(91, '2021-06-28', 1, 1362.37, 1, 1, 1, 12, 1),
(92, '2021-09-09', 1, 1142.79, 1, 1, 1, 12, 1),
(93, '2021-07-09', 1, 1282.95, 1, 1, 1, 12, 1),
(94, '2021-07-10', 1, 1475.6, 1, 1, 1, 12, 1),
(95, '2020-12-19', 1, 1495.54, 1, 1, 1, 12, 1),
(96, '2021-09-17', 1, 1156.15, 1, 1, 1, 12, 1),
(97, '2021-07-19', 1, 1422.4, 1, 1, 1, 12, 1),
(98, '2020-12-28', 1, 1102.82, 1, 1, 1, 12, 1),
(99, '2020-10-11', 1, 1078.81, 1, 1, 1, 12, 1),
(100, '2021-03-18', 1, 1134.26, 1, 1, 1, 12, 1),
(101, '2021-11-01', 1, 1134.26, 1, 1, 1, 12, 1),
(102, '2021-11-01', 1, 1134.26, 1, 1, 1, 12, 1),
(103, '2021-11-01', 1, 1134.26, 1, 2, 1, 12, 1),
(104, '2021-11-01', 1, 1134.26, 1, 2, 1, 12, 1),
(105, '2021-11-01', 1, 1134.26, 1, 2, 1, 12, 1),
(106, '2021-11-01', 1, 1134.26, 1, 2, 1, 12, 1),
(107, '2021-11-01', 1, 1134.26, 1, 2, 1, 12, 1),
(108, '2021-11-01', 1, 1134.26, 1, 2, 1, 12, 1),
(109, '2021-11-01', 1, 1134.26, 1, 3, 1, 12, 1),
(110, '2021-11-01', 1, 1134.26, 1, 3, 1, 12, 1),
(111, '2021-11-01', 1, 1134.26, 1, 3, 1, 12, 1),
(112, '2021-11-01', 1, 1134.26, 1, 3, 1, 12, 1),
(113, '2021-11-01', 1, 1134.26, 1, 3, 1, 12, 1),
(114, '2021-11-01', 1, 1134.26, 1, 3, 1, 12, 1),
(130, '2021-11-01', 1, 1134.26, 1, 5, 1, 12, 1),
(131, '2021-11-01', 1, 1134.26, 1, 4, 1, 12, 1);
-- --------------------------------------------------------

--
-- Table structure for table `departamento`
--

CREATE TABLE `departamento` (
  `idDepartamento` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  PRIMARY KEY (`idDepartamento`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;
INSERT INTO `departamento` VALUES
(1, 'Guatemala'),
(2, 'Huehue');
-- --------------------------------------------------------

--
-- Table structure for table `empleado`
--

CREATE TABLE `empleado` (
  `idEmpleado` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `Apellido` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `FechaNacimiento` date NOT NULL,
  `FechaIngreso` date NOT NULL,
  `Correo` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `telefono` int(8) COLLATE utf8_spanish2_ci NOT NULL,
  `direccion` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `estado` int(1) NOT NULL DEFAULT 1,
  
  PRIMARY KEY (`idEmpleado`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

INSERT INTO `empleado` VALUES
(1, 'Carlos','Laib','2021-10-07','2021-10-07','claib@gmail.com','12345678','su casa',1),
(2, 'Bruno','Diaz','2021-10-07','2021-10-07','bdiazb@gmail.com','13485156','baticueva',1),
(3, 'John','Stewart','2021-10-07','2021-10-07','jtewart@gmail.com','14781','linterna',1),
(4, 'Clark','Dent','2021-10-07','2021-10-07','cdent@gmail.com','12345678','en la jefatura',1),
(5, 'Hal','Jordan','2021-10-07','2021-10-07','hjordan@gmail.com','12345678','lilnterna verde',1);

-- --------------------------------------------------------

--
-- Table structure for table `empresa`
--

CREATE TABLE `empresa` (
  `idEmpresa` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `direccion` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `telefono` int(8) COLLATE utf8_spanish2_ci NOT NULL,
  `nit` varchar(8) COLLATE utf8_spanish2_ci NOT NULL,
  `correo` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `eslogan` varchar(500) COLLATE utf8_spanish2_ci NOT NULL,
  `logo` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `mision` varchar(500) COLLATE utf8_spanish2_ci NOT NULL,
  `vision` varchar(500) COLLATE utf8_spanish2_ci NOT NULL,
  `valores` varchar(500) COLLATE utf8_spanish2_ci NOT NULL,
  PRIMARY KEY (`idEmpresa`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

INSERT INTO `empresa` VALUES
(1, 'Chocolates Milky','zona 10 Edificio Sky Resort','12345678','123456-6','milky@gmail.com','eslogan','logo.png','Â«El Grupo Adidas se esfuerza por ser el lÃ­der mundial en la industria de artÃ­culos deportivos con marcas basadas en la pasiÃ³n por el deporte y el estilo de vida deportivoÂ».','Â«Somos lÃ­deres en innovaciÃ³n y diseÃ±o que buscan ayudar a los atletas de todos los niveles de habilidad a lograr el mÃ¡ximo rendimiento con cada producto que traemos al mercadoÂ».','Â«Seguridad, colaboraciÃ³n y creatividadÂ».');

-- --------------------------------------------------------

--
-- Table structure for table `faseseguimiento`
--

CREATE TABLE `faseseguimiento` (
  `idFaseSeguimiento` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `descripcion` varchar(45) NOT NULL,
  PRIMARY KEY (`idFaseSeguimiento`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

INSERT INTO `faseseguimiento` VALUES
(1, 'En proceso','Pos en proceso'),
(2, 'Completado','Pos completado'),
(3, 'Devuelta','Pos Devuelta');

-- --------------------------------------------------------

--
-- Table structure for table `inventario`
--

CREATE TABLE `inventario` (
  `idProducto` int(11) NOT NULL,
  `idTienda` int(11) NOT NULL,
  `Cantidad` int(11) NOT NULL,
  PRIMARY KEY (`idProducto`,`idTienda`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

INSERT INTO inventario VALUES
(	1	,	1	,	98	)	,
(	2	,	1	,	92	)	,
(	3	,	1	,	76	)	,
(	4	,	1	,	99	)	,
(	5	,	1	,	55	)	,
(	6	,	1	,	62	)	,
(	7	,	1	,	95	)	,
(	8	,	1	,	75	)	,
(	9	,	1	,	65	)	,
(	10	,	1	,	80	)	,
(	1	,	2	,	85	)	,
(	2	,	2	,	52	)	,
(	3	,	2	,	94	)	,
(	4	,	2	,	50	)	,
(	5	,	2	,	76	)	,
(	6	,	2	,	94	)	,
(	7	,	2	,	100	)	,
(	8	,	2	,	52	)	,
(	9	,	2	,	54	)	,
(	10	,	2	,	60	)	,
(	1	,	3	,	50	)	,
(	2	,	3	,	76	)	,
(	3	,	3	,	96	)	,
(	4	,	3	,	81	)	,
(	5	,	3	,	61	)	,
(	6	,	3	,	82	)	,
(	7	,	3	,	66	)	,
(	8	,	3	,	50	)	,
(	9	,	3	,	79	)	,
(	10	,	3	,	86	)	,
(	1	,	4	,	59	)	,
(	2	,	4	,	75	)	,
(	3	,	4	,	74	)	,
(	4	,	4	,	98	)	,
(	5	,	4	,	83	)	,
(	6	,	4	,	83	)	,
(	7	,	4	,	84	)	,
(	8	,	4	,	61	)	,
(	9	,	4	,	65	)	,
(	10	,	4	,	66	)	,
(	1	,	5	,	76	)	,
(	2	,	5	,	63	)	,
(	3	,	5	,	93	)	,
(	4	,	5	,	52	)	,
(	5	,	5	,	61	)	,
(	6	,	5	,	79	)	,
(	7	,	5	,	92	)	,
(	8	,	5	,	78	)	,
(	9	,	5	,	85	)	,
(	10	,	5	,	81	)	;

CREATE TABLE `inventarioEncabezado` (
  `idInvEnc` int(11) NOT NULL AUTO_INCREMENT,
  `Fecha` date NOT NULL,
  PRIMARY KEY (`idInvEnc`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

INSERT INTO `inventarioencabezado` (`idInvEnc`, `Fecha`) VALUES 
(1	,	'2021-11-1'),
(2	,	'2021-11-2'),
(3	,	'2021-11-3'),
(4	,	'2021-11-4'),
(5	,	'2021-11-5'),
(6	,	'2021-11-6'),
(7	,	'2021-11-7'),
(8	,	'2021-11-8'),
(9	,	'2021-11-9'),
(10	,	'2021-11-10'),
(11	,	'2021-11-11'),
(12	,	'2021-11-12'),
(13	,	'2021-11-13');

CREATE TABLE `inventarioDetalle` (
  `idInvEnc` int(11) NOT NULL,
  `idProducto` int(11) NOT NULL,
  `idTienda` int(11) NOT NULL,
  `Cantidad` int(11) NOT NULL,
  PRIMARY KEY (`idInvEnc`,`idProducto`,`idTienda`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;
INSERT INTO `inventariodetalle` (`idInvEnc`, `idProducto`, `idTienda`, `Cantidad`) VALUES 
(	1	,	1	,	1	,	94	)	,
(	1	,	2	,	1	,	75	)	,
(	1	,	3	,	1	,	75	)	,
(	1	,	4	,	1	,	56	)	,
(	1	,	5	,	1	,	67	)	,
(	1	,	6	,	1	,	63	)	,
(	1	,	7	,	1	,	89	)	,
(	1	,	8	,	1	,	90	)	,
(	1	,	9	,	1	,	87	)	,
(	1	,	10	,	1	,	67	)	,
(	1	,	1	,	2	,	57	)	,
(	1	,	2	,	2	,	98	)	,
(	1	,	3	,	2	,	71	)	,
(	1	,	4	,	2	,	100	)	,
(	1	,	5	,	2	,	96	)	,
(	1	,	6	,	2	,	88	)	,
(	1	,	7	,	2	,	69	)	,
(	1	,	8	,	2	,	77	)	,
(	1	,	9	,	2	,	88	)	,
(	1	,	10	,	2	,	77	)	,
(	1	,	1	,	3	,	82	)	,
(	1	,	2	,	3	,	86	)	,
(	1	,	3	,	3	,	90	)	,
(	1	,	4	,	3	,	63	)	,
(	1	,	5	,	3	,	79	)	,
(	1	,	6	,	3	,	72	)	,
(	1	,	7	,	3	,	54	)	,
(	1	,	8	,	3	,	62	)	,
(	1	,	9	,	3	,	83	)	,
(	1	,	10	,	3	,	68	)	,
(	1	,	1	,	4	,	89	)	,
(	1	,	2	,	4	,	51	)	,
(	1	,	3	,	4	,	94	)	,
(	1	,	4	,	4	,	55	)	,
(	1	,	5	,	4	,	57	)	,
(	1	,	6	,	4	,	94	)	,
(	1	,	7	,	4	,	72	)	,
(	1	,	8	,	4	,	75	)	,
(	1	,	9	,	4	,	51	)	,
(	1	,	10	,	4	,	78	)	,
(	1	,	1	,	5	,	62	)	,
(	1	,	2	,	5	,	93	)	,
(	1	,	3	,	5	,	98	)	,
(	1	,	4	,	5	,	88	)	,
(	1	,	5	,	5	,	62	)	,
(	1	,	6	,	5	,	88	)	,
(	1	,	7	,	5	,	79	)	,
(	1	,	8	,	5	,	56	)	,
(	1	,	9	,	5	,	84	)	,
(	1	,	10	,	5	,	78	)	,
(	2	,	1	,	1	,	85	)	,
(	2	,	2	,	1	,	88	)	,
(	2	,	3	,	1	,	77	)	,
(	2	,	4	,	1	,	82	)	,
(	2	,	5	,	1	,	53	)	,
(	2	,	6	,	1	,	94	)	,
(	2	,	7	,	1	,	65	)	,
(	2	,	8	,	1	,	90	)	,
(	2	,	9	,	1	,	50	)	,
(	2	,	10	,	1	,	60	)	,
(	2	,	1	,	2	,	84	)	,
(	2	,	2	,	2	,	99	)	,
(	2	,	3	,	2	,	95	)	,
(	2	,	4	,	2	,	58	)	,
(	2	,	5	,	2	,	91	)	,
(	2	,	6	,	2	,	89	)	,
(	2	,	7	,	2	,	78	)	,
(	2	,	8	,	2	,	78	)	,
(	2	,	9	,	2	,	65	)	,
(	2	,	10	,	2	,	60	)	,
(	2	,	1	,	3	,	90	)	,
(	2	,	2	,	3	,	91	)	,
(	2	,	3	,	3	,	65	)	,
(	2	,	4	,	3	,	51	)	,
(	2	,	5	,	3	,	99	)	,
(	2	,	6	,	3	,	72	)	,
(	2	,	7	,	3	,	72	)	,
(	2	,	8	,	3	,	98	)	,
(	2	,	9	,	3	,	54	)	,
(	2	,	10	,	3	,	82	)	,
(	2	,	1	,	4	,	80	)	,
(	2	,	2	,	4	,	98	)	,
(	2	,	3	,	4	,	73	)	,
(	2	,	4	,	4	,	80	)	,
(	2	,	5	,	4	,	56	)	,
(	2	,	6	,	4	,	65	)	,
(	2	,	7	,	4	,	67	)	,
(	2	,	8	,	4	,	86	)	,
(	2	,	9	,	4	,	55	)	,
(	2	,	10	,	4	,	72	)	,
(	2	,	1	,	5	,	71	)	,
(	2	,	2	,	5	,	53	)	,
(	2	,	3	,	5	,	84	)	,
(	2	,	4	,	5	,	65	)	,
(	2	,	5	,	5	,	96	)	,
(	2	,	6	,	5	,	55	)	,
(	2	,	7	,	5	,	92	)	,
(	2	,	8	,	5	,	62	)	,
(	2	,	9	,	5	,	70	)	,
(	2	,	10	,	5	,	97	)	,
(	3	,	1	,	1	,	54	)	,
(	3	,	2	,	1	,	86	)	,
(	3	,	3	,	1	,	72	)	,
(	3	,	4	,	1	,	88	)	,
(	3	,	5	,	1	,	68	)	,
(	3	,	6	,	1	,	87	)	,
(	3	,	7	,	1	,	74	)	,
(	3	,	8	,	1	,	68	)	,
(	3	,	9	,	1	,	68	)	,
(	3	,	10	,	1	,	68	)	,
(	3	,	1	,	2	,	81	)	,
(	3	,	2	,	2	,	55	)	,
(	3	,	3	,	2	,	98	)	,
(	3	,	4	,	2	,	72	)	,
(	3	,	5	,	2	,	77	)	,
(	3	,	6	,	2	,	79	)	,
(	3	,	7	,	2	,	57	)	,
(	3	,	8	,	2	,	78	)	,
(	3	,	9	,	2	,	88	)	,
(	3	,	10	,	2	,	51	)	,
(	3	,	1	,	3	,	92	)	,
(	3	,	2	,	3	,	100	)	,
(	3	,	3	,	3	,	54	)	,
(	3	,	4	,	3	,	86	)	,
(	3	,	5	,	3	,	90	)	,
(	3	,	6	,	3	,	61	)	,
(	3	,	7	,	3	,	100	)	,
(	3	,	8	,	3	,	98	)	,
(	3	,	9	,	3	,	83	)	,
(	3	,	10	,	3	,	72	)	,
(	3	,	1	,	4	,	50	)	,
(	3	,	2	,	4	,	52	)	,
(	3	,	3	,	4	,	65	)	,
(	3	,	4	,	4	,	100	)	,
(	3	,	5	,	4	,	69	)	,
(	3	,	6	,	4	,	97	)	,
(	3	,	7	,	4	,	79	)	,
(	3	,	8	,	4	,	63	)	,
(	3	,	9	,	4	,	68	)	,
(	3	,	10	,	4	,	87	)	,
(	3	,	1	,	5	,	92	)	,
(	3	,	2	,	5	,	59	)	,
(	3	,	3	,	5	,	60	)	,
(	3	,	4	,	5	,	73	)	,
(	3	,	5	,	5	,	81	)	,
(	3	,	6	,	5	,	68	)	,
(	3	,	7	,	5	,	55	)	,
(	3	,	8	,	5	,	52	)	,
(	3	,	9	,	5	,	100	)	,
(	3	,	10	,	5	,	84	)	,
(	4	,	1	,	1	,	89	)	,
(	4	,	2	,	1	,	58	)	,
(	4	,	3	,	1	,	78	)	,
(	4	,	4	,	1	,	90	)	,
(	4	,	5	,	1	,	88	)	,
(	4	,	6	,	1	,	82	)	,
(	4	,	7	,	1	,	88	)	,
(	4	,	8	,	1	,	56	)	,
(	4	,	9	,	1	,	56	)	,
(	4	,	10	,	1	,	68	)	,
(	4	,	1	,	2	,	60	)	,
(	4	,	2	,	2	,	100	)	,
(	4	,	3	,	2	,	76	)	,
(	4	,	4	,	2	,	56	)	,
(	4	,	5	,	2	,	65	)	,
(	4	,	6	,	2	,	61	)	,
(	4	,	7	,	2	,	79	)	,
(	4	,	8	,	2	,	76	)	,
(	4	,	9	,	2	,	95	)	,
(	4	,	10	,	2	,	94	)	,
(	4	,	1	,	3	,	53	)	,
(	4	,	2	,	3	,	87	)	,
(	4	,	3	,	3	,	95	)	,
(	4	,	4	,	3	,	51	)	,
(	4	,	5	,	3	,	65	)	,
(	4	,	6	,	3	,	94	)	,
(	4	,	7	,	3	,	59	)	,
(	4	,	8	,	3	,	53	)	,
(	4	,	9	,	3	,	53	)	,
(	4	,	10	,	3	,	93	)	,
(	4	,	1	,	4	,	53	)	,
(	4	,	2	,	4	,	87	)	,
(	4	,	3	,	4	,	100	)	,
(	4	,	4	,	4	,	82	)	,
(	4	,	5	,	4	,	98	)	,
(	4	,	6	,	4	,	77	)	,
(	4	,	7	,	4	,	56	)	,
(	4	,	8	,	4	,	54	)	,
(	4	,	9	,	4	,	54	)	,
(	4	,	10	,	4	,	50	)	,
(	4	,	1	,	5	,	94	)	,
(	4	,	2	,	5	,	78	)	,
(	4	,	3	,	5	,	50	)	,
(	4	,	4	,	5	,	53	)	,
(	4	,	5	,	5	,	64	)	,
(	4	,	6	,	5	,	59	)	,
(	4	,	7	,	5	,	84	)	,
(	4	,	8	,	5	,	95	)	,
(	4	,	9	,	5	,	78	)	,
(	4	,	10	,	5	,	77	)	,
(	5	,	1	,	1	,	66	)	,
(	5	,	2	,	1	,	97	)	,
(	5	,	3	,	1	,	81	)	,
(	5	,	4	,	1	,	61	)	,
(	5	,	5	,	1	,	83	)	,
(	5	,	6	,	1	,	84	)	,
(	5	,	7	,	1	,	92	)	,
(	5	,	8	,	1	,	75	)	,
(	5	,	9	,	1	,	65	)	,
(	5	,	10	,	1	,	54	)	,
(	5	,	1	,	2	,	60	)	,
(	5	,	2	,	2	,	50	)	,
(	5	,	3	,	2	,	52	)	,
(	5	,	4	,	2	,	62	)	,
(	5	,	5	,	2	,	88	)	,
(	5	,	6	,	2	,	57	)	,
(	5	,	7	,	2	,	56	)	,
(	5	,	8	,	2	,	64	)	,
(	5	,	9	,	2	,	59	)	,
(	5	,	10	,	2	,	65	)	,
(	5	,	1	,	3	,	56	)	,
(	5	,	2	,	3	,	61	)	,
(	5	,	3	,	3	,	92	)	,
(	5	,	4	,	3	,	56	)	,
(	5	,	5	,	3	,	64	)	,
(	5	,	6	,	3	,	98	)	,
(	5	,	7	,	3	,	89	)	,
(	5	,	8	,	3	,	82	)	,
(	5	,	9	,	3	,	98	)	,
(	5	,	10	,	3	,	77	)	,
(	5	,	1	,	4	,	87	)	,
(	5	,	2	,	4	,	100	)	,
(	5	,	3	,	4	,	51	)	,
(	5	,	4	,	4	,	82	)	,
(	5	,	5	,	4	,	99	)	,
(	5	,	6	,	4	,	81	)	,
(	5	,	7	,	4	,	71	)	,
(	5	,	8	,	4	,	76	)	,
(	5	,	9	,	4	,	96	)	,
(	5	,	10	,	4	,	65	)	,
(	5	,	1	,	5	,	66	)	,
(	5	,	2	,	5	,	96	)	,
(	5	,	3	,	5	,	51	)	,
(	5	,	4	,	5	,	100	)	,
(	5	,	5	,	5	,	84	)	,
(	5	,	6	,	5	,	93	)	,
(	5	,	7	,	5	,	91	)	,
(	5	,	8	,	5	,	85	)	,
(	5	,	9	,	5	,	79	)	,
(	5	,	10	,	5	,	79	)	,
(	6	,	1	,	1	,	64	)	,
(	6	,	2	,	1	,	74	)	,
(	6	,	3	,	1	,	81	)	,
(	6	,	4	,	1	,	85	)	,
(	6	,	5	,	1	,	50	)	,
(	6	,	6	,	1	,	80	)	,
(	6	,	7	,	1	,	71	)	,
(	6	,	8	,	1	,	71	)	,
(	6	,	9	,	1	,	54	)	,
(	6	,	10	,	1	,	59	)	,
(	6	,	1	,	2	,	95	)	,
(	6	,	2	,	2	,	86	)	,
(	6	,	3	,	2	,	78	)	,
(	6	,	4	,	2	,	94	)	,
(	6	,	5	,	2	,	90	)	,
(	6	,	6	,	2	,	82	)	,
(	6	,	7	,	2	,	96	)	,
(	6	,	8	,	2	,	82	)	,
(	6	,	9	,	2	,	89	)	,
(	6	,	10	,	2	,	79	)	,
(	6	,	1	,	3	,	84	)	,
(	6	,	2	,	3	,	74	)	,
(	6	,	3	,	3	,	80	)	,
(	6	,	4	,	3	,	94	)	,
(	6	,	5	,	3	,	82	)	,
(	6	,	6	,	3	,	82	)	,
(	6	,	7	,	3	,	95	)	,
(	6	,	8	,	3	,	53	)	,
(	6	,	9	,	3	,	80	)	,
(	6	,	10	,	3	,	75	)	,
(	6	,	1	,	4	,	56	)	,
(	6	,	2	,	4	,	97	)	,
(	6	,	3	,	4	,	61	)	,
(	6	,	4	,	4	,	77	)	,
(	6	,	5	,	4	,	61	)	,
(	6	,	6	,	4	,	59	)	,
(	6	,	7	,	4	,	69	)	,
(	6	,	8	,	4	,	70	)	,
(	6	,	9	,	4	,	94	)	,
(	6	,	10	,	4	,	57	)	,
(	6	,	1	,	5	,	66	)	,
(	6	,	2	,	5	,	91	)	,
(	6	,	3	,	5	,	59	)	,
(	6	,	4	,	5	,	64	)	,
(	6	,	5	,	5	,	83	)	,
(	6	,	6	,	5	,	50	)	,
(	6	,	7	,	5	,	65	)	,
(	6	,	8	,	5	,	75	)	,
(	6	,	9	,	5	,	99	)	,
(	6	,	10	,	5	,	99	)	,
(	7	,	1	,	1	,	60	)	,
(	7	,	2	,	1	,	87	)	,
(	7	,	3	,	1	,	53	)	,
(	7	,	4	,	1	,	75	)	,
(	7	,	5	,	1	,	53	)	,
(	7	,	6	,	1	,	75	)	,
(	7	,	7	,	1	,	94	)	,
(	7	,	8	,	1	,	72	)	,
(	7	,	9	,	1	,	57	)	,
(	7	,	10	,	1	,	60	)	,
(	7	,	1	,	2	,	56	)	,
(	7	,	2	,	2	,	62	)	,
(	7	,	3	,	2	,	57	)	,
(	7	,	4	,	2	,	82	)	,
(	7	,	5	,	2	,	71	)	,
(	7	,	6	,	2	,	87	)	,
(	7	,	7	,	2	,	63	)	,
(	7	,	8	,	2	,	56	)	,
(	7	,	9	,	2	,	70	)	,
(	7	,	10	,	2	,	84	)	,
(	7	,	1	,	3	,	95	)	,
(	7	,	2	,	3	,	85	)	,
(	7	,	3	,	3	,	93	)	,
(	7	,	4	,	3	,	77	)	,
(	7	,	5	,	3	,	73	)	,
(	7	,	6	,	3	,	91	)	,
(	7	,	7	,	3	,	96	)	,
(	7	,	8	,	3	,	77	)	,
(	7	,	9	,	3	,	88	)	,
(	7	,	10	,	3	,	91	)	,
(	7	,	1	,	4	,	82	)	,
(	7	,	2	,	4	,	56	)	,
(	7	,	3	,	4	,	88	)	,
(	7	,	4	,	4	,	88	)	,
(	7	,	5	,	4	,	100	)	,
(	7	,	6	,	4	,	59	)	,
(	7	,	7	,	4	,	59	)	,
(	7	,	8	,	4	,	92	)	,
(	7	,	9	,	4	,	65	)	,
(	7	,	10	,	4	,	55	)	,
(	7	,	1	,	5	,	56	)	,
(	7	,	2	,	5	,	76	)	,
(	7	,	3	,	5	,	56	)	,
(	7	,	4	,	5	,	75	)	,
(	7	,	5	,	5	,	57	)	,
(	7	,	6	,	5	,	58	)	,
(	7	,	7	,	5	,	76	)	,
(	7	,	8	,	5	,	61	)	,
(	7	,	9	,	5	,	83	)	,
(	7	,	10	,	5	,	84	)	,
(	8	,	1	,	1	,	65	)	,
(	8	,	2	,	1	,	58	)	,
(	8	,	3	,	1	,	99	)	,
(	8	,	4	,	1	,	81	)	,
(	8	,	5	,	1	,	64	)	,
(	8	,	6	,	1	,	65	)	,
(	8	,	7	,	1	,	94	)	,
(	8	,	8	,	1	,	92	)	,
(	8	,	9	,	1	,	77	)	,
(	8	,	10	,	1	,	88	)	,
(	8	,	1	,	2	,	88	)	,
(	8	,	2	,	2	,	91	)	,
(	8	,	3	,	2	,	91	)	,
(	8	,	4	,	2	,	97	)	,
(	8	,	5	,	2	,	67	)	,
(	8	,	6	,	2	,	58	)	,
(	8	,	7	,	2	,	71	)	,
(	8	,	8	,	2	,	96	)	,
(	8	,	9	,	2	,	54	)	,
(	8	,	10	,	2	,	84	)	,
(	8	,	1	,	3	,	82	)	,
(	8	,	2	,	3	,	74	)	,
(	8	,	3	,	3	,	95	)	,
(	8	,	4	,	3	,	90	)	,
(	8	,	5	,	3	,	78	)	,
(	8	,	6	,	3	,	94	)	,
(	8	,	7	,	3	,	59	)	,
(	8	,	8	,	3	,	96	)	,
(	8	,	9	,	3	,	54	)	,
(	8	,	10	,	3	,	82	)	,
(	8	,	1	,	4	,	80	)	,
(	8	,	2	,	4	,	94	)	,
(	8	,	3	,	4	,	100	)	,
(	8	,	4	,	4	,	65	)	,
(	8	,	5	,	4	,	91	)	,
(	8	,	6	,	4	,	56	)	,
(	8	,	7	,	4	,	65	)	,
(	8	,	8	,	4	,	62	)	,
(	8	,	9	,	4	,	50	)	,
(	8	,	10	,	4	,	50	)	,
(	8	,	1	,	5	,	80	)	,
(	8	,	2	,	5	,	65	)	,
(	8	,	3	,	5	,	82	)	,
(	8	,	4	,	5	,	76	)	,
(	8	,	5	,	5	,	50	)	,
(	8	,	6	,	5	,	58	)	,
(	8	,	7	,	5	,	93	)	,
(	8	,	8	,	5	,	84	)	,
(	8	,	9	,	5	,	60	)	,
(	8	,	10	,	5	,	73	)	,
(	9	,	1	,	1	,	69	)	,
(	9	,	2	,	1	,	67	)	,
(	9	,	3	,	1	,	78	)	,
(	9	,	4	,	1	,	87	)	,
(	9	,	5	,	1	,	72	)	,
(	9	,	6	,	1	,	97	)	,
(	9	,	7	,	1	,	88	)	,
(	9	,	8	,	1	,	74	)	,
(	9	,	9	,	1	,	50	)	,
(	9	,	10	,	1	,	95	)	,
(	9	,	1	,	2	,	97	)	,
(	9	,	2	,	2	,	81	)	,
(	9	,	3	,	2	,	60	)	,
(	9	,	4	,	2	,	56	)	,
(	9	,	5	,	2	,	54	)	,
(	9	,	6	,	2	,	75	)	,
(	9	,	7	,	2	,	98	)	,
(	9	,	8	,	2	,	53	)	,
(	9	,	9	,	2	,	86	)	,
(	9	,	10	,	2	,	100	)	,
(	9	,	1	,	3	,	84	)	,
(	9	,	2	,	3	,	56	)	,
(	9	,	3	,	3	,	87	)	,
(	9	,	4	,	3	,	84	)	,
(	9	,	5	,	3	,	88	)	,
(	9	,	6	,	3	,	89	)	,
(	9	,	7	,	3	,	86	)	,
(	9	,	8	,	3	,	85	)	,
(	9	,	9	,	3	,	66	)	,
(	9	,	10	,	3	,	63	)	,
(	9	,	1	,	4	,	62	)	,
(	9	,	2	,	4	,	57	)	,
(	9	,	3	,	4	,	54	)	,
(	9	,	4	,	4	,	72	)	,
(	9	,	5	,	4	,	80	)	,
(	9	,	6	,	4	,	51	)	,
(	9	,	7	,	4	,	80	)	,
(	9	,	8	,	4	,	79	)	,
(	9	,	9	,	4	,	96	)	,
(	9	,	10	,	4	,	93	)	,
(	9	,	1	,	5	,	74	)	,
(	9	,	2	,	5	,	83	)	,
(	9	,	3	,	5	,	74	)	,
(	9	,	4	,	5	,	51	)	,
(	9	,	5	,	5	,	80	)	,
(	9	,	6	,	5	,	100	)	,
(	9	,	7	,	5	,	55	)	,
(	9	,	8	,	5	,	54	)	,
(	9	,	9	,	5	,	61	)	,
(	9	,	10	,	5	,	73	)	,
(	10	,	1	,	1	,	94	)	,
(	10	,	2	,	1	,	76	)	,
(	10	,	3	,	1	,	88	)	,
(	10	,	4	,	1	,	84	)	,
(	10	,	5	,	1	,	88	)	,
(	10	,	6	,	1	,	68	)	,
(	10	,	7	,	1	,	53	)	,
(	10	,	8	,	1	,	93	)	,
(	10	,	9	,	1	,	57	)	,
(	10	,	10	,	1	,	55	)	,
(	10	,	1	,	2	,	98	)	,
(	10	,	2	,	2	,	81	)	,
(	10	,	3	,	2	,	71	)	,
(	10	,	4	,	2	,	61	)	,
(	10	,	5	,	2	,	52	)	,
(	10	,	6	,	2	,	58	)	,
(	10	,	7	,	2	,	66	)	,
(	10	,	8	,	2	,	95	)	,
(	10	,	9	,	2	,	59	)	,
(	10	,	10	,	2	,	93	)	,
(	10	,	1	,	3	,	61	)	,
(	10	,	2	,	3	,	81	)	,
(	10	,	3	,	3	,	89	)	,
(	10	,	4	,	3	,	59	)	,
(	10	,	5	,	3	,	95	)	,
(	10	,	6	,	3	,	68	)	,
(	10	,	7	,	3	,	90	)	,
(	10	,	8	,	3	,	80	)	,
(	10	,	9	,	3	,	93	)	,
(	10	,	10	,	3	,	61	)	,
(	10	,	1	,	4	,	56	)	,
(	10	,	2	,	4	,	93	)	,
(	10	,	3	,	4	,	96	)	,
(	10	,	4	,	4	,	77	)	,
(	10	,	5	,	4	,	90	)	,
(	10	,	6	,	4	,	92	)	,
(	10	,	7	,	4	,	85	)	,
(	10	,	8	,	4	,	100	)	,
(	10	,	9	,	4	,	59	)	,
(	10	,	10	,	4	,	81	)	,
(	10	,	1	,	5	,	79	)	,
(	10	,	2	,	5	,	59	)	,
(	10	,	3	,	5	,	69	)	,
(	10	,	4	,	5	,	96	)	,
(	10	,	5	,	5	,	93	)	,
(	10	,	6	,	5	,	58	)	,
(	10	,	7	,	5	,	77	)	,
(	10	,	8	,	5	,	98	)	,
(	10	,	9	,	5	,	87	)	,
(	10	,	10	,	5	,	83	)	,
(	11	,	1	,	1	,	78	)	,
(	11	,	2	,	1	,	99	)	,
(	11	,	3	,	1	,	70	)	,
(	11	,	4	,	1	,	58	)	,
(	11	,	5	,	1	,	97	)	,
(	11	,	6	,	1	,	94	)	,
(	11	,	7	,	1	,	99	)	,
(	11	,	8	,	1	,	80	)	,
(	11	,	9	,	1	,	62	)	,
(	11	,	10	,	1	,	93	)	,
(	11	,	1	,	2	,	74	)	,
(	11	,	2	,	2	,	96	)	,
(	11	,	3	,	2	,	98	)	,
(	11	,	4	,	2	,	74	)	,
(	11	,	5	,	2	,	81	)	,
(	11	,	6	,	2	,	84	)	,
(	11	,	7	,	2	,	54	)	,
(	11	,	8	,	2	,	57	)	,
(	11	,	9	,	2	,	72	)	,
(	11	,	10	,	2	,	54	)	,
(	11	,	1	,	3	,	82	)	,
(	11	,	2	,	3	,	89	)	,
(	11	,	3	,	3	,	65	)	,
(	11	,	4	,	3	,	54	)	,
(	11	,	5	,	3	,	88	)	,
(	11	,	6	,	3	,	51	)	,
(	11	,	7	,	3	,	83	)	,
(	11	,	8	,	3	,	75	)	,
(	11	,	9	,	3	,	63	)	,
(	11	,	10	,	3	,	79	)	,
(	11	,	1	,	4	,	66	)	,
(	11	,	2	,	4	,	83	)	,
(	11	,	3	,	4	,	86	)	,
(	11	,	4	,	4	,	67	)	,
(	11	,	5	,	4	,	64	)	,
(	11	,	6	,	4	,	92	)	,
(	11	,	7	,	4	,	52	)	,
(	11	,	8	,	4	,	80	)	,
(	11	,	9	,	4	,	68	)	,
(	11	,	10	,	4	,	51	)	,
(	11	,	1	,	5	,	66	)	,
(	11	,	2	,	5	,	100	)	,
(	11	,	3	,	5	,	80	)	,
(	11	,	4	,	5	,	63	)	,
(	11	,	5	,	5	,	74	)	,
(	11	,	6	,	5	,	88	)	,
(	11	,	7	,	5	,	97	)	,
(	11	,	8	,	5	,	91	)	,
(	11	,	9	,	5	,	83	)	,
(	11	,	10	,	5	,	85	)	,
(	12	,	1	,	1	,	76	)	,
(	12	,	2	,	1	,	51	)	,
(	12	,	3	,	1	,	87	)	,
(	12	,	4	,	1	,	85	)	,
(	12	,	5	,	1	,	66	)	,
(	12	,	6	,	1	,	99	)	,
(	12	,	7	,	1	,	67	)	,
(	12	,	8	,	1	,	58	)	,
(	12	,	9	,	1	,	55	)	,
(	12	,	10	,	1	,	87	)	,
(	12	,	1	,	2	,	83	)	,
(	12	,	2	,	2	,	91	)	,
(	12	,	3	,	2	,	91	)	,
(	12	,	4	,	2	,	81	)	,
(	12	,	5	,	2	,	69	)	,
(	12	,	6	,	2	,	82	)	,
(	12	,	7	,	2	,	76	)	,
(	12	,	8	,	2	,	80	)	,
(	12	,	9	,	2	,	75	)	,
(	12	,	10	,	2	,	83	)	,
(	12	,	1	,	3	,	75	)	,
(	12	,	2	,	3	,	90	)	,
(	12	,	3	,	3	,	88	)	,
(	12	,	4	,	3	,	71	)	,
(	12	,	5	,	3	,	57	)	,
(	12	,	6	,	3	,	78	)	,
(	12	,	7	,	3	,	64	)	,
(	12	,	8	,	3	,	86	)	,
(	12	,	9	,	3	,	86	)	,
(	12	,	10	,	3	,	60	)	,
(	12	,	1	,	4	,	98	)	,
(	12	,	2	,	4	,	52	)	,
(	12	,	3	,	4	,	91	)	,
(	12	,	4	,	4	,	87	)	,
(	12	,	5	,	4	,	81	)	,
(	12	,	6	,	4	,	56	)	,
(	12	,	7	,	4	,	91	)	,
(	12	,	8	,	4	,	72	)	,
(	12	,	9	,	4	,	83	)	,
(	12	,	10	,	4	,	53	)	,
(	12	,	1	,	5	,	87	)	,
(	12	,	2	,	5	,	85	)	,
(	12	,	3	,	5	,	62	)	,
(	12	,	4	,	5	,	67	)	,
(	12	,	5	,	5	,	88	)	,
(	12	,	6	,	5	,	67	)	,
(	12	,	7	,	5	,	70	)	,
(	12	,	8	,	5	,	89	)	,
(	12	,	9	,	5	,	93	)	,
(	12	,	10	,	5	,	91	)	,
(	13	,	1	,	1	,	97	)	,
(	13	,	2	,	1	,	78	)	,
(	13	,	3	,	1	,	65	)	,
(	13	,	4	,	1	,	62	)	,
(	13	,	5	,	1	,	88	)	,
(	13	,	6	,	1	,	60	)	,
(	13	,	7	,	1	,	98	)	,
(	13	,	8	,	1	,	86	)	,
(	13	,	9	,	1	,	51	)	,
(	13	,	10	,	1	,	84	)	,
(	13	,	1	,	2	,	67	)	,
(	13	,	2	,	2	,	79	)	,
(	13	,	3	,	2	,	54	)	,
(	13	,	4	,	2	,	98	)	,
(	13	,	5	,	2	,	100	)	,
(	13	,	6	,	2	,	91	)	,
(	13	,	7	,	2	,	77	)	,
(	13	,	8	,	2	,	69	)	,
(	13	,	9	,	2	,	86	)	,
(	13	,	10	,	2	,	63	)	,
(	13	,	1	,	3	,	61	)	,
(	13	,	2	,	3	,	54	)	,
(	13	,	3	,	3	,	65	)	,
(	13	,	4	,	3	,	86	)	,
(	13	,	5	,	3	,	71	)	,
(	13	,	6	,	3	,	55	)	,
(	13	,	7	,	3	,	83	)	,
(	13	,	8	,	3	,	72	)	,
(	13	,	9	,	3	,	62	)	,
(	13	,	10	,	3	,	71	)	,
(	13	,	1	,	4	,	50	)	,
(	13	,	2	,	4	,	82	)	,
(	13	,	3	,	4	,	52	)	,
(	13	,	4	,	4	,	95	)	,
(	13	,	5	,	4	,	86	)	,
(	13	,	6	,	4	,	74	)	,
(	13	,	7	,	4	,	75	)	,
(	13	,	8	,	4	,	63	)	,
(	13	,	9	,	4	,	85	)	,
(	13	,	10	,	4	,	83	)	,
(	13	,	1	,	5	,	50	)	,
(	13	,	2	,	5	,	72	)	,
(	13	,	3	,	5	,	98	)	,
(	13	,	4	,	5	,	83	)	,
(	13	,	5	,	5	,	57	)	,
(	13	,	6	,	5	,	68	)	,
(	13	,	7	,	5	,	86	)	,
(	13	,	8	,	5	,	62	)	,
(	13	,	9	,	5	,	56	)	,
(	13	,	10	,	5	,	72	)	;










CREATE TABLE `minimos` (
  `idProducto` int(11) NOT NULL,
  `idTienda` int(11) NOT NULL,
  `CantidadMinima` int(11) NOT NULL,
  PRIMARY KEY (`idProducto`,`idTienda`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

INSERT INTO `minimos` VALUES
(1,1,100),
(2,1,100);

CREATE TABLE `alertas` (
  `idAlerta` int(11) NOT NULL AUTO_INCREMENT,
  `Fecha` DATETIME NOT NULL,
  `Mensaje` varchar(250) NOT NULL,
  `estado` int(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`idAlerta`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;


--
-- Table structure for table `municipio`
--

CREATE TABLE `municipio` (
  `idMunicipio` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `idDepartamento` int(11) NOT NULL,
  PRIMARY KEY (`idMunicipio`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

INSERT INTO `municipio` VALUES
(1, 'San jose del golfo',1);
-- --------------------------------------------------------

--
-- Table structure for table `producto`
--

CREATE TABLE `proveedor` (
  `idProveedor` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `direccion` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `telefono` int(8) COLLATE utf8_spanish2_ci NOT NULL,
  `nit` varchar(8) COLLATE utf8_spanish2_ci NOT NULL,
  `correo` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `estado` int(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`idProveedor`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

INSERT INTO `proveedor` VALUES
(1, 'Coca cola','su empresa','12345678','01050-k','COCA@GMAIL.COM',1);



CREATE TABLE `producto` (
  `idProducto` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `descripcion` varchar(21000) NOT NULL,
  `Precio` double NOT NULL,
  `precioCompra` double NOT NULL,
  `idCategoria` int(11) NOT NULL,
  `imagen` text(21000) COLLATE utf8_spanish2_ci NOT NULL,
  `idProveedor` int(11) NOT NULL,
  `caracteristicas` text(21000) NOT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY(`idProducto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

INSERT INTO `producto` VALUES
(1, 'Chocolates hershey','Es el alimento que se obtiene mezclando azÃºcar con dos productos que derivan de la manipulaciÃ³n de las semillas del cacao: la masa del cacao y la manteca de cacao.',1.50,1.50,1,'chocolate.jpeg',1,'',1),
(2, 'Camisa Manga Corta Roja','Prenda de vestir de tela que cubre el torso , abotonada por delante , generalmente con cuello y mangas',15,150,2,'camisa.jpg',1,'',1),
(3, 'Lapices Mongol Triangulares','Es un instrumento de escritura o dibujo que presenta una barra de grafito encerrada en un cilindro de madera u otro material.',20,25,1,'lapiz.jpg',1,'',1),
(4, 'Tenis Deportivo','Es una pieza de calzado que protege al pie, brindÃ¡ndole comodidad a la persona a la hora de llevar a cabo diferentes acciones',30,35,1,'tenis.jpg',1,'',1),
(5, 'Sandalia','Es un tipo de calzado, conocido desde la antigÃ¼edad, que consiste en una suela resistente atada al pie mediante cuerdas, cintas o bandas de material ligero, quedando los dedos y otras partes del pie al descubierto.',40,45,1,'chanclas.jpg',1,'',1),
(6, 'Pumpkin', ' ', 338.31, 952.8, 2, ' ', 1, ' ', 1),
(7, 'Water - Spring Water 500ml', ' ', 344.83, 671.89, 3, ' ', 1, ' ', 1),
(8, 'Squash - Sunburst', ' ', 549.97, 465.66, 3, ' ', 1, ' ', 1),
(9, 'Goat - Whole Cut', ' ', 215.95, 396.79, 3, ' ', 1, ' ', 1),
(10, 'Wine - Red, Cabernet Merlot', ' ', 253.55, 690.95, 2, ' ', 1, ' ', 1),
(11, 'Pork - Ground', ' ', 603.24, 598.97, 3, ' ', 1, ' ', 1),
(12, 'Venison - Striploin', ' ', 785.16, 75.42, 2, ' ', 1, ' ', 1),
(13, 'Garlic - Elephant', ' ', 957.67, 892.04, 2, ' ', 1, ' ', 1),
(14, 'Durian Fruit', ' ', 919.28, 835.81, 3, ' ', 1, ' ', 1),
(15, 'Chevril', ' ', 478.25, 89.4, 3, ' ', 1, ' ', 1),
(16, 'Leeks - Large', ' ', 531.67, 119.66, 3, ' ', 1, ' ', 1),
(17, 'Sambuca - Ramazzotti', ' ', 148.22, 103.56, 2, ' ', 1, ' ', 1),
(18, 'Lotus Leaves', ' ', 505.52, 346.66, 3, ' ', 1, ' ', 1),
(19, 'Soup Knorr Chili With Beans', ' ', 700.21, 327.32, 3, ' ', 1, ' ', 1),
(20, 'Pineapple - Canned, Rings', ' ', 534.85, 443.34, 2, ' ', 1, ' ', 1),
(21, 'Chicken - Whole Roasting', ' ', 379.7, 506.9, 2, ' ', 1, ' ', 1),
(22, 'Soup - Campbells, Classic Chix', ' ', 823.92, 484.71, 2, ' ', 1, ' ', 1),
(23, 'Asparagus - Green, Fresh', ' ', 885.71, 65.25, 2, ' ', 1, ' ', 1),
(24, 'Jolt Cola - Electric Blue', ' ', 609.39, 128.52, 1, ' ', 1, ' ', 1),
(25, 'Cream - 10%', ' ', 375.19, 956.92, 3, ' ', 1, ' ', 1),
(26, 'Club Soda - Schweppes, 355 Ml', ' ', 619.52, 858.37, 3, ' ', 1, ' ', 1),
(27, 'Artichoke - Bottom, Canned', ' ', 907.65, 730.84, 2, ' ', 1, ' ', 1),
(28, 'Tea Peppermint', ' ', 183.46, 959.06, 2, ' ', 1, ' ', 1),
(29, 'Tuna - Canned, Flaked, Light', ' ', 977.21, 524.38, 3, ' ', 1, ' ', 1),
(30, 'Chervil - Fresh', ' ', 331.57, 182.72, 3, ' ', 1, ' ', 1),
(31, 'Extract - Almond', ' ', 568.7, 933.67, 3, ' ', 1, ' ', 1),
(32, 'Beer - Upper Canada Lager', ' ', 821.21, 780.66, 3, ' ', 1, ' ', 1),
(33, 'Pepsi, 355 Ml', ' ', 885.73, 558.61, 1, ' ', 1, ' ', 1),
(34, 'Soup - Campbells Tomato Ravioli', ' ', 651.45, 60.57, 3, ' ', 1, ' ', 1),
(35, 'Wine - Sauvignon Blanc Oyster', ' ', 293.78, 79.45, 3, ' ', 1, ' ', 1),
(36, 'Glass - Juice Clear 5oz 55005', ' ', 968.68, 348.0, 3, ' ', 1, ' ', 1),
(37, 'Coconut Milk - Unsweetened', ' ', 75.43, 87.47, 1, ' ', 1, ' ', 1),
(38, 'Bar Mix - Pina Colada, 355 Ml', ' ', 281.2, 809.15, 1, ' ', 1, ' ', 1),
(39, 'Chicken - Diced, Cooked', ' ', 268.99, 991.32, 2, ' ', 1, ' ', 1),
(40, 'Sprite, Diet - 355ml', ' ', 206.68, 738.36, 3, ' ', 1, ' ', 1),
(41, 'Coffee - Frthy Coffee Crisp', ' ', 995.75, 424.48, 1, ' ', 1, ' ', 1),
(42, 'Tart - Pecan Butter Squares', ' ', 625.3, 273.11, 3, ' ', 1, ' ', 1),
(43, 'Wine - Chianti Classica Docg', ' ', 126.75, 161.56, 1, ' ', 1, ' ', 1),
(44, 'Mousse - Banana Chocolate', ' ', 757.71, 218.44, 3, ' ', 1, ' ', 1),
(45, 'Longan', ' ', 445.07, 564.46, 3, ' ', 1, ' ', 1),
(46, 'Shichimi Togarashi Peppeers', ' ', 638.14, 100.57, 3, ' ', 1, ' ', 1),
(47, 'Pork - Tenderloin, Fresh', ' ', 737.6, 149.47, 1, ' ', 1, ' ', 1),
(48, 'Bread - Onion Focaccia', ' ', 329.29, 822.33, 3, ' ', 1, ' ', 1),
(49, 'Cheese - Cambozola', ' ', 195.23, 661.12, 2, ' ', 1, ' ', 1),
(50, 'Walkers Special Old Whiskey', ' ', 927.52, 252.43, 3, ' ', 1, ' ', 1),
(51, 'Vol Au Vents', ' ', 756.38, 871.21, 1, ' ', 1, ' ', 1),
(52, 'Muffin Mix - Oatmeal', ' ', 592.72, 892.87, 3, ' ', 1, ' ', 1),
(53, 'Island Oasis - Mango Daiquiri', ' ', 146.67, 705.64, 2, ' ', 1, ' ', 1),
(54, 'Cardamon Seed / Pod', ' ', 389.74, 442.13, 2, ' ', 1, ' ', 1),
(55, 'Cake - Bande Of Fruit', ' ', 571.65, 782.03, 1, ' ', 1, ' ', 1),
(56, 'Cheese - Stilton', ' ', 888.15, 783.19, 2, ' ', 1, ' ', 1),
(57, 'Chips - Miss Vickies', ' ', 167.9, 812.45, 3, ' ', 1, ' ', 1),
(58, 'Buffalo - Striploin', ' ', 484.67, 832.7, 2, ' ', 1, ' ', 1),
(59, 'Lemonade - Kiwi, 591 Ml', ' ', 226.51, 623.46, 3, ' ', 1, ' ', 1),
(60, 'Myers Planters Punch', ' ', 965.68, 233.05, 3, ' ', 1, ' ', 1),
(61, 'Honey - Comb', ' ', 554.48, 576.3, 2, ' ', 1, ' ', 1),
(62, 'Aspic - Clear', ' ', 963.13, 809.52, 3, ' ', 1, ' ', 1),
(63, 'Russian Prince', ' ', 581.06, 103.05, 1, ' ', 1, ' ', 1),
(64, 'Lamb - Leg, Bone In', ' ', 766.88, 394.74, 2, ' ', 1, ' ', 1),
(65, 'Truffle Shells - Semi - Sweet', ' ', 994.24, 613.32, 3, ' ', 1, ' ', 1);

alter table producto add column `ganancia` double not null default 15;
alter table producto add column `conf` int not null default 2;
-- --------------------------------------------------------

--
-- Table structure for table `promocion`
--

CREATE TABLE `promocion` (
  `idPromocion` int(11) NOT NULL AUTO_INCREMENT,
  `fechaInicio` date NOT NULL,
  `fechaFinal` date NOT NULL,
  `idProducto` int(11) NOT NULL,
  `descuento` double NOT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`idPromocion`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

INSERT INTO `promocion` VALUES
(1, '2021-10-07','2021-10-07',1,50,1);
-- --------------------------------------------------------

--
-- Table structure for table `proveedor`
--

-- --------------------------------------------------------

--
-- Table structure for table `proveedorproducto`
--

/*CREATE TABLE `proveedorproducto` (
  `idProveedor` int(11) NOT NULL,
  `idProducto` int(11) NOT NULL,
  PRIMARY KEY(`idProveedor`,`idProducto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

INSERT INTO `proveedorproducto` VALUES
(1, 1);*/

-- --------------------------------------------------------

--
-- Table structure for table `seguimientoventa`
--

CREATE TABLE `seguimientoventa` (
  `idSeguimientoVenta` int(11) NOT NULL AUTO_INCREMENT,
  `fecha` datetime NOT NULL,
  `idFaseSeguimiento` int(11) NOT NULL,
  `idVentaEncabezado` int(11) NOT NULL,
  `comentarios` varchar(45) COLLATE utf8_spanish2_ci DEFAULT NULL,
`estado` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY(`idSeguimientoVenta`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

INSERT INTO seguimientoventa VALUES
(1,'2021-10-07 20:26:34',2,1,'no hay com',1),
(2,'2021-10-07 20:26:34',2,6,'no hay com',1),
(3,'2021-10-07 20:26:34',2,15,'no hay com',1),
(4,'2021-10-07 20:26:34',1,18,'no hay com',1),
(5,'2021-10-07 20:26:34',1,19,'no hay com',1);

-- --------------------------------------------------------

--
-- Table structure for table `tienda`
--

CREATE TABLE `tienda` (
  `idTienda` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `direccion` varchar(150) COLLATE utf8_spanish2_ci NOT NULL,
  `idMunicipio` int(11) NOT NULL,
  `tipoTienda` tinyint(1) NOT NULL DEFAULT '1',
  `estado` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY(`idTienda`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

INSERT INTO `tienda` VALUES
(1, 'Capital','esta en la capital',1,1,1),
(2, 'Bodega Central','esta en la florida',1,0,1),
(3, 'Naranjo Mall','esta en la florida',1,1,1),
(4, 'Oakland Mall','esta en la florida',1,1,1),
(5, 'Cayala','esta en la florida',1,1,1);
-- --------------------------------------------------------

--
-- Table structure for table `tipodepago`
--

CREATE TABLE `tipodepago` (
  `idTipoDePago` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `descripcion` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY(`idTipoDePago`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

INSERT INTO `tipodepago` VALUES
(1, 'Efectivo','Dinero en efectivo',1),
(2, 'tarjeta de credito','tarjetas de credito varias',1);

-- --------------------------------------------------------

--
-- Table structure for table `usuario`
--

CREATE TABLE `usuario` (
  `idusuario` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `clave` varchar(64) COLLATE utf8_spanish_ci NOT NULL,
  `imagen` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `idEmpleado` int(11) NOT NULL,
  `condicion` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY(`idusuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

INSERT INTO `usuario` ( `nombre`, `clave`, `imagen`,`idEmpleado`,`condicion`) VALUES
( 'Admin',  '8c6976e5b5410415bde908bd4dee15dfb167a9c873fc4bb8a81f6f2ab448a918', '1523752615.jpg',1, 1),
( 'Bryan',  '8c6976e5b5410415bde908bd4dee15dfb167a9c873fc4bb8a81f6f2ab448a918', '1523752615.jpg',2, 1);
;

/*usuario cliente*/
CREATE TABLE `usuarioCliente` (
  `idUsuarioCliente` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `clave` varchar(64) COLLATE utf8_spanish_ci NOT NULL,
  `imagen` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `idCliente` int(11) NOT NULL,
  `condicion` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY(`idUsuarioCliente`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

INSERT INTO `usuarioCliente` ( `nombre`, `clave`, `imagen`, `idCliente`, `condicion`) VALUES
( 'Admin', '8c6976e5b5410415bde908bd4dee15dfb167a9c873fc4bb8a81f6f2ab448a918', '1523752615.jpg',1, 1),
( 'Bryan', '12345', '1523752615.jpg',2, 1);
-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario_permiso`
--

CREATE TABLE `usuario_permiso` (
  `idusuario_permiso` int(11) NOT NULL AUTO_INCREMENT,
  `idusuario` int(11) NOT NULL,
  `idpermiso` int(11) NOT NULL,
  PRIMARY KEY(`idusuario_permiso`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `usuario_permiso`
--

INSERT INTO `usuario_permiso` (`idusuario_permiso`, `idusuario`, `idpermiso`) VALUES
(82, 1, 1),
(83, 1, 2),
(84, 1, 3),
(85, 1, 4),
(86, 1, 5),
(87, 1, 6),
(88, 1, 7),
(89, 1, 8),
(90, 1, 9),
(91, 1, 10);
-- --------------------------------------------------------
--
-- Table structure for table `ventadetalle`
--

CREATE TABLE `ventadetalle` (
  `idVentaEncabezado` int(11) NOT NULL,
  `idProducto` int(11) NOT NULL,
  `cantidad` int(5) COLLATE utf8_spanish2_ci NOT NULL,
  `descuento` float NOT NULL,
  PRIMARY KEY(`idVentaEncabezado`,`idProducto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

INSERT INTO `ventadetalle` VALUES
(1, 2, 27, 1.58),
(2, 3, 60, 9.73),
(3, 6, 100, 3.92),
(4, 2, 32, 3.82),
(5, 4, 46, 6.11),
(6, 10, 84, 5.89),
(7, 5, 31, 3.93),
(8, 1, 29, 7.98),
(9, 10, 91, 8.91),
(10, 1, 19, 7.38),
(11, 7, 17, 7.46),
(12, 4, 93, 5.11),
(13, 6, 97, 8.58),
(14, 7, 73, 6.46),
(15, 9, 58, 5.27),
(16, 8, 92, 3.47),
(17, 10, 46, 1.85),
(18, 3, 68, 2.88),
(19, 4, 88, 7.54),
(20, 4, 38, 6.26),
(21, 6, 2, 6.17),
(22, 7, 39, 9.97),
(23, 8, 87, 6.39),
(24, 1, 31, 1.38),
(25, 4, 22, 1.26),
(26, 1, 41, 7.79),
(27, 6, 45, 2.12),
(28, 9, 45, 5.35),
(29, 8, 34, 9.04),
(30, 3, 37, 3.64),
(31, 10, 72, 5.9),
(32, 10, 43, 3.54),
(33, 2, 85, 7.85),
(34, 5, 5, 7.21),
(35, 7, 100, 5.51),
(36, 7, 78, 3.09),
(37, 10, 52, 9.84),
(38, 4, 30, 3.26),
(39, 3, 34, 2.42),
(40, 1, 58, 9.56),
(41, 7, 41, 6.23),
(42, 2, 61, 6.8),
(43, 3, 78, 3.13),
(44, 2, 62, 8.73),
(45, 6, 56, 2.64),
(46, 9, 3, 8.63),
(47, 1, 84, 3.86),
(48, 2, 64, 5.98),
(49, 5, 43, 5.81),
(50, 5, 99, 9.98),
(51, 7, 99, 1.24),
(52, 8, 94, 4.68),
(53, 2, 78, 4.62),
(54, 6, 78, 8.09),
(55, 6, 100, 7.02),
(56, 6, 76, 1.24),
(57, 2, 16, 7.37),
(58, 4, 73, 7.37),
(59, 9, 2, 1.08),
(60, 7, 27, 4.13),
(61, 5, 83, 6.01),
(62, 7, 59, 9.83),
(63, 7, 99, 4.35),
(64, 5, 48, 4.06),
(65, 4, 51, 2.09),
(66, 4, 87, 2.67),
(67, 10, 35, 8.09),
(68, 10, 33, 5.56),
(69, 10, 58, 2.68),
(70, 1, 83, 6.04),
(71, 6, 69, 8.23),
(72, 9, 45, 8.98),
(73, 4, 2, 7.68),
(74, 10, 100, 8.01),
(75, 4, 98, 5.38),
(76, 5, 2, 4.11),
(77, 9, 47, 6.4),
(78, 4, 7, 8.67),
(79, 4, 4, 4.95),
(80, 10, 1, 3.74),
(81, 5, 2, 6.15),
(82, 6, 16, 9.74),
(83, 6, 49, 6.9),
(84, 1, 45, 8.29),
(85, 9, 10, 1.5),
(86, 5, 53, 8.13),
(87, 7, 19, 4.48),
(88, 7, 19, 2.67),
(89, 10, 32, 2.36),
(90, 7, 34, 9.19),
(91, 4, 4, 2.02),
(92, 4, 74, 2.43),
(93, 2, 96, 3.78),
(94, 8, 94, 2.31),
(95, 10, 64, 6.18),
(96, 3, 18, 7.23),
(97, 6, 15, 8.44),
(98, 6, 100, 5.77),
(99, 7, 61, 4.37),
(100, 1, 90, 6.32),
(101, 5, 14, 6.32),
(102, 7, 24, 6.32),
(103, 9, 37, 6.32),
(104, 10, 7, 6.32),
(105, 4, 42, 6.32),
(106, 5, 5, 6.32),
(107, 9, 23, 6.32),
(108, 10, 17, 6.32),
(109, 3, 25, 6.32),
(110, 4, 12, 6.32),
(111, 9, 29, 6.32),
(130, 2, 40, 6.32),
(130, 3, 14, 6.32),
(130, 4, 23, 6.32),
(130, 6, 33, 6.32),
(130, 9, 14, 6.32),
(131, 1, 9, 6.32),
(131, 3, 21, 6.32),
(131, 5, 1, 6.32),
(131, 6, 29, 6.32),
(131, 7, 5, 6.32),
(131, 10, 6, 6.32);

-- --------------------------------------------------------

--
-- Table structure for table `ventaencabezado`
--

CREATE TABLE `ventaencabezado` (
  `idVentaEncabezado` int(11) NOT NULL AUTO_INCREMENT,
  `idCliente` int(11) NOT NULL,
  `fecha` datetime NOT NULL,
  `total` float NOT NULL,
  `descuento` float NOT NULL,
  `iva` float NOT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT '1',
  `idUsuario` int(11) NOT NULL,
  `idTienda` int(11) NOT NULL,
  `idTipoDePago` int(11) NOT NULL,
  `idTipoMoneda` int(2) NOT NULL,
  PRIMARY KEY(`idVentaEncabezado`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

INSERT INTO `ventaencabezado` VALUES 
(1, 2, '2021-02-24', 1331.66, 32.52, 55.63, 1, 1, 5, 1, 1),
(2, 1, '2021-11-26', 1614.27, 61.27, 44.38, 1, 2, 4, 1, 1),
(3, 3, '2021-12-19', 1612.17, 31.62, 42.16, 1, 2, 3, 1, 1),
(4, 3, '2021-08-20', 1593.64, 54.88, 52.32, 0, 1, 5, 1, 1),
(5, 1, '2021-03-29', 1290.71, 97.53, 87.26, 1, 1, 4, 1, 1),
(6, 2, '2021-09-04', 1377.81, 52.49, 61.09, 0, 1, 4, 1, 1),
(7, 1, '2021-09-14', 1564.16, 65.95, 84.12, 0, 2, 3, 1, 1),
(8, 3, '2021-11-25', 1224.97, 37.16, 96.94, 1, 1, 4, 1, 1),
(9, 1, '2021-07-20', 1573.75, 11.02, 13.37, 0, 1, 3, 1, 1),
(10, 1, '2021-11-01', 1437.87, 94.05, 40.55, 0, 1, 1, 1, 1),
(11, 1, '2021-10-03', 1396.73, 89.21, 35.99, 0, 1, 4, 1, 1),
(12, 3, '2021-08-20', 1652.15, 79.88, 74.57, 0, 2, 5, 1, 1),
(13, 3, '2021-05-06', 1335.8, 87.84, 81.5, 1, 2, 5, 1, 1),
(14, 1, '2021-06-13', 1214.66, 97.26, 68.95, 0, 2, 5, 1, 1),
(15, 2, '2021-09-28', 1569.94, 38.8, 63.77, 1, 2, 3, 1, 1),
(16, 3, '2021-06-06', 1253.08, 55.42, 82.02, 0, 1, 4, 1, 1),
(17, 1, '2021-06-05', 1055.29, 67.06, 62.46, 0, 1, 3, 1, 1),
(18, 2, '2021-03-21', 1435.97, 96.18, 72.62, 1, 2, 4, 1, 1),
(19, 2, '2021-10-10', 1242.99, 45.62, 95.24, 1, 1, 5, 1, 1),
(20, 2, '2021-04-29', 1310.62, 90.54, 56.04, 0, 2, 5, 1, 1),
(21, 1, '2021-05-28', 1578.76, 10.24, 26.31, 1, 2, 5, 1, 1),
(22, 1, '2021-10-13', 1099.18, 33.91, 33.96, 1, 2, 5, 1, 1),
(23, 1, '2021-01-17', 1289.55, 66.05, 65.78, 0, 2, 5, 1, 1),
(24, 3, '2021-09-06', 1342.8, 69.15, 77.49, 1, 1, 5, 1, 1),
(25, 3, '2021-08-03', 1505.04, 59.75, 96.29, 1, 2, 5, 1, 1),
(26, 2, '2021-08-17', 1157.41, 26.26, 93.5, 0, 1, 3, 1, 1),
(27, 1, '2021-05-14', 1398.07, 61.55, 78.41, 0, 2, 4, 1, 1),
(28, 1, '2021-02-21', 1024.31, 80.2, 77.96, 0, 1, 3, 1, 1),
(29, 3, '2021-05-24', 1352.21, 62.54, 65.26, 1, 1, 4, 1, 1),
(30, 2, '2021-04-22', 1312.26, 99.11, 80.54, 1, 1, 5, 1, 1),
(31, 1, '2021-01-15', 1563.25, 48.66, 24.05, 1, 2, 3, 1, 1),
(32, 2, '2021-01-22', 1347.61, 34.08, 94.1, 1, 1, 5, 1, 1),
(33, 1, '2021-12-21', 1369.97, 12.53, 89.05, 1, 2, 4, 1, 1),
(34, 3, '2021-12-30', 1583.29, 31.85, 53.46, 0, 2, 3, 1, 1),
(35, 3, '2021-02-27', 1649.39, 54.93, 86.77, 1, 1, 3, 1, 1),
(36, 3, '2021-12-12', 1455.59, 87.44, 38.37, 1, 2, 4, 1, 1),
(37, 1, '2021-02-17', 1109.15, 27.68, 93.89, 1, 2, 3, 1, 1),
(38, 3, '2021-07-23', 1569.24, 79.78, 78.03, 1, 2, 4, 1, 1),
(39, 3, '2021-05-24', 1433.6, 82.76, 42.14, 1, 1, 5, 1, 1),
(40, 1, '2021-06-30', 1259.01, 17.97, 44.42, 0, 2, 3, 1, 1),
(41, 2, '2021-10-21', 1009.85, 41.26, 16.23, 0, 1, 4, 1, 1),
(42, 2, '2021-06-24', 1329.85, 17.08, 86.15, 1, 2, 4, 1, 1),
(43, 1, '2021-05-22', 1320.76, 31.59, 53.68, 1, 1, 4, 1, 1),
(44, 3, '2021-07-03', 1306.39, 64.95, 44.19, 1, 2, 3, 1, 1),
(45, 1, '2021-10-17', 1587.63, 47.71, 41.45, 1, 2, 5, 1, 1),
(46, 1, '2021-02-23', 1397.92, 90.09, 29.89, 1, 2, 5, 1, 1),
(47, 1, '2021-08-09', 1348.84, 25.85, 86.94, 1, 2, 3, 1, 1),
(48, 1, '2021-11-01', 1083.47, 69.16, 48.35, 1, 2, 1, 1, 1),
(49, 3, '2021-01-31', 1153.11, 11.93, 22.74, 1, 1, 4, 1, 1),
(50, 3, '2021-05-19', 1654.22, 59.97, 49.79, 0, 1, 4, 1, 1),
(51, 3, '2021-04-22', 1246.87, 85.49, 57.75, 0, 1, 5, 1, 1),
(52, 1, '2021-09-29', 1469.25, 38.3, 33.67, 0, 1, 3, 1, 1),
(53, 2, '2021-12-06', 1245.38, 64.17, 32.8, 0, 2, 3, 1, 1),
(54, 1, '2021-12-05', 1468.23, 66.6, 74.59, 1, 1, 3, 1, 1),
(55, 1, '2021-03-08', 1387.91, 42.02, 22.3, 1, 1, 3, 1, 1),
(56, 2, '2021-01-21', 1341.82, 34.2, 42.64, 1, 1, 5, 1, 1),
(57, 3, '2021-06-06', 1296.68, 90.22, 55.84, 1, 2, 5, 1, 1),
(58, 3, '2021-06-12', 1657.87, 52.77, 73.3, 0, 2, 4, 1, 1),
(59, 1, '2021-07-16', 1624.11, 21.78, 93.92, 1, 2, 5, 1, 1),
(60, 2, '2021-05-18', 1441.88, 19.14, 55.28, 1, 2, 3, 1, 1),
(61, 1, '2021-10-27', 1634.75, 35.64, 71.56, 1, 1, 3, 1, 1),
(62, 3, '2021-04-26', 1249.48, 72.01, 29.56, 1, 1, 5, 1, 1),
(63, 3, '2021-12-08', 1222.31, 21.29, 78.35, 0, 1, 3, 1, 1),
(64, 2, '2021-11-13', 1121.55, 29.01, 53.1, 0, 2, 4, 1, 1),
(65, 3, '2021-06-18', 1578.29, 85.56, 46.06, 1, 1, 3, 1, 1),
(66, 3, '2021-11-16', 1589.81, 34.14, 56.72, 0, 2, 3, 1, 1),
(67, 1, '2021-08-10', 1134.16, 76.05, 40.72, 0, 1, 5, 1, 1),
(68, 2, '2021-01-12', 1636.06, 64.54, 41.99, 0, 1, 4, 1, 1),
(69, 3, '2021-04-04', 1034.37, 85.89, 29.45, 0, 1, 3, 1, 1),
(70, 3, '2021-11-05', 1017.54, 37.67, 43.14, 0, 2, 4, 1, 1),
(71, 1, '2021-09-01', 1042.9, 70.61, 90.9, 1, 1, 4, 1, 1),
(72, 3, '2021-10-20', 1433.84, 10.01, 97.4, 0, 1, 3, 1, 1),
(73, 1, '2021-09-01', 1640.49, 13.67, 59.38, 1, 2, 3, 1, 1),
(74, 2, '2021-03-20', 1292.08, 53.28, 22.5, 0, 2, 3, 1, 1),
(75, 3, '2021-02-21', 1049.68, 56.53, 11.35, 1, 2, 5, 1, 1),
(76, 1, '2021-12-28', 1010.87, 30.54, 75.63, 0, 2, 3, 1, 1),
(77, 3, '2021-09-26', 1344.7, 91.14, 32.2, 1, 2, 5, 1, 1),
(78, 2, '2021-06-19', 1304.27, 97.85, 52.75, 1, 1, 3, 1, 1),
(79, 1, '2021-03-11', 1587.94, 79.12, 37.37, 1, 2, 5, 1, 1),
(80, 1, '2021-12-14', 1639.3, 23.28, 57.49, 1, 2, 3, 1, 1),
(81, 2, '2021-03-10', 1408.01, 46.89, 83.75, 0, 2, 4, 1, 1),
(82, 3, '2021-06-22', 1024.04, 60.87, 46.79, 1, 2, 3, 1, 1),
(83, 2, '2021-11-30', 1645.87, 11.31, 22.92, 0, 1, 3, 1, 1),
(84, 2, '2021-03-04', 1588.98, 15.56, 14.5, 0, 1, 4, 1, 1),
(85, 2, '2021-01-28', 1480.78, 56.87, 67.69, 1, 1, 4, 1, 1),
(86, 3, '2021-06-20', 1135.15, 21.33, 13.62, 1, 1, 3, 1, 1),
(87, 1, '2021-12-26', 1035.98, 50.57, 65.36, 0, 1, 3, 1, 1),
(88, 2, '2021-07-17', 1022.84, 75.31, 75.23, 0, 1, 3, 1, 1),
(89, 1, '2021-08-05', 1494.26, 76.93, 27.26, 0, 2, 5, 1, 1),
(90, 1, '2021-08-25', 1244.5, 12.45, 16.02, 0, 1, 4, 1, 1),
(91, 2, '2021-10-12', 1525.04, 29.04, 17.11, 0, 1, 5, 1, 1),
(92, 3, '2021-04-30', 1281.58, 98.11, 72.31, 0, 1, 5, 1, 1),
(93, 3, '2021-07-17', 1045.84, 81.23, 42.41, 1, 1, 3, 1, 1),
(94, 1, '2021-08-05', 1576.22, 93.45, 43.96, 0, 1, 5, 1, 1),
(95, 2, '2021-12-08', 1574.12, 94.68, 48.72, 1, 2, 3, 1, 1),
(96, 3, '2021-02-13', 1698.77, 81.3, 27.82, 0, 2, 3, 1, 1),
(97, 1, '2021-06-02', 1558.21, 94.88, 75.64, 0, 1, 4, 1, 1),
(98, 2, '2021-10-22', 1162.63, 99.26, 77.49, 1, 2, 3, 1, 1),
(99, 2, '2021-11-27', 1069.5, 99.97, 98.89, 1, 1, 4, 1, 1),
(100, 2, '2021-06-08', 1677.88, 65.0, 89.93, 0, 2, 5, 1, 1),
(101, 2, '2021-11-01', 1677.88, 65.0, 89.93, 0, 2, 1, 1, 1),
(102, 2, '2021-11-01', 1677.88, 65.0, 89.93, 0, 2, 1, 1, 1),
(103, 2, '2021-11-01', 1677.88, 65.0, 89.93, 0, 2, 1, 1, 1),
(104, 2, '2021-11-01', 1677.88, 65.0, 89.93, 0, 2, 1, 1, 1),
(105, 2, '2021-11-01', 1677.88, 65.0, 89.93, 0, 2, 2, 1, 1),
(106, 2, '2021-11-01', 1677.88, 65.0, 89.93, 0, 2, 2, 1, 1),
(107, 2, '2021-11-01', 1677.88, 65.0, 89.93, 0, 2, 2, 1, 1),
(108, 2, '2021-11-01', 1677.88, 65.0, 89.93, 0, 2, 2, 1, 1),
(109, 2, '2021-11-01', 1677.88, 65.0, 89.93, 0, 2, 3, 1, 1),
(110, 2, '2021-11-01', 1677.88, 65.0, 89.93, 0, 2, 3, 1, 1),
(111, 2, '2021-11-01', 1677.88, 65.0, 89.93, 0, 2, 3, 1, 1),

(130, 2, '2021-11-01', 1677.88, 65.0, 89.93, 0, 2, 5, 1, 1),
(131, 2, '2021-11-01', 1677.88, 65.0, 89.93, 0, 2, 4, 1, 1);

CREATE TABLE `permiso` (
  `idpermiso` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY(`idpermiso`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `permiso`
--

INSERT INTO `permiso` (`idpermiso`, `nombre`) VALUES
(1, 'Escritorio'),
(2, 'Almacen'),
(3, 'Compras'),
(4, 'Ventas'),
(5, 'Acceso'),
(6, 'Reportes'),
(7, 'Graficas'),
(8, 'Pagos'),
(9, 'Recursos Humanos'),
(10, 'Configuracion');


CREATE TABLE `devolucion` (
  `idDevolucion` int(11) NOT NULL AUTO_INCREMENT,
  `idVentaEncabezado` int(11) NOT NULL,
  `fecha` datetime NOT NULL,
  `comentario` varchar(1000) NOT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY(`idDevolucion`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

CREATE TABLE `caracteristica` (
  `idCaracteristica` int(11) NOT NULL AUTO_INCREMENT,
  `caracteristica` varchar(50) NOT NULL,
  `desplegable` tinyint(1) NOT NULL DEFAULT '0',
  `opciones` varchar(1000),
  PRIMARY KEY(`idCaracteristica`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

INSERT INTO `caracteristica` (`idCaracteristica`, `caracteristica`,`desplegable`, `opciones`) VALUES
(1, 'Talla',1,'XS, S, M, L'),
(2, 'Color',0,NULL),
(3, 'Contenido del paquete',0,NULL);

CREATE TABLE `caracteristicasCategoria` (
  `idCategoria` int(11) NOT NULL,
  `idCaracteristica` int(11) NOT NULL,
  PRIMARY KEY(`idCategoria`,`idCaracteristica`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

INSERT INTO `caracteristicasCategoria` (`idCategoria`, `idCaracteristica`) VALUES
(2, 2),
(2, 1),
(3, 3);
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
