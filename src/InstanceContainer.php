<?php

declare(strict_types=1);

namespace Eurosat7\Csvimporter;

use Eurosat7\Csvimporter\Database\Handler\DatabaseHandler;
use Eurosat7\Csvimporter\Database\Handler\HasTransaction;
use Eurosat7\Csvimporter\Services\TemplateEngine;

readonly class InstanceContainer
{
    public function __construct(
        public DatabaseHandler&HasTransaction $databaseHandler,
        public TemplateEngine $templateEngine
    ) {
    }
}
