<?php

declare(strict_types=1);

namespace Eurosat7\Csvimporter\Database\Repository;

use Eurosat7\Csvimporter\Database\Entity\Entity;
use Eurosat7\Csvimporter\Database\Entity\Product;

class ProductRepository extends TransactionalRepository
{
    public function save(Entity $entity): bool
    {
        if (!$entity instanceof Product) { // this sucks, but I do not know how to sharpen the type in the declaration - If you know please tell me!
            return false;
        }

        return $this->getDatabaseHandler()->insertIgnore('Product', [
            ['s', 'name', $entity->name],
            ['s', 'description', $entity->description],
            ['d', 'cost', $entity->cost],
            ['i', 'amount', $entity->amount],
        ]);
    }
}
