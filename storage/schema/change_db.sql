-- Upgrading vRent 2.9 to 3.1


ALTER TABLE `properties` ADD `slug` VARCHAR(100) NULL DEFAULT NULL AFTER `name`;

ALTER TABLE `property_dates` ADD `min_stay` TINYINT(4) NOT NULL DEFAULT '0' AFTER `price`;
ALTER TABLE `property_dates` ADD `min_day` INT(10) NULL AFTER `min_stay`;

INSERT INTO `property_fees` (`id`, `field`, `value`) VALUES (NULL, 'iva_tax', '0'), (NULL, 'accomodation_tax', '0');

ALTER TABLE `bookings` ADD `iva_tax` DOUBLE NOT NULL DEFAULT '0' AFTER `security_money`, ADD `accomodation_tax` DOUBLE NOT NULL DEFAULT '0' AFTER `iva_tax`;
ALTER TABLE `bookings` ADD `date_with_price` VARCHAR(255) NULL AFTER `accomodation_tax`;
