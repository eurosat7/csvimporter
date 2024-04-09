<?php

declare(strict_types=1);

use Eurosat7\Csvimporter\Settings\SettingsConfig;
use Eurosat7\Csvimporter\Settings\SettingsManager;

require dirname(__DIR__, 1) . '/vendor/autoload.php';

/** @var SettingsConfig $config */

$config = require __DIR__ . '/settings-config.php';
$settingsManager = new SettingsManager($config);
$id = $_REQUEST['id'] ?? 'undefined';
if (is_array($id)) {
    echo 'invalid';
    die;
}
/** @var string $id */
$status = $_REQUEST['status'] === '1' ? '1' : '-1';

usleep(500_000);
$settings = $settingsManager->read();
$settingsManager->modify($id, $status);
$length = $settingsManager->write();
if ($length < 0) {
    header('http-status: 500');
}

echo $length;
