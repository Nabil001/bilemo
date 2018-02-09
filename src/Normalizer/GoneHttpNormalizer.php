<?php


namespace App\Normalizer;

use Symfony\Component\HttpKernel\Exception\GoneHttpException;

class GoneHttpNormalizer extends AbstractExceptionNormalizer
{
    const STATUS_CODE = 410;

    const MESSAGE = 'Gone';

    const HANDLED_CLASSES = [
        GoneHttpException::class,
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