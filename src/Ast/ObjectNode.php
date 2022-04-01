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
use Serafim\Json5\Json5DecoderInterface;

/**
 * @internal An internal class for Json5 abstract syntax tree node representation
 * @psalm-internal Serafim\Json5
 */
final class ObjectNode extends Expression
{
    /**
     * @param positive-int $offset
     * @param array<array-key, ObjectMemberNode> $values
     */
    public function __construct(int $offset, private array $values)
    {
        parent::__construct($offset);
    }

    /**
     * {@inheritDoc}
     */
    public function reduce(Context $context): array|object
    {
        $result = [];

        if ($context->isDepthOverflow()) {
            $context->depth++;

            foreach ($this->values as $value) {
                /** @var string|int $key */
                $key = $value->key->reduce($context);

                /** @psalm-suppress MixedAssignment */
                $result[$key] = $value->value->reduce($context);
            }

            $context->depth--;
        }

        if ($context->hasOption(Json5DecoderInterface::JSON5_OBJECT_AS_ARRAY)) {
            return $result;
        }

        return (object)$result;
    }
}
