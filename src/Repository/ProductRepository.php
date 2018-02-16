<?php

namespace App\Repository;

use App\Entity\Product;
use Hateoas\Representation\PaginatedRepresentation;

class ProductRepository extends AbstractPaginatorRepository
{
    /**
     * @param int $id
     * @return Product|null
     */
    public function findWithJoins(int $id): ?Product
    {
        $products = $this->createQueryBuilder('p')
            ->leftJoin('p.productFeatures', 'f')
            ->addSelect('f')
            ->where('p.id = :id')
            ->setParameter(':id', $id)
            ->getQuery()
            ->getResult();

        return $products[0] ?? null;
    }

    /**
     * @param int         $page
     * @param int         $limit
     * @param null|string $term
     * @param string      $route
     * @return PaginatedRepresentation
     */
    public function search(int $page, int $limit, ?string $term, string $route): PaginatedRepresentation
    {
        $parameters = [];
        $builder = $this->createQueryBuilder('p');

        if (!empty($term)) {
            $builder->where($builder->expr()->like('p.name', ':term'))
                ->setParameter('term', '%'.$term.'%');
            $parameters['term'] = $term;
        }

        return parent::paginate($builder, $page, $limit, $parameters, $route);
    }
}