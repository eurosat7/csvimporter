<?php
declare(strict_types=1);

namespace Eurosat7\Csvimporter\Database;

class Entity
{
    public function __construct(
        public string $name,
        public string $description,
        public float  $cost,
        public ?int   $amount = 0,
        public ?int   $id = null,
    )
    {
    }
}
