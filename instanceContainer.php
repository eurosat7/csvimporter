<?php
declare(strict_types=1);

// consider this being your config
// passwords and stuff should be protected and not be commited into git!

use Eurosat7\Csvimporter\Database\MySqlConnection;
use Eurosat7\Csvimporter\InstanceContainer;
use Eurosat7\Csvimporter\Services\TemplateEngine;

include(__DIR__ . "/vendor/autoload.php");

return new InstanceContainer(
    mysqlConnection: new MySqlConnection(
        host: "mysql-csvimporter:3306",
        user: "csvimporter",
        password: "csvimporterpassword",
        database: "csv"
    ),
    templateEngine: new TemplateEngine(__DIR__ . "/templates")
);