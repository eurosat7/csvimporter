<?php

declare(strict_types=1);

namespace Eurosat7\Csvimporter\Database\Handler;

interface DatabaseHandler
{
    /**
     * @param array<int, array{0:string,1:string,2:int|string|float|bool|null}> $struct
     */
    public function insertIgnore(string $table, array $struct): bool;
}
