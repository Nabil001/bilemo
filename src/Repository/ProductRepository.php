<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\ORM\EntityRepository;

class ProductRepository extends EntityRepository
{
    /**
     * @param int $id
     * @return Product|null
     */
    public function findWithJoins(int $id): ?Product
    {
        $products = $this->createQueryBuilder('p')
            ->join('p.productFeatures', 'f')
            ->addSelect('f')
            ->where('p.id = :id')
            ->setParameter(':id', $id)
            ->getQuery()
            ->getResult();

        return $products[0] ?? null;
    }
}