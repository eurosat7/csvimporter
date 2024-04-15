<?php

declare(strict_types=1);

use Eurosat7\Csvimporter\Settings\SettingsConfig;
use Eurosat7\Csvimporter\Settings\SettingsManager;

require dirname(__DIR__, 1) . '/vendor/autoload.php';

/** @var SettingsConfig $config */
$config = require __DIR__ . '/settings-config.php';
$settingsManager = new SettingsManager($config);

?><!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <link rel="stylesheet" href="assets/theme/minimum.css">
    <link rel="stylesheet" href="assets/settings-switch/index.css">
</head>
<body>
<?php
$saved_settings = $settingsManager->read();

foreach ($config->allowed as $setting) {
    $classnames = 'settings-switch';
    if (($saved_settings[$setting] ?? '-1') === '1') {
        $classnames .= ' switched-on';
    } ?>
    <div class="<?php echo $classnames; ?>" data-id="<?php echo $setting; ?>">
        <?php echo $setting; ?>
    </div>

    <?php
}
?>
</body>
<script src="assets/settings-switch/index.js" type="module" async></script>
</html>
