<?php
// please run from inside docker.
// > make docker-php-test

declare(strict_types=1);

use Eurosat7\Csvimporter\CsvImportController;
use Eurosat7\Csvimporter\EntityRepository;
use Eurosat7\Csvimporter\FileToEntitysConverter;
use Eurosat7\Csvimporter\FileTools;

$filename = dirname(__DIR__) . "/generated_entities_for_testing.csv";
if (!file_exists($filename)) {
    die("please run first: make csv");
}
$config = include(dirname(__DIR__) . '/bootstrap.php');
$fileTools = new FileTools();
$entityRepository = new EntityRepository($config["mysqlConnection"]);
$fileToEntitysConverter = new FileToEntitysConverter();
$controller = new CsvImportController($entityRepository, $fileTools, $fileToEntitysConverter);
$controller->process($filename);
