<?php
declare(strict_types=1);

use Eurosat7\Csvimporter\MySqlConnection;

include(__DIR__ . "/vendor/autoload.php");

return [
    'mysqlConnection' => new MySqlConnection(
        host: "mysql-csvimporter:3306",
        user: "csvimporter",
        password: "csvimporterpassword",
        database: "csv"
    ),
];