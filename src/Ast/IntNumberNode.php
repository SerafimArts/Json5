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
class IntNumberNode extends NumberNode
{
    /**
     * @param positive-int|0 $offset
     * @param bool $isPositive
     * @param numeric-string $value
     */
    public function __construct(
        int $offset,
        private readonly bool $isPositive,
        private readonly string $value
    ) {
        parent::__construct($offset);
    }

    /**
     * @param numeric-string $value
     * @param Context $context
     * @param bool $isPositive
     * @return int|float|numeric-string
     */
    public static function eval(string $value, Context $context, bool $isPositive = true): int|float|string
    {
        return (new self(0, $isPositive, $value))->reduce($context);
    }

    /**
     * @param Context $context
     * @return float|int|numeric-string
     *
     * @psalm-suppress MoreSpecificReturnType
     * @psalm-suppress LessSpecificReturnStatement
     */
    public function reduce(Context $context): float|int|string
    {
        // -- int32 on PHP x64/x86
        if ($this->isInt32($this->value)) {
            $integer = (int)$this->value;
            return $this->isPositive ? $integer : -$integer;
        }

        $shouldCastToString = ($context->options & DecodeFlag::JSON5_BIGINT_AS_STRING)
            === DecodeFlag::JSON5_BIGINT_AS_STRING;

        if ($shouldCastToString) {
            return $this->isPositive ? $this->value : '-' . $this->value;
        }

        // -- int64 on PHP x64
        if (\PHP_INT_SIZE === 8 && $this->isInt64($this->value)) {
            $integer = (int)$this->value;
            return $this->isPositive ? $integer : -$integer;
        }

        $float = (float)$this->value;
        return $this->isPositive ? $float : -$float;
    }
}
