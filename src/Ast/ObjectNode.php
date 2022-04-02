<?php

/**
 * This file is part of json5 package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Serafim\Json5\Ast;

use Serafim\Json5\Internal\Context;
use Serafim\Json5\DecodeFlag;

/**
 * @internal An internal class for Json5 abstract syntax tree node representation
 * @psalm-internal Serafim\Json5
 */
final class ObjectNode extends Expression
{
    /**
     * @param positive-int $offset
     * @param array<array-key, ObjectMemberNode> $pairs
     */
    public function __construct(int $offset, private array $pairs)
    {
        parent::__construct($offset);
    }

    /**
     * {@inheritDoc}
     */
    public function reduce(Context $context): array|object
    {
        $result = [];

        if ($context->depth + 1 < $context->maxDepth) {
            $context->depth++;

            foreach ($this->pairs as $entry) {
                /** @psalm-suppress MixedAssignment */
                $result[$entry->key->reduce($context)] = $entry->value->reduce($context);
            }

            $context->depth--;
        }

        $shouldReturnArray = ($context->options & DecodeFlag::JSON5_OBJECT_AS_ARRAY)
            === DecodeFlag::JSON5_OBJECT_AS_ARRAY;

        return $shouldReturnArray ? $result : (object)$result;
    }
}
