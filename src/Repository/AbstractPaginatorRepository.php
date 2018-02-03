<?php

namespace App\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Hateoas\Configuration\Route;
use Hateoas\Representation\Factory\PagerfantaFactory;
use Hateoas\Representation\PaginatedRepresentation;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Component\HttpFoundation\Request;

abstract class AbstractPaginatorRepository extends EntityRepository
{
    /**
     * @param QueryBuilder $builder
     * @param int $page
     * @param int $limit
     * @param $parameters
     * @return PaginatedRepresentation
     */
    public function paginate(QueryBuilder $builder, int $page, int $limit, array $parameters, Request $request): PaginatedRepresentation
    {
        if (0 >= $page || 0 >= $limit) {
            throw new \LogicException('Page and limit parameters can\'t be inferior to 1');
        }

        $pager = new Pagerfanta(new DoctrineORMAdapter($builder));
        $pager->setMaxPerPage($limit)->setCurrentPage($page);

        return (new PagerfantaFactory())->createRepresentation(
            $pager,
            new Route($request->get('_route'), $parameters)
        );
    }
}