<?php
declare(strict_types=1);

namespace Eurosat7\Csvimporter;

class EntityRepository
{
    public function __construct(
        private readonly MySqlConnection $mysqlConnection
    )
    {
    }

    public function transaction_begin():void{
        $this->mysqlConnection->transaction_begin();
    }
    public function transaction_commit():void{
        $this->mysqlConnection->transaction_commit();
    }

    public function save(Entity $entity): bool
    {
        return $this->mysqlConnection->insertIgnore("Entity", [
            ["s", "name", $entity->name],
            ["s", "description", $entity->description],
            ["d", "cost", $entity->cost],
            ["i", "amount", $entity->amount],
        ]);
    }
}
