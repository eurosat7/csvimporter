<?php
declare(strict_types=1);

namespace Eurosat7\Csvimporter;

use Eurosat7\Csvimporter\Database\MySqlConnection;
use Eurosat7\Csvimporter\Services\TemplateEngine;

readonly class InstanceContainer
{
    public function __construct(
        public MySqlConnection $mysqlConnection,
        public TemplateEngine  $templateEngine
    )
    {
    }
}