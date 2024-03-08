CREATE DATABASE IF NOT EXISTS `csv`;
USE `csv`;

/* passwords and stuff should be protected and not be commited into git! */

CREATE USER IF NOT EXISTS "csvimporter"@"%" IDENTIFIED BY 'csvimporterpassword';
GRANT ALL ON `csv`.* TO "csvimporter"@"%";

CREATE TABLE IF NOT EXISTS `Product`
(
    `id` bigint NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `name` varchar(255) NOT NULL UNIQUE,
    `description` text NOT NULL,
    `cost` float NOT NULL DEFAULT 0.0,
    `amount` int NOT NULL DEFAULT 0
);

TRUNCATE `Product`;
