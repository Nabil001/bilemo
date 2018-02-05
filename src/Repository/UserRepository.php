<?php

namespace App\Repository;

use App\Entity\Client;
use App\Entity\User;
use Doctrine\ORM\EntityRepository;

class UserRepository extends EntityRepository
{
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
}