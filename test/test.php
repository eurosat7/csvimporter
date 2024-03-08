<?php
// please run from inside docker.
// > make docker-php-test

declare(strict_types=1);

use Eurosat7\Csvimporter\Controller\CsvImportController;
use Eurosat7\Csvimporter\Database\Repository\ProductRepository;
use Eurosat7\Csvimporter\InstanceContainer;
use Eurosat7\Csvimporter\Services\FileToEntitysConverter;
use Eurosat7\Csvimporter\Services\FileTools;

require dirname(__DIR__) . '/vendor/autoload.php';

$filename = dirname(__DIR__) . '/generated_entities_for_testing.csv';
if (!file_exists($filename)) {
    die('please run first: make docker-php-csv');
}
/** @var InstanceContainer $config */
$config = require dirname(__DIR__) . '/instanceContainer.php';

$controller = new CsvImportController(
    productRepository: new ProductRepository($config->databaseHandler),
    fileTools: new FileTools(),
    fileToEntitysConverter: new FileToEntitysConverter()
);
$controller->setFile($filename);
$controller->process();
