<?php
// should be served by docker at http://localhost:8089/public/
// > make init
declare(strict_types=1);

use Eurosat7\Csvimporter\Controller\CsvImportController;
use Eurosat7\Csvimporter\Database\EntityRepository;
use Eurosat7\Csvimporter\InstanceContainer;
use Eurosat7\Csvimporter\Services\FileToEntitysConverter;
use Eurosat7\Csvimporter\Services\FileTools;

include(__DIR__ . "/vendor/autoload.php");

/** @var InstanceContainer $config */
$config = include(__DIR__ . '/instanceContainer.php');
$te = $config->templateEngine;

// as you can see the router component is missing
// this code can currently only serve one page calles "index" running the CsvImportController

$controller = new CsvImportController(
    entityRepository: new EntityRepository($config->mysqlConnection),
    fileTools: new FileTools(),
    fileToEntitysConverter: new FileToEntitysConverter()
);

$te->setController($controller);
$te->page(
    "index",
    [
        'title' => "Upload example"
    ]
);
