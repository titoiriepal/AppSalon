# SQL query for create schema appSalon_mvc

-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema appsalon_mvc
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema appsalon_mvc
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `appsalon_mvc` DEFAULT CHARACTER SET utf8 ;
USE `appsalon_mvc` ;

-- -----------------------------------------------------
-- Table `appsalon_mvc`.`usuarios`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `appsalon_mvc`.`usuarios` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(60) NULL,
  `apellido` VARCHAR(60) NULL,
  `email` VARCHAR(30) NULL,
  `telefono` VARCHAR(12) NULL,
  `admin` TINYINT NULL,
  `confirmado` TINYINT NULL,
  `token` VARCHAR(15) NULL,
  `activo` TINYINT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `appsalon_mvc`.`servicios`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `appsalon_mvc`.`servicios` (
  `id` INT(11) NOT NULL,
  `nombre` VARCHAR(60) NULL,
  `precio` DECIMAL(5,2) NULL,
  `activo` TINYINT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `appsalon_mvc`.`citas`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `appsalon_mvc`.`citas` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `fecha` DATE NULL,
  `hora` TIME NULL,
  `usuarioId` INT(11) NULL,
  `activo` TINYINT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_citas_usuarios_idx` (`usuarioId` ASC) VISIBLE,
  CONSTRAINT `fk_citas_usuarios`
    FOREIGN KEY (`usuarioId`)
    REFERENCES `appsalon_mvc`.`usuarios` (`id`)
    ON DELETE SET NULL
    ON UPDATE SET NULL)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `appsalon_mvc`.`citasServicios`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `appsalon_mvc`.`citasServicios` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `citaId` INT(11) NULL,
  `servicioId` INT(11) NULL,
  `precio` DECIMAL(5,2) NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_citasServicios_citas1_idx` (`citaId` ASC) VISIBLE,
  INDEX `fk_citasServicios_servicios1_idx` (`servicioId` ASC) VISIBLE,
  CONSTRAINT `fk_citasServicios_citas1`
    FOREIGN KEY (`citaId`)
    REFERENCES `appsalon_mvc`.`citas` (`id`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT,
  CONSTRAINT `fk_citasServicios_servicios1`
    FOREIGN KEY (`servicioId`)
    REFERENCES `appsalon_mvc`.`servicios` (`id`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
