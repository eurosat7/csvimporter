CREATE DATABASE IF NOT EXISTS csv;
USE csv;

/* passwords and stuff should be protected and not be commited into git! */

CREATE USER IF NOT EXISTS "csvimporter"@"%" IDENTIFIED BY 'csvimporterpassword';
GRANT ALL ON csv.* TO "csvimporter"@"%";

CREATE TABLE IF NOT EXISTS Entity
(
    id          BIGINT       NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name        VARCHAR(255) NOT NULL UNIQUE,
    description TEXT         NOT NULL,
    cost        FLOAT        NOT NULL DEFAULT 0.0,
    amount      INT          NOT NULL DEFAULT 0
);

TRUNCATE Entity;
