<?php
declare(strict_types=1);

namespace Eurosat7\Csvimporter\Database;

interface HasTransactionInterface
{
    public function transactionBegin(): void;

    public function transactionCommit(): void;
}