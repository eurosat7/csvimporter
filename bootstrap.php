<?php

declare(strict_types=1);

// should be served by docker at http://localhost:8089/public/
// > make init

use Eurosat7\Csvimporter\Controller\CsvImportController;
use Eurosat7\Csvimporter\Database\Repository\ProductRepository;
use Eurosat7\Csvimporter\InstanceContainer;
use Eurosat7\Csvimporter\Services\FileToEntitysConverter;
use Eurosat7\Csvimporter\Services\FileTools;

require __DIR__ . '/vendor/autoload.php';

/** @var InstanceContainer $config */
$config = require __DIR__ . '/instanceContainer.php';
$te = $config->templateEngine;

// as you can see the router component is missing
// this code can currently only serve one page calles "index" running the CsvImportController

$controller = new CsvImportController(
    productRepository: new ProductRepository($config->databaseHandler),
    fileTools: new FileTools(),
    fileToEntitysConverter: new FileToEntitysConverter()
);

$te->setController($controller);
$controller->setFile($_FILES['file']['tmp_name'] ?? null);

$te->page(
    'index',
    [
        'title' => 'Upload example'
    ]
);
