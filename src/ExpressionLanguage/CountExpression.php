<?php

namespace App\ExpressionLanguage;

use Hateoas\Expression\ExpressionFunctionInterface;

class CountExpression implements ExpressionFunctionInterface
{
    public function getName(): string
    {
        return 'count';
    }

    public function getCompiler(): callable
    {
        return function ($countable) {
            return sprintf(
                'is_a(%1%s, \Countable::class) ? count(%1%s) : %1%s',
                $countable
            );
        };
    }

    public function getEvaluator(): callable
    {
        return function ($arguments, $countable) {
            if (!is_a($countable, \Countable::class)) {
                return $countable;
            } else {
                return count($countable);
            }
        };
    }

    public function getContextVariables(): array
    {
        return ['array'];
    }

}