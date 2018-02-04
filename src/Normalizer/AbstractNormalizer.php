<?php

namespace App\Normalizer;

abstract class AbstractNormalizer
{
    /**
     * @param object $object
     * @return bool
     */
    public function supports(object $object): bool
    {
        foreach ($this->getHandledClasses() as $handledClass) {
            if (is_a($object, $handledClass)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param object $object
     * @return array
     */
    public abstract function normalize(object $object): array;

    /**
     * @return array
     */
    protected abstract function getHandledClasses(): array;
}