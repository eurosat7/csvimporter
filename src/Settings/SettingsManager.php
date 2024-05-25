<?php

declare(strict_types=1);

namespace Eurosat7\Csvimporter\Settings;

use JsonException;
use RuntimeException;

class SettingsManager
{
    /** @var array<string,string> $settings */
    private array $settings = [];

    public function __construct(
        public readonly SettingsConfig $config
    )
    {
    }

    /**
     * @return array<string,string>
     */
    public function read(): array
    {
        $this->settings = [];
        if (!file_exists($this->config->filename)) {
            return $this->settings;
        }
        $content = file_get_contents($this->config->filename);
        if ($content === false) {
            return $this->settings;
        }
        try {
            /**
             * @var array<string,string> $decoded
             */
            $decoded = json_decode($content, true, 512, JSON_THROW_ON_ERROR);
            $this->settings = $decoded;
        } catch (JsonException $e) {
            return ['error' => $e->getMessage()];
        }
        return $this->settings;
    }

    /** @throws RuntimeException|JsonException */
    public function write(): void
    {
        $jsonEncoded = json_encode($this->settings, JSON_THROW_ON_ERROR | JSON_PRETTY_PRINT);
        $success = file_put_contents($this->config->filename, $jsonEncoded);
        if ($success === false || $success === 0) {
            throw new RuntimeException('unable to save settings');
        }
    }

    public function modify(string $key, string $value): void
    {
        if (in_array($key, $this->config->allowed, true)) {
            $this->settings[$key] = $value;
        }
    }

    /**
     * @return array<string,string>
     */
    public function get(): array
    {
        return $this->settings;
    }
}
