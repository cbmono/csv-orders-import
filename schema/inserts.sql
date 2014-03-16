-- -----------------------------------------------------
-- Table `returbo`.`products`
-- -----------------------------------------------------
TRUNCATE TABLE `returbo`.`products`;
INSERT INTO  `returbo`.`products` (
  `id`,
  `sku`,
  `name`,
  `price_unit`,
  `created`,
  `modified`
)
VALUES
  -- ----------------------
  -- partnerA.csv
  -- ----------------------
  (NULL, '9007770011431', 'Sitzsack "FettSack" Rot CKDC1072900', 22, NOW( ), NOW( )), 
  -- ----------------------
  -- partnerB.csv
  -- ----------------------
  (NULL, 'SPSCH30902002N', '', 60.19, NOW( ), NOW( ))
;


-- -----------------------------------------------------
-- Table `returbo`.`customers`
-- -----------------------------------------------------
TRUNCATE TABLE `returbo`.`customers`;
INSERT INTO  `returbo`.`customers` (
  `id`,
  `first_name`,
  `last_name`,
  `email`,
  `phone`,
  `created`,
  `modified`
)
VALUES 
  -- ----------------------
  -- partnerA.csv
  -- ----------------------
  (NULL, 'John', 'Smith A', NULL, NULL, NOW( ), NOW( )), 
  (NULL, 'John', 'Smith B', NULL, NULL, NOW( ), NOW( )), 
  (NULL, 'John', 'Smith C', NULL, NULL, NOW( ), NOW( )),
  (NULL, 'John', 'Smith D', NULL, NULL, NOW( ), NOW( )),
  -- ----------------------
  -- partnerB.csv
  -- ----------------------
  (NULL, 'John', 'Smith E', 'name1@returbo.de', '29664566', NOW( ), NOW( )),
  (NULL, 'John', 'Smith F', 'name2@returbo.de', '28729052', NOW( ), NOW( )),
  (NULL, 'John', 'Smith G', 'name3@returbo.de', '21833521', NOW( ), NOW( )),
  (NULL, 'John', 'Smith H', 'name4@returbo.de', '40335020', NOW( ), NOW( )),
  (NULL, 'John', 'Smith I', 'name5@returbo.de', '28140158', NOW( ), NOW( ))
;


-- -----------------------------------------------------
-- Table `returbo`.`customer_addresses`
-- -----------------------------------------------------
TRUNCATE TABLE `returbo`.`customer_addresses`;
INSERT INTO  `returbo`.`customer_addresses` (
  `id`,
  `customer_id`,
  `first_name`,
  `last_name`,
  `company`,
  `street_1`,
  `street_2`,
  `zipcode`,
  `city`,
  `state`,
  `country_code`,
  `created`,
  `modified`
)
VALUES 
  -- ----------------------
  -- partnerA.csv
  -- ----------------------
  (NULL, 1, 'John', 'Smith A', NULL, 'Big Street 1', '', '64572', 'Big City', NULL, 'DE', NOW( ), NOW( )), 
  (NULL, 2, 'John', 'Smith B', NULL, 'Small Street 15', '', '36341', 'Big City', NULL, 'DE', NOW( ), NOW( )), 
  (NULL, 3, 'John', 'Smith C', NULL, 'Long Street 56', '', '47918', 'Big City', NULL, 'DE', NOW( ), NOW( )), 
  (NULL, 4, 'John', 'Smith D', NULL, 'Another Street 66', '', '96052', 'Big City', NULL, 'DE', NOW( ), NOW( )), 
  -- ----------------------
  -- partnerB.csv
  -- ----------------------
  (NULL, 5, 'John', 'Smith E', NULL, 'Heibergsvej2', '', '8600', 'Silkeborg', NULL, 'DK', NOW( ), NOW( )), 
  (NULL, 6, 'John', 'Smith F', NULL, 'Neckelmannsgade18', '1. Tv', '4800', 'Nykøbing F', NULL, 'DK', NOW( ), NOW( )), 
  (NULL, 7, 'John', 'Smith G', NULL, 'Vestergade83', '2.tv', '8600', 'Silkeborg', NULL, 'DK', NOW( ), NOW( )), 
  (NULL, 8, 'John', 'Smith H', NULL, 'Hjortekærskrænten10', '', '2800', 'Kgs. Lyngby', NULL, 'DK', NOW( ), NOW( )), 
  (NULL, 9, 'John', 'Smith I', NULL, 'Dybkærvænget10', '', '2640', 'Hedehusene', NULL, 'DK', NOW( ), NOW( ))
;


-- -----------------------------------------------------
-- Table `returbo`.`orders`
-- -----------------------------------------------------
TRUNCATE TABLE `returbo`.`orders`;
INSERT INTO  `returbo`.`orders` (
  `id`,
  `customer_id`,
  `shippment_address_id`,
  `invoice_address_id`,
  `grand_total`,
  `created`,
  `modified`
)
VALUES 
  -- ----------------------
  -- partnerA.csv
  -- ----------------------
  (NULL, 1, 1, 1, 22, '2013-11-01 00:00:00', '2013-11-01 00:00:00'), 
  (NULL, 2, 2, 2, 14, '2013-11-01 00:00:00', '2013-11-01 00:00:00'), 
  (NULL, 3, 3, 3, 15, '2013-11-29 00:00:00', '2013-11-01 00:00:00'), 
  (NULL, 4, 4, 4, 16, '2013-11-31 00:00:00', '2013-11-01 00:00:00'), 
  -- ----------------------
  -- partnerB.csv
  -- ----------------------
  (NULL, 5, 5, 5, 66, '2013-10-08 17:11:50', '2013-10-08 17:11:50'), 
  (NULL, 6, 6, 6, 66, '2013-10-08 17:11:50', '2013-10-08 17:11:50'), 
  (NULL, 7, 7, 7, 66, '2013-10-08 17:11:50', '2013-10-08 17:11:50'), 
  (NULL, 8, 8, 8, 66, '2013-10-08 17:11:50', '2013-10-08 17:11:50'), 
  (NULL, 9, 9, 9, 66, '2013-10-08 17:11:50', '2013-10-08 17:11:50')
;


-- -----------------------------------------------------
-- Table `returbo`.`order_items`
-- -----------------------------------------------------
TRUNCATE TABLE `returbo`.`order_items`;
INSERT INTO  `returbo`.`order_items` (
  `id`,
  `order_id`,
  `product_id`,
  `quantity`,
  `price_unit`
)
VALUES 
  -- ----------------------
  -- partnerA.csv
  -- ----------------------
  (NULL, 1, 1, 1, 22), 
  (NULL, 2, 1, 1, 14), 
  (NULL, 3, 1, 1, 15), 
  (NULL, 4, 1, 1, 16), 
  -- ----------------------
  -- partnerB.csv
  -- ----------------------
  (NULL, 5, 2, 1, 60.19), 
  (NULL, 6, 2, 1, 60.19), 
  (NULL, 7, 2, 1, 60.19), 
  (NULL, 8, 2, 1, 60.19), 
  (NULL, 9, 2, 1, 60.19)
;