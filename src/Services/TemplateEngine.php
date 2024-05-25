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
    private const CONTENT = "TE_CONTENT";

    /** @var array<string,mixed|string> $var */
    private array $var = [
        self::CONTENT => "",
    ];

    public function __construct(
        private string $rootdir
    )
    {
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
        $this->setVars($vars);

        $te = $this;

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
        if ($vars === []) {
            $vars = $this->var;
        }
        $templateEnginePath = preg_replace('/\.php$/', '', $templateEnginePath) . '.php';
        $templateEnginePath = 'defaults/' . ltrim($templateEnginePath, '/');
        $this->incl($templateEnginePath, $vars);
    }

    public function esc(mixed $string): void
    {
        if (!is_string($string)) {
            $string = $this->stringify($string);
        }
        echo htmlspecialchars($string);
    }

    public function escVar(string $var): void
    {
        $this->esc($this->stringify($this->getVar($var)));
    }

    public function getVar(string $var): mixed
    {
        return $this->var[$var];
    }

    public function setVar(string $var, mixed $value): void
    {
        $this->var[$var] = $value;
    }

    /**
     * @param array<string,mixed> $values
     */
    public function setVars(array $values): void
    {
        /** @psalm-suppress  MixedAssignment */
        foreach ($values as $key => $value) {
            $this->setVar($key, $value);
        }
    }

    public function setContentByController(CanProcess $controller): void
    {
        ob_start();
        $controller->process();
        $content = ob_get_clean();
        if ($content === false) {
            $content = "";
        }
        $this->setVar(self::CONTENT, $content);
    }

    public function writeContent(): void
    {
        echo $this->stringify($this->getVar(self::CONTENT));
    }

    private function stringify(mixed $value): string
    {
        if (is_string($value)) {
            return $value;
        }
        if ($value === null) {
            return "";
        }
        if ($value instanceof \DateTime) {
            return $value->format('d.m.Y H:i:s');
        }
        if (is_object($value) && method_exists($value, '__toString')) {
            /** @var string $string */
            $string = $value->__toString();
            return $string;
        }
        if (is_scalar($value)) {
            return (string) $value;
        }
        throw new RuntimeException('cannot stringify $value');
    }
}
