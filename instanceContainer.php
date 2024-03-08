<?php

declare(strict_types=1);

// consider this being your config
// passwords and stuff should be protected and not be commited into git!

use Eurosat7\Csvimporter\Database\Handler\MySql;
use Eurosat7\Csvimporter\InstanceContainer;
use Eurosat7\Csvimporter\Services\TemplateEngine;

return new InstanceContainer(
    databaseHandler: new MySql(
        host: 'mysql-csvimporter:3306',
        user: 'csvimporter',
        password: 'csvimporterpassword',
        database: 'csv'
    ),
    templateEngine: new TemplateEngine(__DIR__ . '/templates')
);
