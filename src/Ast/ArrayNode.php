<?php

/**
 * This file is part of Json5 package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Serafim\Json5\Ast;

use Serafim\Json5\Exception\Json5Exception;

/**
 * @internal An internal class for Json5 abstract syntax tree node representation
 */
final class ArrayNode extends Node
{
    /**
     * @var array|Node[]
     */
    public array $values;

    /**
     * BooleanNode constructor.
     *
     * @param int $offset
     * @param array|Node[] $values
     */
    public function __construct(int $offset, array $values)
    {
        $this->values = $values;

        parent::__construct($offset);
    }

    /**
     * @psalm-suppress ImplementedReturnTypeMismatch
     * @psalm-return \Traversable<string, array<array-key, Node>>
     *
     * {@inheritDoc}
     */
    public function getIterator(): \Traversable
    {
        return new \ArrayIterator(['values' => $this->values]);
    }

    /**
     * {@inheritDoc}
     */
    public function reduce(int $options, int $depth, int $maxDepth): array
    {
        if ($depth + 1 >= $maxDepth) {
            return [];
        }

        /** @psalm-suppress MissingClosureReturnType */
        $map = fn (JsonNodeInterface $node) => $node->reduce($options, $depth + 1, $maxDepth);

        return \array_map($map, $this->values);
    }
}
