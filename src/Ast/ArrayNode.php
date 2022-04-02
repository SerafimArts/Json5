<?php

/**
 * This file is part of json5 package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Serafim\Json5\Ast;

use Serafim\Contracts\Attribute\Verify;
use Serafim\Json5\Internal\Context;

/**
 * @internal An internal class for Json5 abstract syntax tree node representation
 * @psalm-internal Serafim\Json5
 */
final class ArrayNode extends Expression
{
    /**
     * @param positive-int|0 $offset
     * @param array<Expression> $values
     */
    #[Verify('\PHPUnit\Framework\Assert::assertContainsOnlyInstancesOf(Expression::class, $values) or true')]
    public function __construct(
        int $offset,
        private readonly array $values
    ) {
        parent::__construct($offset);
    }

    /**
     * {@inheritDoc}
     */
    public function reduce(Context $context): array
    {
        if ($context->depth + 1 >= $context->maxDepth) {
            return [];
        }

        $result = [];

        $context->depth++;

        foreach ($this->values as $child) {
            $result[] = $child->reduce($context);
        }

        /** @psalm-suppress PropertyTypeCoercion */
        $context->depth--;

        return $result;
    }
}
