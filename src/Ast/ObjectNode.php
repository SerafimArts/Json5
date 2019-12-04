<?php

/**
 * This file is part of Json5 package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Serafim\Json5\Ast;

/**
 * @internal An internal class for Json5 abstract syntax tree node representation
 */
final class ObjectNode extends Node
{
    /**
     * @psalm-var array<array-key, ObjectMemberNode>
     *
     * @var ObjectMemberNode[]
     */
    public array $values;

    /**
     * ObjectKeyValueNode constructor.
     *
     * @psalm-param array<array-key, ObjectMemberNode> $pairs
     *
     * @param int $offset
     * @param array|ObjectMemberNode[] $pairs
     */
    public function __construct(int $offset, array $pairs)
    {
        $this->values = $pairs;

        parent::__construct($offset);
    }

    /**
     * @psalm-suppress ImplementedReturnTypeMismatch
     * @psalm-return \Generator<string, array<array-key, ObjectMemberNode>>
     *
     * @return \Traversable
     */
    public function getIterator(): \Traversable
    {
        yield 'values' => $this->values;
    }

    /**
     * {@inheritDoc}
     */
    public function reduce(int $options, int $depth, int $maxDepth)
    {
        $result = [];

        if ($depth + 1 < $maxDepth) {
            foreach ($this->values as $value) {
                /** @var string|int $key */
                $key = $value->key->reduce($options, $depth + 1, $maxDepth);

                /** @psalm-suppress MixedAssignment */
                $result[$key] = $value->value->reduce($options, $depth + 1, $maxDepth);
            }
        }

        return $this->hasOption($options, \JSON_OBJECT_AS_ARRAY) ? $result : (object)$result;
    }
}
