<?php

declare(strict_types=1);

namespace Eurosat7\Csvimporter\Settings;

readonly class SettingsConfig
{
    /**
     * @param array<string> $allowed
     */
    public function __construct(
        public string $filename = 'settings.json',
        public array $allowed = [
            'allow-hide-cursor',
            'use-darkmode',
            'use-zoom'
        ]
    )
    {
    }
}
