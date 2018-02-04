<?php

namespace App\Normalizer;

use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class BadRequestHttpNormalizer extends AbstractExceptionNormalizer
{
    const STATUS_CODE = 400;

    const MESSAGE = 'Bad Request';

    const HANDLED_CLASSES = [
        BadRequestHttpException::class
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