<?php

declare(strict_types=1);

namespace Eurosat7\Csvimporter\Database\Repository;

use Eurosat7\Csvimporter\Database\Entity\Entity;
use Eurosat7\Csvimporter\Database\Handler\DatabaseHandler;
use Eurosat7\Csvimporter\Database\Handler\HasTransaction;

abstract class TransactionalRepository implements HasTransaction
{
    public function __construct(
        private readonly DatabaseHandler&HasTransaction $databaseHandler
    ) {
    }

    public function transactionBegin(): void
    {
        $this->databaseHandler->transactionBegin();
    }

    public function transactionCommit(): void
    {
        $this->databaseHandler->transactionCommit();
    }

    abstract public function save(Entity $entity): bool;

    public function getDatabaseHandler(): DatabaseHandler
    {
        return $this->databaseHandler;
    }
}
