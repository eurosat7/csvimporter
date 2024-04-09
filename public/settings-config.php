<?php

declare(strict_types=1);

use Eurosat7\Csvimporter\Settings\SettingsConfig;

return new SettingsConfig(
    dirname(__DIR__, 1) . '/settings.json'
);