<?php


namespace App\Normalizer;

use Pagerfanta\Exception\OutOfRangeCurrentPageException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

class NotFoundHttpNormalizer extends AbstractExceptionNormalizer
{
    const STATUS_CODE = 404;

    const MESSAGE = 'Not Found';

    const HANDLED_CLASSES = [
        NotFoundHttpException::class,
        ResourceNotFoundException::class,
        OutOfRangeCurrentPageException::class
    ];

    /**
     * {@inheritdoc}
     */
    public function getStatusCode(): int
    {
        return self::STATUS_CODE;
    }

    /**
     * {@inheritdoc}
     */
    public function getDefaultMessage(): string
    {
        return self::MESSAGE;
    }

    /**
     * {@inheritdoc}
     */
    protected function getHandledClasses(): array
    {
        return self::HANDLED_CLASSES;
    }
}