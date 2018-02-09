<?php

namespace App\Converter;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\GoneHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class UserConverter implements ParamConverterInterface
{
    /**
     * @var TokenStorageInterface
     */
    private $tokenStorage;

    /**
     * @var EntityManagerInterface
     */
    private $manager;

    public function __construct(TokenStorageInterface $tokenStorage, EntityManagerInterface $manager)
    {
        $this->tokenStorage = $tokenStorage;
        $this->manager = $manager;
    }

    /**
     * @param ParamConverter $configuration
     * @return bool
     */
    public function supports(ParamConverter $configuration): bool
    {
        $class = $configuration->getClass();
        $name = $configuration->getName();

        return 'App\Entity\User' == $class && 'user' == $name;
    }

    /**
     * @param Request $request
     * @param ParamConverter $configuration
     */
    public function apply(Request $request, ParamConverter $configuration): void
    {
        $id = $request->get('id');

        if (null == $token = $this->tokenStorage->getToken()) {
            throw new \LogicException('Token from token storage is null. Couldn\'t convert user.');
        }

        if (!is_object($client = $token->getUser())) {
            throw new \LogicException('Client is not authenticated. Couldn\'t convert user.');
        }

        $user = $this->manager->getRepository(User::class)
            ->getClientUser($id, $client);

        if (!$user) {
            throw new NotFoundHttpException(
                sprintf('User %s doesn\'t exist or is not linked with the current client', $id)
            );
        } else if (!empty($user->getDeletedAt())) {
            throw new GoneHttpException(
                sprintf('User %s has already been deleted.', $id)
            );
        }

        $request->attributes->set('user', $user);
    }
}