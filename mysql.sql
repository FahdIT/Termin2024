-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------
-- -----------------------------------------------------
-- Schema ticket_system
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema ticket_system
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `ticket_system` DEFAULT CHARACTER SET utf8mb4 ;
-- -----------------------------------------------------
-- Schema game2024
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema game2024
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `game2024` DEFAULT CHARACTER SET utf8mb4 ;
USE `ticket_system` ;

-- -----------------------------------------------------
-- Table `ticket_system`.`users`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `ticket_system`.`users` (
  `user_id` INT(11) NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(50) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `email` VARCHAR(100) NOT NULL,
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP(),
  `IsAdmin` TINYINT(4) NOT NULL DEFAULT 0,
  PRIMARY KEY (`user_id`),
  UNIQUE INDEX `username` (`username` ASC),
  UNIQUE INDEX `email` (`email` ASC))
ENGINE = InnoDB
AUTO_INCREMENT = 24
DEFAULT CHARACTER SET = utf8mb4;


-- -----------------------------------------------------
-- Table `ticket_system`.`tickets`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `ticket_system`.`tickets` (
  `ticket_id` INT(11) NOT NULL AUTO_INCREMENT,
  `user_id` INT(11) NOT NULL,
  `title` VARCHAR(255) NOT NULL,
  `description` TEXT NOT NULL,
  `status` ENUM('open', 'closed') NULL DEFAULT 'open',
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP(),
  PRIMARY KEY (`ticket_id`),
  INDEX `user_id` (`user_id` ASC),
  CONSTRAINT `tickets_ibfk_1`
    FOREIGN KEY (`user_id`)
    REFERENCES `ticket_system`.`users` (`user_id`))
ENGINE = InnoDB
AUTO_INCREMENT = 9
DEFAULT CHARACTER SET = utf8mb4;

USE `game2024` ;

-- -----------------------------------------------------
-- Table `game2024`.`users`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `game2024`.`users` (
  `user_id` INT(11) NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(50) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `email` VARCHAR(100) NOT NULL,
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP(),
  `IsAdmin` TINYINT(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`user_id`),
  UNIQUE INDEX `username_unique` (`username` ASC),
  UNIQUE INDEX `email_unique` (`email` ASC))
ENGINE = InnoDB
AUTO_INCREMENT = 9
DEFAULT CHARACTER SET = utf8mb4;


-- -----------------------------------------------------
-- Table `game2024`.`save_files`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `game2024`.`save_files` (
  `save_id` INT(11) NOT NULL AUTO_INCREMENT,
  `user_id` INT(11) NOT NULL,
  `chapter` VARCHAR(255) NOT NULL,
  `description` TEXT NOT NULL,
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP(),
  PRIMARY KEY (`save_id`),
  INDEX `user_id` (`user_id` ASC),
  CONSTRAINT `save_files_ibfk_1`
    FOREIGN KEY (`user_id`)
    REFERENCES `game2024`.`users` (`user_id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
