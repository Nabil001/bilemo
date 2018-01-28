<?php

namespace App\Normalizer;

abstract class AbstractNormalizer
{
    public function supports(object $object): bool
    {
        foreach ($this->getHandledClasses() as $handledClass) {
            if (is_a($object, $handledClass)) {
                return true;
            }
        }

        return false;
    }

    public abstract function normalize(object $object): array;

    protected abstract function getHandledClasses(): array;
}