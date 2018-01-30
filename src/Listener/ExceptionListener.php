<?php

namespace App\Listener;

use App\Normalizer\AbstractNormalizer;
use JMS\Serializer\Serializer;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;

class ExceptionListener
{
    /**
     * @var array
     */
    private $normalizers = [];

    /**
     * @var Serializer
     */
    private $serializer;

    public function __construct(Serializer $serializer)
    {
        $this->serializer = $serializer;
    }

    public function addNormalizer(AbstractNormalizer $normalizer): void
    {
        $this->normalizers[] = $normalizer;
    }

    public function onKernelException(GetResponseForExceptionEvent $event): void
    {
        $exception = $event->getException();
        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');

        foreach ($this->normalizers as $normalizer) {
            if ($normalizer->supports($exception)) {
                $normalizedException = $normalizer->normalize($exception);
                $response->setStatusCode(
                    $normalizedException['code'] ?? Response::HTTP_BAD_REQUEST
                );
                $response->setContent(
                    $this->serializer->serialize($normalizedException, 'json')
                );

                $event->setResponse($response);

                return;
            }
        }

        $env = $_SERVER['APP_ENV'] ?? 'dev';
        $debug = $_SERVER['APP_DEBUG'] ?? ('prod' !== $env);

        if (!$debug) {
            $response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
            $response->setContent($this->serializer->serialize(
                [
                    'code' => Response::HTTP_INTERNAL_SERVER_ERROR,
                    'exception' => get_class($exception),
                    'message' => $exception->getMessage()
                ],
                'json'
            ));

            $event->setResponse($response);
        }
    }
}