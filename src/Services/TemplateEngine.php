<?php
declare(strict_types=1);

namespace Eurosat7\Csvimporter\Services;

// please use a real template engine in your projects.
// good ones are: blade (used in laravel), twig (used in symfony)
// they support extending and overriding parts and are amazing! :)
// Compared to twig or blade this is just crap!
use Eurosat7\Csvimporter\Controller\ControllerInterface;

class TemplateEngine
{
    private ?ControllerInterface $controller = null; // code smell, controller might not be defined!

    public function __construct(
        private string $rootdir
    )
    {
        $this->rootdir = rtrim($this->rootdir, "/") . "/";
    }

    public function setController(ControllerInterface $controller): void
    {
        $this->controller = $controller;
    }

    /**
     * @param array<string,mixed> $vars
     */
    public function incl(string $template_engine_path, array $vars = []): void
    {
        $template_engine_path = ltrim($template_engine_path, "/");

        extract($vars); // bad style! On top of that: To make overriding the first parameter harder we named it stupidly long :(

        $te = $this;
        $controller = $this->controller;

        /** @psalm-suppress UnresolvableInclude */
        include($this->rootdir . $template_engine_path);
    }

    /**
     * @param array<string,mixed> $vars
     */
    public function page(string $template_engine_path, array $vars = []): void
    {
        if (!$this->controller instanceof ControllerInterface) { // having to do this is a hint -> bad style
            throw new \RuntimeException('set controller in template engine first!');
        }
        $template_engine_path = preg_replace('/\.php$/', '', $template_engine_path) . ".php";
        $template_engine_path = "pages/" . ltrim($template_engine_path, "/");
        $this->incl($template_engine_path, $vars);
    }

    /**
     * @param array<string,mixed> $vars
     */
    public function defaults(string $template_engine_path, array $vars = []): void
    {
        $template_engine_path = preg_replace('/\.php$/', '', $template_engine_path) . ".php";
        $template_engine_path = "defaults/" . ltrim($template_engine_path, "/");
        $this->incl($template_engine_path, $vars);
    }
}