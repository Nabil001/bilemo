<?php

namespace App\Repository;

use App\Entity\Client;
use App\Entity\User;
use Hateoas\Representation\PaginatedRepresentation;

class UserRepository extends AbstractPaginatorRepository
{
    /**
     * @param int $id
     * @param Client $client
     * @return User|null
     */
    public function getClientUser(int $id, Client $client): ?User
    {
        $clientUser = $this->createQueryBuilder('u')
            ->innerJoin('u.client', 'c')
            ->where('u.id = :uid')
            ->andWhere('c.id = :cid')
            ->setParameter('uid', $id)
            ->setParameter('cid', $client->getId())
            ->getQuery()
            ->getResult();

        return $clientUser[0] ?? null;
    }

    /**
     * @param int $page
     * @param int $limit
     * @param null|string $term
     * @param string $route
     * @param Client $client
     * @return PaginatedRepresentation
     */
    public function search(int $page, int $limit, ?string $term, string $route, Client $client): PaginatedRepresentation
    {
        $parameters = [];
        $builder = $this->createQueryBuilder('u')
            ->innerJoin('u.client', 'c')
            ->where('c.id = :id')
            ->setParameter('id', $client->getId());

        if (!empty($term)) {
            $builder->andWhere($builder->expr()->orX(
                $builder->expr()->like('u.firstname', ':term'),
                $builder->expr()->like('u.lastname', ':term')
            ))
                ->setParameter('term', $term.'%');
            $parameters['term'] = $term;
        }

        return parent::paginate($builder, $page, $limit, $parameters, $route);
    }
}