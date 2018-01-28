<?php


namespace App\Normalizer;

abstract class AbstractExceptionNormalizer extends AbstractNormalizer
{
    public function normalize(object $object): array
    {
        $env = $_SERVER['APP_ENV'] ?? 'dev';
        $debug = $_SERVER['APP_DEBUG'] ?? ('prod' !== $env);

        return [
            'code' => $this->getStatusCode(),
            'message' => $debug ? $object->getMessage() : $this->getDefaultMessage()
        ];
    }

    public abstract function getStatusCode(): int;

    public abstract function getDefaultMessage(): string;
}