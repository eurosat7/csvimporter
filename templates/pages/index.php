<?php

declare(strict_types=1);

use Eurosat7\Csvimporter\Controller\CsvImportController;
use Eurosat7\Csvimporter\Services\TemplateEngine;

/**
 * @var CsvImportController $controller
 * @var TemplateEngine $te
 * @var array<string,mixed> $vars
 */

$controller->setFile($_FILES['file']['tmp_name'] ?? null);

$te->defaults('header', $vars); // allthough this looks cool we have no auto completion; Our IDE cannot help us!
?>

    <form method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="file">csv file</label>
            <input type="file" name="file"/>
        </div>
        <div class="form-group">
            <input type="submit" value="upload and import"/>
        </div>
    </form>
    <pre><?php
        $controller->process(); ?></pre>

<?php
$te->defaults('debug'); ?>
<?php
$te->defaults('footer');
