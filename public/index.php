<?php
// should be served by docker at http://localhost:8089/public/
// > make init
declare(strict_types=1);

use Eurosat7\Csvimporter\CsvImportController;
use Eurosat7\Csvimporter\EntityRepository;
use Eurosat7\Csvimporter\FileToEntitysConverter;
use Eurosat7\Csvimporter\FileTools;

$config = include(dirname(__DIR__) . '/bootstrap.php');
$fileTools = new FileTools();
$entityRepository = new EntityRepository($config["mysqlConnection"]);
$fileToEntitysConverter = new FileToEntitysConverter();
$controller = new CsvImportController($entityRepository, $fileTools, $fileToEntitysConverter);

?><!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <title>upload test</title>
    <link rel="stylesheet" href="assets/minimum.css"/>
</head>
<body>
<h1>Upload example</h1>
<form method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="file">csv file</label>
        <input type="file" name="file"/>
    </div>
    <div class="form-group">
        <input type="submit" value="upload and import"/>
    </div>
</form>
<pre><?php $controller->process($_FILES['file']['tmp_name'] ?? null); ?></pre>
<h2>debug</h2>
<pre>post_max_size: <?php echo ini_get("post_max_size"); ?></pre>
<pre>upload_max_filesize: <?php echo ini_get("upload_max_filesize"); ?></pre>
</body>
</html>
