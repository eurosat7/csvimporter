<?php
declare(strict_types=1);

namespace Eurosat7\Csvimporter\Controller;

interface ControllerInterface
{
    public function process(): void;
}