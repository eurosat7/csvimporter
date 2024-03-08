<?php

declare(strict_types=1);

namespace Eurosat7\Csvimporter\Services;

// please use a real template engine in your projects.
// good ones are: blade (used in laravel), twig (used in symfony)
// they support extending and overriding parts and are amazing! :)
// Compared to twig or blade this is just crap!

use Eurosat7\Csvimporter\Controller\CanProcess;
use RuntimeException;

class TemplateEngine
{
    private ?CanProcess $controller = null; // code smell, controller might not be defined!

    public function __construct(
        private string $rootdir
    ) {
        $this->rootdir = rtrim($this->rootdir, '/') . '/';
    }

    public function setController(CanProcess $controller): void
    {
        $this->controller = $controller;
    }

    /**
     * @param array<string,mixed> $vars
     *
     * @SuppressWarnings(PHPMD.UnusedLocalVariable)
     * @SuppressWarnings(PHPMD.UnusedLocalVariable)
     */
    public function incl(string $templateEnginePath, array $vars = []): void
    {
        $templateEnginePath = $this->rootdir . ltrim($templateEnginePath, '/');

        extract($vars); // bad style! On top of that: To make overriding the first parameter harder we named it stupidly long :(

        $te = $this;
        $controller = $this->controller;

        /** @psalm-suppress UnresolvableInclude */
        require $templateEnginePath;
    }

    /**
     * @param array<string,mixed> $vars
     */
    public function page(string $templateEnginePath, array $vars = []): void
    {
        if (!$this->controller instanceof CanProcess) { // having to do this is a hint -> bad style
            throw new RuntimeException('set controller in template engine first!');
        }
        $templateEnginePath = preg_replace('/\.php$/', '', $templateEnginePath) . '.php';
        $templateEnginePath = 'pages/' . ltrim($templateEnginePath, '/');
        $this->incl($templateEnginePath, $vars);
    }

    /**
     * @param array<string,mixed> $vars
     */
    public function defaults(string $templateEnginePath, array $vars = []): void
    {
        $templateEnginePath = preg_replace('/\.php$/', '', $templateEnginePath) . '.php';
        $templateEnginePath = 'defaults/' . ltrim($templateEnginePath, '/');
        $this->incl($templateEnginePath, $vars);
    }

    public function esc(string $string): void
    {
        echo htmlspecialchars($string);
    }
}
