SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';

DROP SCHEMA IF EXISTS `returbo` ;
CREATE SCHEMA IF NOT EXISTS `returbo` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ;
USE `returbo` ;

-- -----------------------------------------------------
-- Table `returbo`.`customers`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `returbo`.`customers` ;

CREATE  TABLE IF NOT EXISTS `returbo`.`customers` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `first_name` VARCHAR(60) NULL ,
  `last_name` VARCHAR(60) NULL ,
  `email` VARCHAR(100) NULL ,
  `phone` VARCHAR(45) NULL ,
  `created` DATETIME NULL ,
  `modified` DATETIME NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `returbo`.`customer_addresses`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `returbo`.`customer_addresses` ;

CREATE  TABLE IF NOT EXISTS `returbo`.`customer_addresses` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `customer_id` INT NOT NULL ,
  `first_name` VARCHAR(45) NOT NULL ,
  `last_name` VARCHAR(45) NOT NULL ,
  `company` VARCHAR(45) NULL ,
  `street_1` VARCHAR(45) NOT NULL ,
  `street_2` VARCHAR(45) NULL ,
  `zipcode` VARCHAR(10) NOT NULL ,
  `city` VARCHAR(45) NOT NULL ,
  `state` VARCHAR(45) NULL ,
  `country_code` VARCHAR(2) NOT NULL ,
  `created` DATETIME NULL ,
  `modified` DATETIME NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `customer_id` (`customer_id` ASC) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `returbo`.`orders`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `returbo`.`orders` ;

CREATE  TABLE IF NOT EXISTS `returbo`.`orders` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `customer_id` INT NOT NULL ,
  `shippment_address_id` INT NOT NULL ,
  `invoice_address_id` INT NOT NULL ,
  `grand_total` FLOAT NOT NULL ,
  `created` DATETIME NULL ,
  `modified` DATETIME NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `customer_id` (`customer_id` ASC) ,
  INDEX `shippment_address_id` (`shippment_address_id` ASC) ,
  INDEX `invoice_address_id` (`invoice_address_id` ASC) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `returbo`.`products`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `returbo`.`products` ;

CREATE  TABLE IF NOT EXISTS `returbo`.`products` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `sku` VARCHAR(45) NULL ,
  `name` VARCHAR(45) NULL ,
  `price_unit` FLOAT NOT NULL ,
  `created` DATETIME NULL ,
  `modified` DATETIME NULL ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `sku` (`sku` ASC) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `returbo`.`order_items`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `returbo`.`order_items` ;

CREATE  TABLE IF NOT EXISTS `returbo`.`order_items` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `order_id` INT NOT NULL ,
  `product_id` INT NOT NULL ,
  `quantity` INT NULL DEFAULT 0 ,
  `price_unit` FLOAT NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `order_id` (`order_id` ASC) ,
  INDEX `product_id` (`product_id` ASC) )
ENGINE = InnoDB;



SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
