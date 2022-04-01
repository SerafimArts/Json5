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
class IntNumberNode extends NumberNode
{
    /**
     * @param positive-int|0 $offset
     * @param bool $isPositive
     * @param numeric-string $value
     */
    public function __construct(int $offset, private bool $isPositive, private string $value)
    {
        parent::__construct($offset);
    }

    /**
     * @param numeric-string $value
     * @param Context $context
     * @return int|float|string
     */
    public static function eval(string $value, Context $context): int|float|string
    {
        return (new self(0, true, $value))->reduce($context);
    }

    /**
     * {@inheritDoc}
     */
    public function reduce(Context $context): float|int|string
    {
        $integer = (int)$this->value;
        if ($this->isInt32($integer)) {
            return $this->isPositive ? $integer : -$integer;
        }

        $shouldCastToString = ($context->options & Json5DecoderInterface::JSON5_BIGINT_AS_STRING)
            === Json5DecoderInterface::JSON5_BIGINT_AS_STRING;

        if ($shouldCastToString) {
            return $this->isPositive ? $this->value : '-' . $this->value;
        }

        return $this->isPositive ? $integer : -$integer;
    }
}
