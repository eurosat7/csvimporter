<?php
declare(strict_types=1);

namespace Eurosat7\Csvimporter\Database;

/**
 * @property MySqlConnection $mysqlConnection
 */
trait HasTransactionTrait
{
    public function transactionBegin(): void
    {
        $this->mysqlConnection->transactionBegin();
    }

    public function transactionCommit(): void
    {
        $this->mysqlConnection->transactionCommit();
    }
}