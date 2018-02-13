<?php

namespace App\Listener;

use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;

class PurgeListener
{
    /**
     * @var Container
     */
    private $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function purge(FilterResponseEvent $event): void
    {
        $request = $event->getRequest();
        $response = $event->getResponse();

        if ((preg_match('#^/users/?$#', $request->getPathInfo())
                && $request->getMethod() == 'POST'
                && $response->getStatusCode() == Response::HTTP_CREATED)
            || (preg_match('#^/users/\d+/?$#', $request->getPathInfo())
                && $request->getMethod() == 'DELETE'
                && $response->getStatusCode() == Response::HTTP_OK)) {
            $this->container->get('app.cache_reverse_proxy')
                ->getStore()
                ->purge($this->container->getParameter('host') . '/users/');
        }
    }
}