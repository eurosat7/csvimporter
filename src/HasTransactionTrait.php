<?php
declare(strict_types=1);

namespace Eurosat7\Csvimporter;

/**
 * @property MySqlConnection $mysqlConnection
 */
trait HasTransactionTrait
{
    public function transaction_begin(): void
    {
        $this->mysqlConnection->transaction_begin();
    }

    public function transaction_commit(): void
    {
        $this->mysqlConnection->transaction_commit();
    }
}