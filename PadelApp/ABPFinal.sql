﻿-- MySQL Script generated by MySQL Workbench
-- Tue Oct 23 18:10:16 2018
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema AbpBase
-- -----------------------------------------------------
DROP SCHEMA IF EXISTS `AbpBase` ;

-- -----------------------------------------------------
-- Schema AbpBase
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `AbpBase` DEFAULT CHARACTER SET utf8 ;
USE `AbpBase` ;

GRANT USAGE ON * . * TO `user`@`localhost`;
	DROP USER `user`@`localhost`;


CREATE USER IF NOT EXISTS `user`@`localhost` IDENTIFIED BY 'pass';
GRANT USAGE ON *.* TO `user`@`localhost` REQUIRE NONE WITH MAX_QUERIES_PER_HOUR 0 MAX_CONNECTIONS_PER_HOUR 0 MAX_UPDATES_PER_HOUR 0 MAX_USER_CONNECTIONS 0;
GRANT ALL PRIVILEGES ON `abpbase`.* TO `user`@`localhost` WITH GRANT OPTION;

-- -----------------------------------------------------
-- Table `AbpBase`.`Pista`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `AbpBase`.`Pista` ;

CREATE TABLE IF NOT EXISTS `AbpBase`.`Pista` (
  `idPista` INT NOT NULL,
  `Fecha` DATE NOT NULL,
  `Hora` TIME NOT NULL,
  `Disponibilidad` TINYINT NOT NULL,
  PRIMARY KEY (`idPista`, `Fecha`, `Hora`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `AbpBase`.`Usuario`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `AbpBase`.`Usuario` ;

CREATE TABLE IF NOT EXISTS `AbpBase`.`Usuario` (
  `Dni` VARCHAR(12) NOT NULL,
  `Login` VARCHAR(25) NOT NULL,
  `Password` VARCHAR(128) NOT NULL,
  `Nombre` VARCHAR(30) NOT NULL,
  `Apellidos` VARCHAR(45) NOT NULL,
  `Sexo` VARCHAR(6) CHARACTER SET 'armscii8' NOT NULL,
  `Tipo` VARCHAR(12) NOT NULL,
  `Telefono` VARCHAR(14) NOT NULL,
  PRIMARY KEY (`Dni`),
  UNIQUE INDEX `Login_UNIQUE` (`Login` ASC) )
ENGINE = InnoDB;



-- -----------------------------------------------------
-- Table `AbpBase`.`Campeonato`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `AbpBase`.`Campeonato` ;

CREATE TABLE IF NOT EXISTS `AbpBase`.`Campeonato` (
  `IdCampeonato` INT NOT NULL,
  `FechaIni` DATE NOT NULL,
  `HoraIni` TIME NOT NULL,
  `FechaFin` DATE NOT NULL,
  `HoraFin` TIME NOT NULL,
  PRIMARY KEY (`IdCampeonato`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `AbpBase`.`Categoría`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `AbpBase`.`Categoria` ;

CREATE TABLE IF NOT EXISTS `AbpBase`.`Categoria` (
  `IdCampeonato` INT NOT NULL,
  `Tipo` VARCHAR(9) NOT NULL,
  `Nivel` INT NOT NULL,
  PRIMARY KEY (`IdCampeonato`, `Tipo`, `Nivel`),
  CONSTRAINT `fk_cat_campeonato`
    FOREIGN KEY (`IdCampeonato`)
    REFERENCES `AbpBase`.`Campeonato` (`IdCampeonato`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `AbpBase`.`Pareja`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `AbpBase`.`Pareja` ;

CREATE TABLE IF NOT EXISTS `AbpBase`.`Pareja` (
  `idCampeonato` INT NOT NULL,
  `Tipo` VARCHAR(9) NOT NULL,
  `Nivel` INT NOT NULL,
  `NumPareja` INT NOT NULL,
  `Capitan` VARCHAR(12) NOT NULL,
  PRIMARY KEY (`idCampeonato`, `Tipo`, `Nivel`, `NumPareja`),
  CONSTRAINT `fk_par_cat`
    FOREIGN KEY (`idCampeonato` , `Tipo` , `Nivel`)
    REFERENCES `AbpBase`.`Categoria` (`IdCampeonato` , `Tipo` , `Nivel`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `AbpBase`.`Grupo`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `AbpBase`.`Grupo` ;

CREATE TABLE IF NOT EXISTS `AbpBase`.`Grupo` (
  `IdCampeonato` INT NOT NULL,
  `Tipo` VARCHAR(9) NOT NULL,
  `Nivel` INT NOT NULL,
  `Letra` CHAR NOT NULL,
  PRIMARY KEY (`IdCampeonato`, `Tipo`, `Nivel`, `Letra`),
  CONSTRAINT `fk_cat_grupo`
    FOREIGN KEY (`IdCampeonato` , `Tipo` , `Nivel`)
    REFERENCES `AbpBase`.`Categoria` (`IdCampeonato` , `Tipo` , `Nivel`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `AbpBase`.`Partido`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `AbpBase`.`Partido` ;

CREATE TABLE IF NOT EXISTS `AbpBase`.`Partido` (
  `IdCampeonato` INT NOT NULL,
  `Tipo` VARCHAR(8) NOT NULL,
  `Nivel` INT NOT NULL,
  `Grupo_Letra` CHAR NOT NULL,
  `NumEnfrentamiento` INT NOT NULL,
  `Fecha` DATE NOT NULL,
  `Hora` TIME NULL,
  PRIMARY KEY (`IdCampeonato`, `Tipo`, `Nivel`, `Grupo_Letra`, `NumEnfrentamiento`),
  CONSTRAINT `fk_partido_grupo`
    FOREIGN KEY (`IdCampeonato` , `Tipo` , `Nivel` , `Grupo_Letra`)
    REFERENCES `AbpBase`.`Grupo` (`IdCampeonato` , `Tipo` , `Nivel` , `Letra`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `AbpBase`.`Promociones`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `AbpBase`.`Promociones` ;

CREATE TABLE IF NOT EXISTS `AbpBase`.`Promociones` (
  `Fecha` DATE NOT NULL,
  `Hora` TIME NOT NULL,
  PRIMARY KEY (`Fecha`, `Hora`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `AbpBase`.`IncripcionPromociones`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `AbpBase`.`IncripcionPromociones` ;

CREATE TABLE IF NOT EXISTS `AbpBase`.`IncripcionPromociones` (
  `Usuario_Dni` VARCHAR(12) NOT NULL,
  `Promociones_Fecha` DATE NOT NULL,
  `Promociones_Hora` TIME NOT NULL,
  PRIMARY KEY (`Usuario_Dni`, `Promociones_Fecha`, `Promociones_Hora`),
  INDEX `fk_Usuario_has_Promociones_Promociones1_idx` (`Promociones_Fecha` ASC, `Promociones_Hora` ASC) ,
  INDEX `fk_Usuario_has_Promociones_Usuario1_idx` (`Usuario_Dni` ASC) ,
  CONSTRAINT `fk_Usuario_has_Promociones_Usuario1`
    FOREIGN KEY (`Usuario_Dni`)
    REFERENCES `AbpBase`.`Usuario` (`Dni`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Usuario_has_Promociones_Promociones1`
    FOREIGN KEY (`Promociones_Fecha` , `Promociones_Hora`)
    REFERENCES `AbpBase`.`Promociones` (`Fecha` , `Hora`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `AbpBase`.`UsuarioParejas`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `AbpBase`.`UsuarioParejas` ;

CREATE TABLE IF NOT EXISTS `AbpBase`.`UsuarioParejas` (
  `Usuario_Dni` VARCHAR(12) NOT NULL,
  `Pareja_idCampeonato` INT NOT NULL,
  `Pareja_Tipo` VARCHAR(9) NOT NULL,
  `Pareja_Nivel` INT NOT NULL,
  `Pareja_NumPareja` INT NOT NULL,
  PRIMARY KEY (`Usuario_Dni`, `Pareja_idCampeonato`, `Pareja_Tipo`, `Pareja_Nivel`, `Pareja_NumPareja`),
  INDEX `fk_Usuario_has_Pareja_Pareja1_idx` (`Pareja_idCampeonato` ASC, `Pareja_Tipo` ASC, `Pareja_Nivel` ASC, `Pareja_NumPareja` ASC) ,
  INDEX `fk_Usuario_has_Pareja_Usuario1_idx` (`Usuario_Dni` ASC) ,
  CONSTRAINT `fk_Usuario_has_Pareja_Usuario1`
    FOREIGN KEY (`Usuario_Dni`)
    REFERENCES `AbpBase`.`Usuario` (`Dni`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Usuario_has_Pareja_Pareja1`
    FOREIGN KEY (`Pareja_idCampeonato` , `Pareja_Tipo` , `Pareja_Nivel` , `Pareja_NumPareja`)
    REFERENCES `AbpBase`.`Pareja` (`idCampeonato` , `Tipo` , `Nivel` , `NumPareja`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `AbpBase`.`Enfrentamiento`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `AbpBase`.`Enfrentamiento` ;

CREATE TABLE IF NOT EXISTS `AbpBase`.`Enfrentamiento` (
  `IdCampeonato` INT NOT NULL,
  `Tipo` VARCHAR(9) NOT NULL,
  `Nivel` INT NOT NULL,
  `Letra` CHAR NOT NULL,
  `NumEnfrentamiento` INT NOT NULL,
  `NumPareja` INT NOT NULL,
  `Resultado` VARCHAR(25) NULL,
  PRIMARY KEY (`IdCampeonato`, `Tipo`, `Nivel`, `Letra`, `NumEnfrentamiento`, `NumPareja`),
  INDEX `fk_Pareja_has_Partido_Pareja1_idx` (`IdCampeonato` ASC, `Tipo` ASC, `Nivel` ASC, `NumPareja` ASC) ,
  CONSTRAINT `fk_Pareja_has_Partido_Pareja1`
    FOREIGN KEY (`IdCampeonato` , `Tipo` , `Nivel` , `NumPareja`)
    REFERENCES `AbpBase`.`Pareja` (`idCampeonato` , `Tipo` , `Nivel` , `NumPareja`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Pareja_has_Partido_Partido1`
    FOREIGN KEY (`IdCampeonato` , `Tipo` , `Nivel` , `Letra` , `NumEnfrentamiento`)
    REFERENCES `AbpBase`.`Partido` (`IdCampeonato` , `Tipo` , `Nivel` , `Grupo_Letra` , `NumEnfrentamiento`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `AbpBase`.`Reserva`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `AbpBase`.`Reserva` ;

CREATE TABLE IF NOT EXISTS `AbpBase`.`Reserva` (
  `Usuario_Dni` VARCHAR(12) NOT NULL,
  `Pista_idPista` INT NOT NULL,
  `Pista_Fecha` DATE NOT NULL,
  `Pista_Hora` TIME NOT NULL,
  PRIMARY KEY (`Usuario_Dni`, `Pista_idPista`, `Pista_Fecha`, `Pista_Hora`),
  INDEX `fk_Usuario_has_Pista_Pista1_idx` (`Pista_idPista` ASC, `Pista_Fecha` ASC, `Pista_Hora` ASC) ,
  INDEX `fk_Usuario_has_Pista_Usuario1_idx` (`Usuario_Dni` ASC) ,
  CONSTRAINT `fk_Usuario_has_Pista_Usuario1`
    FOREIGN KEY (`Usuario_Dni`)
    REFERENCES `AbpBase`.`Usuario` (`Dni`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Usuario_has_Pista_Pista1`
    FOREIGN KEY (`Pista_idPista` , `Pista_Fecha` , `Pista_Hora`)
    REFERENCES `AbpBase`.`Pista` (`idPista` , `Fecha` , `Hora`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

USE `AbpBase` ;

-- -----------------------------------------------------
-- Placeholder table for view `AbpBase`.`Clasificacion`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `AbpBase`.`Clasificacion` (`IdCampeonato` INT, `Tipo` INT, `Nivel` INT, `Letra` INT, `Login` INT);

-- -----------------------------------------------------
-- View `AbpBase`.`Clasificacion`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `AbpBase`.`Clasificacion`;
DROP VIEW IF EXISTS `AbpBase`.`Clasificacion` ;
USE `AbpBase`;
CREATE OR REPLACE VIEW `Clasificacion` AS select E.IdCampeonato,E.Tipo,E.Nivel,E.Letra,E.NumEnfrentamiento,E.NumPareja,U.Login 
from Enfrentamiento E, UsuarioParejas UP, Usuario U 
where UP.Pareja_idCampeonato = E.IdCampeonato AND UP.Pareja_Tipo=E.Tipo AND UP.Pareja_Nivel=E.Nivel AND UP.Pareja_NumPareja=E.NumPareja AND U.Dni=UP.Usuario_Dni;



--
-- Volcado de datos para la tabla `categoria`
--
INSERT INTO `categoria` (`IdCampeonato`, `Tipo`, `Nivel`) VALUES
(1, 'Femenino', 1),
(1, 'Masculino', 1),
(1, 'Mixto', 1),
(2, 'Femenino', 1),
(2, 'Femenino', 2),
(2, 'Masculino', 1);


--
-- Volcado de datos para la tabla `grupo`
--

INSERT INTO `grupo` (`IdCampeonato`, `Tipo`, `Nivel`, `Letra`) VALUES
(1, 'Femenino', 1, 'A'),
(1, 'Masculino', 1, 'A'),
(1, 'Mixto', 1, 'A'),
(2, 'Femenino', 2, 'A'),
(2, 'Masculino', 1, 'A');

--
-- Volcado de datos para la tabla `pareja`
--

INSERT INTO `pareja` (`idCampeonato`, `Tipo`, `Nivel`, `NumPareja`, `Capitan`) VALUES
(1, 'Femenino', 1, 1, 'laila'),
(1, 'Femenino', 1, 2, 'leile'),
(1, 'Masculino', 1, 1, 'jaglez'),
(1, 'Masculino', 1, 2, 'mfdiaz');

--
-- Volcado de datos para la tabla `partido`
--

INSERT INTO `partido` (`IdCampeonato`, `Tipo`, `Nivel`, `Grupo_Letra`, `NumEnfrentamiento`, `Fecha`, `Hora`) VALUES 
('1', 'Femenino', '1', 'A', '1', '2018-10-24', NULL),
 ('1', 'Femenino', '1', 'A', '2', '2018-10-24', NULL), 
 ('1', 'Mixto', '1', 'A', '1', '2018-10-24', NULL), 
 ('1', 'Mixto', '1', 'A', '2', '2018-10-24', NULL);
--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`Dni`, `Login`, `Password`, `Nombre`, `Apellidos`, `Sexo`, `Tipo`, `Telefono`) VALUES
('10880946Z', 'leile', '06d1641fd3eb1d0589a6e6c83d4992e6', 'leile', 'le lei', 'Mujer', 'Deportista', '114658797'),
('23293294K', 'luilu', 'cccfea6bb17ed97626af780bd3ffa3cf', 'luilu', 'lu lui', 'Mujer', 'Deportista', '452168792'),
('50890587M', 'mfdiaz', '54cd358904ef041d1e89b6c73cc264a2', 'Miguel', 'Ferreiro Diaz', 'Hombre', 'Deportista', '123456789'),
('72070206H', 'jaglez', '47747a3f07debbd856020e280fa2419e', 'Jacobo', 'Gonzalez Gonzalez', 'Hombre', 'Deportista', '765890434'),
('09291497A', 'davurin', '9de928ec1ef8601960385d3ef0e99940', 'David', 'Prieto Lopez', 'Hombre', 'Deportista', '443534545'),
('52349891X', 'avcid1', '8d175e3061a0cd33408e84885fd10062', 'A', 'Vila Cid', 'Hombre', 'Deportista', '647864181'),
('52349892X', 'avcid2', 'ae0dc71cb2989e2340b3ccb6c21ed811', 'Al', 'Vila Cid', 'Hombre', 'Deportista', '647864182'),
('52349893X', 'avcid4', '392bb0835f63a7ae3b68162630db12c1', 'Ale', 'Vila Cid', 'Hombre', 'Deportista', '647864183'),
('52349894X', 'avcid5', 'abbbb5d72fc74cf61ef31a32fe85e87d', 'Alej', 'Vila Cid', 'Hombre', 'Deportista', '647864185'),
('52349895X', 'avcid6', 'da2f8e0d863644b52092f9167cccfc82', 'Aleja', 'Vila Cid', 'Hombre', 'Deportista', '647864186'),
('52349897X', 'avcid7', '0b036829dd268bbbc8d8de5687d8542d', 'Alejan', 'Vila Cid', 'Hombre', 'Deportista', '647864188'),
('52349898X', 'avcid8', '7fea9d45ba983d6ee1da12b16a8a5518', 'Alejand', 'Vila Cid', 'Hombre', 'Deportista', '647864189'),
('52349899X', 'avcid9', 'b0a8da92935e2618d7d2d1ba11b37379', 'Alejandr', 'Vila Cid', 'Hombre', 'Deportista', '647864187'),
('52349890X', 'avcid0', '21422e4b4af71034c9231c1f92ec1cb1', 'Alejandroo', 'Vila Cid', 'Hombre', 'Deportista', '647864180'),
('53042369E', 'admin', '21232f297a57a5a743894a0e4a801fc3', 'admin', 'admin', 'Hombre', 'Admin', '687654987');

--
-- Volcado de datos para la tabla `usuarioparejas`
--

INSERT INTO `usuarioparejas` (`Usuario_Dni`, `Pareja_idCampeonato`, `Pareja_Tipo`, `Pareja_Nivel`, `Pareja_NumPareja`) VALUES
('10880946Z', 1, 'Femenino', 1, 2),
('23293294K', 1, 'Femenino', 1, 2),
('50890587M', 1, 'Femenino', 1, 1),
('72070206H', 1, 'Masculino', 1, 1),
('09291497A', 1, 'Masculino', 1, 1),
('52349896X', 1, 'Masculino', 1, 2),
('46866917R', 1, 'Femenino', 1, 1);

--
-- Volcado de datos para la tabla `campeonato`
--

INSERT INTO `campeonato` (`IdCampeonato`, `FechaIni`,`HoraIni`, `FechaFin`,`HoraFin`) VALUES
(1, '2018-10-23', '09:00', '2018-10-31', '23:00'),
(2, '2018-10-25', '10:00', '2018-10-27' ,'23:00');

--
-- Volcado de datos para la tabla `incripcionpromociones`
--

INSERT INTO `incripcionpromociones` (`Usuario_Dni`, `Promociones_Fecha`, `Promociones_Hora`) VALUES
('72070206H', '2018-10-23', '16:00'),
('50890587M', '2018-10-23', '12:30');

--
-- Volcado de datos para la tabla `pista`
--

INSERT INTO `pista` (`idPista`, `Fecha`, `Hora`, `Disponibilidad`) VALUES
(1, '2018-10-23', '11:00', 1),
(1, '2018-10-23', '12:30', 1),
(1, '2018-10-23', '16:00', 1),
(1, '2018-10-23', '17:30', 1),
(1, '2018-10-23', '19:00', 1),
(1, '2018-10-23', '20:30', 1),
(1, '2018-10-23', '22:00', 1),
(1, '2018-10-24', '11:00', 1),
(1, '2018-10-24', '12:30', 1),
(1, '2018-10-24', '16:00', 1),
(1, '2018-10-24', '17:30', 1),
(1, '2018-10-24', '19:00', 1),
(1, '2018-10-24', '20:30', 1),
(1, '2018-10-24', '22:00', 1),
(1, '2018-10-25', '11:00', 1),
(1, '2018-10-25', '12:30', 1),
(1, '2018-10-25', '16:00', 1),
(1, '2018-10-25', '17:30', 1),
(1, '2018-10-25', '19:00', 1),
(1, '2018-10-25', '20:30', 1),
(1, '2018-10-25', '22:00', 1),
(1, '2018-10-26', '11:00', 1),
(1, '2018-10-26', '12:30', 1),
(1, '2018-10-26', '16:00', 1),
(1, '2018-10-26', '17:30', 1),
(1, '2018-10-26', '19:00', 1),
(1, '2018-10-26', '20:30', 1),
(1, '2018-10-26', '22:00', 1),
(1, '2018-10-27', '11:00', 1),
(1, '2018-10-27', '12:30', 1),
(1, '2018-10-27', '16:00', 1),
(1, '2018-10-27', '17:30', 1),
(1, '2018-10-27', '19:00', 1),
(1, '2018-10-27', '20:30', 1),
(1, '2018-10-27', '22:00', 1),
(1, '2018-10-28', '11:00', 1),
(1, '2018-10-28', '12:30', 1),
(1, '2018-10-28', '16:00', 1),
(1, '2018-10-28', '17:30', 1),
(1, '2018-10-28', '19:00', 1),
(1, '2018-10-28', '20:30', 1),
(1, '2018-10-28', '22:00', 1),
(1, '2018-10-29', '11:00', 1),
(1, '2018-10-29', '12:30', 1),
(1, '2018-10-29', '16:00', 1),
(1, '2018-10-29', '17:30', 1),
(1, '2018-10-29', '19:00', 1),
(1, '2018-10-29', '20:30', 1),
(1, '2018-10-29', '22:00', 1),
(2, '2018-10-23', '11:00', 1),
(2, '2018-10-23', '12:30', 1),
(2, '2018-10-23', '16:00', 1),
(2, '2018-10-23', '17:30', 1),
(2, '2018-10-23', '19:00', 1),
(2, '2018-10-23', '20:30', 1),
(2, '2018-10-23', '22:00', 1),
(2, '2018-10-24', '11:00', 1),
(2, '2018-10-24', '12:30', 1),
(2, '2018-10-24', '16:00', 1),
(2, '2018-10-24', '17:30', 1),
(2, '2018-10-24', '19:00', 1),
(2, '2018-10-24', '20:30', 1),
(2, '2018-10-24', '22:00', 1),
(2, '2018-10-25', '11:00', 1),
(2, '2018-10-25', '12:30', 1),
(2, '2018-10-25', '16:00', 1),
(2, '2018-10-25', '17:30', 1),
(2, '2018-10-25', '19:00', 1),
(2, '2018-10-25', '20:30', 1),
(2, '2018-10-25', '22:00', 1),
(2, '2018-10-26', '11:00', 1),
(2, '2018-10-26', '12:30', 1),
(2, '2018-10-26', '16:00', 1),
(2, '2018-10-26', '17:30', 1),
(2, '2018-10-26', '19:00', 1),
(2, '2018-10-26', '20:30', 1),
(2, '2018-10-26', '22:00', 1),
(2, '2018-10-27', '11:00', 1),
(2, '2018-10-27', '12:30', 1),
(2, '2018-10-27', '16:00', 1),
(2, '2018-10-27', '17:30', 1),
(2, '2018-10-27', '19:00', 1),
(2, '2018-10-27', '20:30', 1),
(2, '2018-10-27', '22:00', 1),
(2, '2018-10-28', '11:00', 1),
(2, '2018-10-28', '12:30', 1),
(2, '2018-10-28', '16:00', 1),
(2, '2018-10-28', '17:30', 1),
(2, '2018-10-28', '19:00', 1),
(2, '2018-10-28', '20:30', 1),
(2, '2018-10-28', '22:00', 1),
(2, '2018-10-29', '11:00', 1),
(2, '2018-10-29', '12:30', 1),
(2, '2018-10-29', '16:00', 1),
(2, '2018-10-29', '17:30', 1),
(2, '2018-10-29', '19:00', 1),
(2, '2018-10-29', '20:30', 1),
(2, '2018-10-29', '22:00', 1),
(3, '2018-10-23', '11:00', 1),
(3, '2018-10-23', '12:30', 1),
(3, '2018-10-23', '16:00', 1),
(3, '2018-10-23', '17:30', 1),
(3, '2018-10-23', '19:00', 1),
(3, '2018-10-23', '20:30', 1),
(3, '2018-10-23', '22:00', 1),
(3, '2018-10-24', '11:00', 1),
(3, '2018-10-24', '12:30', 1),
(3, '2018-10-24', '16:00', 1),
(3, '2018-10-24', '17:30', 1),
(3, '2018-10-24', '19:00', 1),
(3, '2018-10-24', '20:30', 1),
(3, '2018-10-24', '22:00', 1),
(3, '2018-10-25', '11:00', 1),
(3, '2018-10-25', '12:30', 1),
(3, '2018-10-25', '16:00', 1),
(3, '2018-10-25', '17:30', 1),
(3, '2018-10-25', '19:00', 1),
(3, '2018-10-25', '20:30', 1),
(3, '2018-10-25', '22:00', 1),
(3, '2018-10-26', '11:00', 1),
(3, '2018-10-26', '12:30', 1),
(3, '2018-10-26', '16:00', 1),
(3, '2018-10-26', '17:30', 1),
(3, '2018-10-26', '19:00', 1),
(3, '2018-10-26', '20:30', 1),
(3, '2018-10-26', '22:00', 1),
(3, '2018-10-27', '11:00', 1),
(3, '2018-10-27', '12:30', 1),
(3, '2018-10-27', '16:00', 1),
(3, '2018-10-27', '17:30', 1),
(3, '2018-10-27', '19:00', 1),
(3, '2018-10-27', '20:30', 1),
(3, '2018-10-27', '22:00', 1),
(3, '2018-10-28', '11:00', 1),
(3, '2018-10-28', '12:30', 1),
(3, '2018-10-28', '16:00', 1),
(3, '2018-10-28', '17:30', 1),
(3, '2018-10-28', '19:00', 1),
(3, '2018-10-28', '20:30', 1),
(3, '2018-10-28', '22:00', 1),
(3, '2018-10-29', '11:00', 1),
(3, '2018-10-29', '12:30', 1),
(3, '2018-10-29', '16:00', 1),
(3, '2018-10-29', '17:30', 1),
(3, '2018-10-29', '19:00', 1),
(3, '2018-10-29', '20:30', 1),
(3, '2018-10-29', '22:00', 1),
(4, '2018-10-23', '11:00', 1),
(4, '2018-10-23', '12:30', 1),
(4, '2018-10-23', '16:00', 1),
(4, '2018-10-23', '17:30', 1),
(4, '2018-10-23', '19:00', 1),
(4, '2018-10-23', '20:30', 1),
(4, '2018-10-23', '22:00', 1),
(4, '2018-10-24', '11:00', 1),
(4, '2018-10-24', '12:30', 1),
(4, '2018-10-24', '16:00', 1),
(4, '2018-10-24', '17:30', 1),
(4, '2018-10-24', '19:00', 1),
(4, '2018-10-24', '20:30', 1),
(4, '2018-10-24', '22:00', 1),
(4, '2018-10-25', '11:00', 1),
(4, '2018-10-25', '12:30', 1),
(4, '2018-10-25', '16:00', 1),
(4, '2018-10-25', '17:30', 1),
(4, '2018-10-25', '19:00', 1),
(4, '2018-10-25', '20:30', 1),
(4, '2018-10-25', '22:00', 1),
(4, '2018-10-26', '11:00', 1),
(4, '2018-10-26', '12:30', 1),
(4, '2018-10-26', '16:00', 1),
(4, '2018-10-26', '17:30', 1),
(4, '2018-10-26', '19:00', 1),
(4, '2018-10-26', '20:30', 1),
(4, '2018-10-26', '22:00', 1),
(4, '2018-10-27', '11:00', 1),
(4, '2018-10-27', '12:30', 1),
(4, '2018-10-27', '16:00', 1),
(4, '2018-10-27', '17:30', 1),
(4, '2018-10-27', '19:00', 1),
(4, '2018-10-27', '20:30', 1),
(4, '2018-10-27', '22:00', 1),
(4, '2018-10-28', '11:00', 1),
(4, '2018-10-28', '12:30', 1),
(4, '2018-10-28', '16:00', 1),
(4, '2018-10-28', '17:30', 1),
(4, '2018-10-28', '19:00', 1),
(4, '2018-10-28', '20:30', 1),
(4, '2018-10-28', '22:00', 1),
(4, '2018-10-29', '11:00', 1),
(4, '2018-10-29', '12:30', 1),
(4, '2018-10-29', '16:00', 1),
(4, '2018-10-29', '17:30', 1),
(4, '2018-10-29', '19:00', 1),
(4, '2018-10-29', '20:30', 1),
(4, '2018-10-29', '22:00', 1);

--
-- Volcado de datos para la tabla `promociones`
--

INSERT INTO `promociones` (`Fecha`, `Hora`) VALUES
('2018-10-23', '12:30'),
('2018-10-23', '16:00');

--
-- Volcado de datos para la tabla `reserva`
--

INSERT INTO `reserva` (`Usuario_Dni`, `Pista_idPista`, `Pista_Fecha`, `Pista_Hora`) VALUES
('52349896X', 1, '2018-10-23', '11:00'),
('50890587M', 1, '2018-10-23', '17:30');

INSERT INTO `enfrentamiento` (`IdCampeonato`, `Tipo`, `Nivel`, `Letra`, `NumEnfrentamiento`, `NumPareja`, `Resultado`) VALUES 
('1', 'Femenino', '1', 'A', '1', '1', NULL),
 ('1', 'Femenino', '1', 'A', '1', '2', NULL),
 ('1', 'Femenino', '1', 'A', '2', '1', NULL),
 ('1', 'Femenino', '1', 'A', '2', '2', NULL);
 
 
SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
