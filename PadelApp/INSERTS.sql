-- phpMyAdmin SQL Dump
-- version 4.6.6deb4
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 20, 2017 at 10:08 AM
-- Server version: 10.1.26-MariaDB-0+deb9u1
-- PHP Version: 7.0.19-1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- CREAR LA BD BORRANDOLA SI YA EXISTIESE
--
DROP DATABASE IF EXISTS `ABP2018`;
CREATE DATABASE `ABP2018` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
--
-- SELECCIONAMOS PARA USAR
--
USE `ABP2018`;
--
-- DAMOS PERMISO USO Y BORRAMOS EL USUARIO QUE QUEREMOS CREAR POR SI EXISTE
--
GRANT USAGE ON * . * TO `user`@`localhost`;
	DROP USER `user`@`localhost`;
--
-- CREAMOS EL USUARIO Y LE DAMOS PASSWORD,DAMOS PERMISO DE USO Y DAMOS PERMISOS SOBRE LA BASE DE DATOS.
--
CREATE USER IF NOT EXISTS `user`@`localhost` IDENTIFIED BY 'pass';
GRANT USAGE ON *.* TO `user`@`localhost` REQUIRE NONE WITH MAX_QUERIES_PER_HOUR 0 MAX_CONNECTIONS_PER_HOUR 0 MAX_UPDATES_PER_HOUR 0 MAX_USER_CONNECTIONS 0;
GRANT ALL PRIVILEGES ON `ABP2018`.* TO `user`@`localhost` WITH GRANT OPTION;
-- --------------------------------------------------------
-- --------------------------------------------------------




--
-- Table structure for table `USUARIO_GRUPO`
--

CREATE TABLE `USU_GRUPO` (
  `login` varchar(9) COLLATE latin1_spanish_ci NOT NULL,
  `IdGrupo` varchar(20) COLLATE latin1_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;


-- --------------------------------------------------------
--
-- Table structure for table `GRUPO`
--

CREATE TABLE `GRUPO` (
  `IdGrupo` varchar(20) COLLATE latin1_spanish_ci NOT NULL,
  `NombreGrupo` varchar(60) COLLATE latin1_spanish_ci NOT NULL,
  `DescripGrupo` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;


-- --------------------------------------------------------

--
-- Table structure for table `USUARIO`
--

CREATE TABLE `USUARIO` (
  `login` varchar(9) COLLATE latin1_spanish_ci NOT NULL,
  `password` varchar(128) COLLATE latin1_spanish_ci NOT NULL,
  `DNI` varchar(9) COLLATE latin1_spanish_ci NOT NULL,
  `Nombre` varchar(30) COLLATE latin1_spanish_ci NOT NULL,
  `Apellidos` varchar(50) COLLATE latin1_spanish_ci NOT NULL,
  `Correo` varchar(40) COLLATE latin1_spanish_ci NOT NULL,
  `Direccion` varchar(60) COLLATE latin1_spanish_ci NOT NULL,
  `Telefono` varchar(11) COLLATE latin1_spanish_ci NOT NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Indexes for table `USUARIO`
--
ALTER TABLE `USUARIO`
  ADD PRIMARY KEY (`login`);

--
-- Indexes for table `GRUPO`
--
ALTER TABLE `GRUPO`
  ADD PRIMARY KEY (`IdGrupo`);


--
-- Indexes for table `USUARIO_GRUPO`
--
ALTER TABLE `USU_GRUPO`
  ADD PRIMARY KEY (`login`,`IdGrupo`);


  
  
  --         INSERTS
  


INSERT INTO `GRUPO` (`IdGrupo`, `NombreGrupo`, `DescripGrupo`) VALUES
('Admin', 'Administracion', 'Grupo que tendra todos los permisos'),
('Deportista', 'Deportistas', 'Grupo que tendra todos los permisos de deportistas');

 
--
-- EL LOGIN DEL USUARIO COINCIDE CON SU CONTRASE?A
--


INSERT INTO `USUARIO` (`login`, `password`, `DNI`, `Nombre`, `Apellidos`, `Correo`, `Direccion`, `Telefono`) VALUES
('a', '0cc175b9c0f1b6a831c399e269772661', '50307657X', 'a', 'a', 'aa@a.aa', 'a', '34988222222'),
('admin', '21232f297a57a5a743894a0e4a801fc3', '44656257D', 'admin', 'admin', 'admin@admin.admin', 'admin', '988252515'),
('b', '92eb5ffee6ae2fec3ad71c777531578f', '86309999S', 'b', 'b', 'b@b.bb', 'b', '988212212'),
('c', '4a8a08f09d37b73795649038408b5f33', '90011482Q', 'c', 'c', 'cc@c.cc', 'c', '988272717'),
('d', '8277e0910d750195b448797616e091ad', '86309999S', 'd', 'd', 'd@d.dd', 'd', '34998343433'),
('e', 'e1671797c52e15f763380b45e841ec32', '71028847V', 'e', 'e', 'e@ee.e', 'e', '988222222'),
('f', '8fa14cdd754f91cc6554c9e71929cce7', '12081312X', 'f', 'f', 'ff@ff.ff', 'f', '988222222'),
('g', 'b2f5ff47436671b6e533d8dc3614845d', '57039042P', 'g', 'g', 'gg@gg.g', 'g', '988222222'),
('h', '2510c39011c5be704182423e3a695e91', '80950297A', 'h', 'h', 'hh@hh.h', 'h', '988222222'),
('i', '865c0c0b4ab0e063e5caa3387c1a8741', '71821143D', 'i', 'i', 'ii@ii.ii', 'i', '988222222'),
('j', '363b122c528f54df4a0446b6bab05515', '06886276F', 'j', 'j', 'jj@jj.jj', 'j', '988222222');

INSERT INTO `USU_GRUPO` (`login`, `IdGrupo`) VALUES
('a', 'Deportista'),
('admin', 'Entrenador'),
('b', 'Deportista'),
('c', 'Deportista'),
('d', 'Deportista'),
('e', 'Deportista'),
('f', 'Deportista'),
('g', 'Deportista'),
('h', 'Deportista'),
('i', 'Deportista'),
('j', 'Deportista');


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
