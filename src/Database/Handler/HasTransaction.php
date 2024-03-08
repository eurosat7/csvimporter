<?php

declare(strict_types=1);

namespace Eurosat7\Csvimporter\Database\Handler;

interface HasTransaction
{
    public function transactionBegin(): void;

    public function transactionCommit(): void;
}
