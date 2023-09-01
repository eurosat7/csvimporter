<?php
declare(strict_types=1);

namespace Eurosat7\Csvimporter;

interface HasTransactionInterface
{
    public function transaction_begin(): void;

    public function transaction_commit(): void;
}